<template>
<div class="full">
    <div v-if="detail" class="full">
        <patient-detail :parentData="detailProp" v-on:detailToForm="hideDetail"></patient-detail>
    </div>
    <div v-else class="wrap">
        <h1>Pacienti</h1>
        <div class="patient-container">
            <div class="patient-block">
                <div class="patient-item" v-for="patient of patients" v-bind:key="patient.name">
                    <span>Jméno: {{patient.name}}</span>
                    <span>Přijmení: {{patient.surname}}</span>
                    <span>Potíže: {{patient.issues}}</span>
                    <div v-on:click="connect(patient.id)" class="connect">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deletePatient(patient.id)" class="delete">
                        <i class="material-icons">clear</i>
                    </div>
                    <div v-on:click="prepareEdit(patient.id)" class="edit">
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
                        <label for="email">Přijmení</label>
                        <input type="text" class="form-control standard-input shadow-none" name="surname" id="surname" v-model="fields.surname" />
                        <div v-if="errors && errors.surname" class="text-danger">{{ errors.surname[0] }}</div>
                    </div>
                
                    <div class="form-group input-container">
                        <label for="issues">Problémy</label>
                        <textarea class="form-control shadow-none" id="issues" name="issues" rows="5" v-model="fields.issues"></textarea>
                        <div v-if="errors && errors.issues" class="text-danger">{{ errors.issues[0] }}</div>
                    </div>

                    <button v-if="!editing" type="submit" class="btn btn-primary">Submit</button>
                    <button v-if="editing" v-on:click="editPatient()" class="btn btn-primary">Edit</button>
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
    .patient-container {
        display: flex;
        justify-content: center;
    }
    .form-block {
        width: 60%;
    }
    .patient-block {
        width: 60%;
    }
    .patient-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .patient-item span {
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

//import Child from './components/details/PatientDetail.vue';
export default {
  data() {
    return {
      patients: [],
      patient: {
          id: '',
          name: '',
          surname: '',
          problem: ''
      },
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      detail: false,
      detailProp: {}
    }
  },
  created(){
      this.getPatients();
  },
  methods: {
    hideDetail(value){
        this.detail = false;
    },
    connect(id){
        this.detailProp = this.patients.find(pat => pat.id === id);
        this.detail = true;
    },
    prepareEdit(id){
        const patient = this.patients.find(pat => pat.id === id);
        this.fields.name = patient.name;
        this.fields.surname = patient.surname;
        this.fields.issues = patient.issues;
        this.editing = true;
        this.patientId = id;
    },
    getPatients(){
        axios.get('/patients/get').then(response => {
          console.log(response);
          this.patients = response.data;
        });
    },
    deletePatient(id){
        this.fields.id = id;
        axios.post('/patients/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getPatients();
        });
    },
    editPatient(id){
        if (this.loaded) {
            this.editing = false;
            this.loaded = false;
            this.success = false;
            this.errors = {};
            this.fields.id = this.patientId;
            axios.post('/patients/edit', this.fields).then(response => {
            console.log(response);
            this.fields = {}; 
            this.loaded = true;
            this.success = true;
            this.getPatients();
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
        axios.post('/patients/add', this.fields).then(response => {
          console.log(response);
          this.fields = {}; 
          this.loaded = true;
          this.success = true;
          this.getPatients();
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