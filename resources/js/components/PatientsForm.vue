<template>
<div class="full">
    <div v-if="detail" class="full">
        <patient-detail :parentData="detailProp" v-on:detailToForm="hideDetail"></patient-detail>
    </div>
    <div v-else class="wrap">
        <h1>Pacienti</h1>
        <div class="patient-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenPatient" type="text" v-model="chosenPatient">
            </div>
            <div class="patient-block">
                <div class="patient-item" v-for="patient of filteredResults" v-bind:key="patient.id">
                    <span>Jméno: {{patient.name}}</span>
                    <span>Potíže: {{patient.issues}}</span>
                    <div v-on:click="connect(patient.id)" class="p_connect cursor">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deletePatient(patient.id)" class="p_delete cursor">
                        <i class="material-icons">clear</i>
                    </div>
                    <div v-on:click="prepareEdit(patient.id)" class="p_edit cursor">
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
                        <label for="issues">Problémy</label>
                        <textarea class="form-control shadow-none" id="issues" name="issues" rows="5" v-model="fields.issues"></textarea>
                        <div v-if="errors && errors.issues" class="text-danger">{{ errors.issues[0] }}</div>
                    </div>

                    <button v-if="!editing" type="submit" class="btn btn-primary">Přidat</button>
                    <button v-if="editing" v-on:click="editPatient()" class="btn btn-primary">Upravit</button>
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
    .patient-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
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
    .p_connect {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 2px;
        right: 68px;
    }
    .p_delete {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 2px;
        right: 2px;
    }
    .p_edit {
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
      patients: [],
      chosenPatient: '',
      patient: {
          id: '',
          name: '',
          problem: ''
      },
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
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
      this.getPatients();


  },
  computed: {
    filteredResults () {
      return this.chosenPatient ? this.patients.filter(row => row.name.search(new RegExp(`${this.chosenPatient}`, 'i')) !== -1) : this.patients
    }
  },
  methods: {

    hideDetail(value){
        this.detail = false;
        this.connectId = 0;
        window.history.replaceState({}, '',  "http://homestead.test/patients");
    },
    connect(id){
        window.history.replaceState({}, '', "http://homestead.test/patients" + '?id=' + id);
        this.detailProp = this.patients.find(pat => pat.id == id);
         console.log(id);
        console.log(this.patients);
        this.detail = true;
    },
    prepareEdit(id){
        const patient = this.patients.find(pat => pat.id == id);
        this.fields.name = patient.name;
        this.fields.issues = patient.issues;
        this.editing = true;
        this.patientId = id;
    },
    getPatients(){
        axios.get('/pat/get').then(response => {
          console.log(this.enterId);
          this.patients = response.data;
          if (this.enterId !== 0) {
            this.connect(this.enterId);
          }
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
