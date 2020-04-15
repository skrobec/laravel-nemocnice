<template>
<div class="full">

    <div class="wrap">
        <h1>Oddělení</h1>
        <div class="section-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenSection" type="text" v-model="chosenSection">
            </div>
            <div class="section-block">
                <div class="section-item" v-for="section of filteredResults" v-bind:key="section.id">
                    <span>Jméno: {{section.name}}</span>
                    <span>Kapacita: {{section.capacity}}</span>
                    <div v-on:click="deleteSection(section.id)" class="delete">
                        <i class="material-icons">clear</i>
                    </div>
                    <div v-on:click="prepareEdit(section.id)" class="edit">
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
                        <label for="capacity">Kapacita</label>
                        <input type="text" class="form-control standard-input shadow-none" name="capacity" id="capacity" v-model="fields.capacity" />
                        <div v-if="errors && errors.capacity" class="text-danger">{{ errors.capacity[0] }}</div>
                    </div>


                    <button v-if="!editing" type="submit" class="btn btn-primary">Přidat</button>
                    <button v-if="editing" v-on:click="editSection()" class="btn btn-primary">Upravit</button>
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
    .section-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .section-block {
        width: 60%;
    }
    .section-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .section-item span {
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
      sections: [],
      chosenSection: '',
      section: {
          id: '',
          name: '',
          capacity: '',
          problem: ''
      },
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      sectionId: 0,
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
      this.getSections();


  },
  computed: {
    filteredResults () {
      return this.chosenSection ? this.sections.filter(row => row.name.search(new RegExp(`${this.chosenSection}`, 'i')) !== -1) : this.sections
    }
  },
  methods: {

    prepareEdit(id){
        const section = this.sections.find(pat => pat.id == id);
        this.fields.name = section.name;
        this.fields.capacity = section.capacity;
        this.editing = true;
        this.sectionId = id;
    },
    getSections(){
        axios.get('/sections/getAll').then(response => {
          console.log(this.enterId);
          this.sections = response.data;
        });
    },
    deleteSection(id){
        this.fields.id = id;
        axios.post('/sections/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getSections();
        });
    },
    editSection(id){
        if (this.loaded) {
            this.editing = false;
            this.loaded = false;
            this.success = false;
            this.errors = {};
            this.fields.id = this.sectionId;
            axios.post('/sections/edit', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.loaded = true;
            this.success = true;
            this.getSections();
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
        axios.post('/sections/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.getSections();
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
