<template>
<div class="full">

    <div class="wrap">
        <h1>Léky</h1>
        <div class="drug-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenDrug" type="text" v-model="chosenDrug">
            </div>
            <div class="drug-block">
                <div class="drug-item" v-for="drug of filteredResults" v-bind:key="drug.name">
                    <span>Jméno: {{drug.name}}</span>
                    <span>Popis: {{drug.description}}</span>
                    <div v-on:click="deleteDrug(drug.id)" class="delete">
                        <i class="material-icons">clear</i>
                    </div>
                    <div v-on:click="prepareEdit(drug.id)" class="edit">
                        <i class="material-icons">edit</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-container">
            <div class="form-block">
                <form @submit.prevent="submit">
                    <div class="form-group input-container">
                        <label for="name">Jméno</label>
                        <input type="text" class="form-control standard-input shadow-none" name="name" id="name" v-model="fields.name" />
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group input-container">
                        <label for="email">Popis</label>
                        <input type="text" class="form-control standard-input shadow-none" name="description" id="description" v-model="fields.description" />
                        <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
                    </div>


                    <button v-if="!editing" type="submit" class="btn btn-primary">Přidat</button>
                    <button v-if="editing" v-on:click="editDrug()" class="btn btn-primary">Upravit</button>
                    <div v-if="success" class="alert alert-success mt-3">
                        Úspěšně provedeno !
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>


<style>
    .input-block {
        width: 30%;
        margin-bottom: 30px;
    }
    .full {
        height: 100%;
    }
    .input-container {
       text-align: start;
    }
    label {
        font-size: 1.2em;
        font-weight: 400;
    }
    .form-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    .drug-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .drug-block {
        width: 60%;
    }
    .drug-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .drug-item span {
        font-weight: 300;
        font-size: 1.1em;
    }
    .wrap {
        margin-top: 100px;
        margin-bottom: 100px;
    }
    .connect {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 2px;
        right: 68px;
    }
    .delete {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 2px;
        right: 2px;
    }
    .edit {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 2px;
        right: 35px;
    }
    .delete:hover {
        cursor: pointer;
    }
    .edit:hover {
        cursor: pointer;
    }
    .connect:hover {
        cursor: pointer;
    }

</style>

<script>

export default {
  data() {
    return {
      drugs: [],
      chosenDrug: '',
      drug: {
          id: '',
          name: '',
          description: '',
          problem: ''
      },
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      drugId: 0,
      detail: false,
      detailProp: {}
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      const id = urlParams.searchParams.get('id');
      console.log(id);

      if (id !== null && id !== undefined) {
          this.enterId = id;
      }
      this.getDrugs();


  },
  computed: {
    filteredResults () {
      return this.chosenDrug ? this.drugs.filter(row => row.name.search(new RegExp(`${this.chosenDrug}`, 'i')) !== -1) : this.drugs
    }
  },
  methods: {

    prepareEdit(id){
        const drug = this.drugs.find(pat => pat.id == id);
        this.fields.name = drug.name;
        this.fields.description = drug.description;
        this.editing = true;
        this.drugId = id;
    },
    getDrugs(){
        axios.get('/drugs/getAll').then(response => {
          console.log(this.enterId);
          this.drugs = response.data;
        });
    },
    deleteDrug(id){
        this.fields.id = id;
        axios.post('/drugs/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getDrugs();
        });
    },
    editDrug(id){
        if (this.loaded) {
            this.editing = false;
            this.loaded = false;
            this.success = false;
            this.errors = {};
            this.fields.id = this.drugId;
            axios.post('/drugs/edit', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.loaded = true;
            this.success = true;
            this.getDrugs();
            }).catch(error => {
            this.loaded = true;
            if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
            }
            });
      }
    },
    submit() {
      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        axios.post('/drugs/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.getDrugs();
        }).catch(error => {
          this.loaded = true;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
      }
    },
  },
}
</script>
