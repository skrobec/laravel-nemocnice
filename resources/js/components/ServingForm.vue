<template>
<div class="full">
    <div v-if="detail" class="full">
        <serving-detail></serving-detail>
    </div>
    <div v-else class="wrap">
        <h1>Podání</h1>
        <div class="serving-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenServing" type="text" v-model="chosenServing">
            </div>
            <div class="serving-block">
                <div class="serving-item" v-for="serving of filteredResults" v-bind:key="serving.id">
                    <span>Datum: {{serving.date}}</span>
                    <span>Jméno pacienta: {{getPatient(serving.patient_id)}}</span>
                    <div v-on:click="connect(serving.id,serving.patient_id)" class="connect">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deleteServing(serving.id)" class="delete">
                        <i class="material-icons">clear</i>
                    </div>
                </div>
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
    .serving-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .serving-block {
        width: 60%;
    }
    .serving-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .serving-item span {
        font-weight: 300;
        font-size: 1.1em;
    }
    .wrap {
        width: 100%;
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
      servings: [],
      chosenServing: '',
      serving: {},
      patients: [],
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      servingId: 0,
      detail: false,
      detailProp: {},
      buffer: []
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
      this.getServings();


  },
  computed: {
    filteredResults () {
      return this.chosenServing ? this.servings.filter(row => row.date.search(new RegExp(`${this.chosenServing}`, 'i')) !== -1) : this.servings
    }
  },
  methods: {
    getPatient(id){
        console.log(this.patients);
        console.log(id);
        return this.patients.find(pat => pat.id == id).name;
    },
    connect(id,patient_id){
         window.location.href = "http://homestead.test/" + "servingDetail" + "?servingId=" + id + '&patientId=' + patient_id ;
    },
    prepareEdit(id){
        const serving = this.servings.find(pat => pat.id == id);
        this.fields.name = serving.name;
        this.fields.surname = serving.surname;
        this.fields.issues = serving.issues;
        this.editing = true;
        this.servingId = id;
    },
    getServings(){
        axios.get('/servings/getAll').then(response => {
          console.log(this.enterId);
          this.buffer = response.data;
         
        });
        axios.get('/pat/get').then(response => {

         if (this.enterId !== 0) {
            this.connect(this.enterId);
          }
         this.patients = response.data;   
         this.servings = this.buffer;

        });
    },
    deleteServing(id){
        this.fields.id = id;
        axios.post('/servings/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getServings();
        });
    },
    editServing(id){
        if (this.loaded) {
            this.editing = false;
            this.loaded = false;
            this.success = false;
            this.errors = {};
            this.fields.id = this.servingId;
            axios.post('/servings/edit', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.loaded = true;
            this.success = true;
            this.getServings();
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
        axios.post('/servings/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.getServings();
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
