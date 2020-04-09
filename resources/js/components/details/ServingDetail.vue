<template>
<div class="screen-center">
  <div class="middle-container">
    <div class="back-cont">
      <div v-on:click="back()" class="back">
          <i class="material-icons">arrow_back</i>
      </div>
    </div>
    <h2>Datum: {{serving.date}}</h2>
    <div class="patient-info">
      <div class="doctor">

      </div>
      <div class="exams list scroll">
        <h4>Pacient</h4>
        <div>{{patient.date}}</div>
      </div>
      <div class="servings list scroll">
        <h4>Sestra</h4>
        <div>Jméno: {{nurse.name}}</div>
      </div>

    </div>
    <div class="left"><label for="nurse">Sestra</label></div>
    <div  class="wrap-detail">
      <div class="auto-container">
          <input class="form-control standard-input shadow-none" id="nurse" type="text" v-model="nurse">
          <div class="option-container scroll">
              <ul v-if="filteredNurses.length > 0">
                  <li class="option" v-on:click="setNurse(result.id)"  v-for="result in filteredNurses" :key="result.id" v-text="result.name"></li>
              </ul>
          </div>
      </div>
      <div class="left"><label for="patient">Pacient</label></div>
      <div class="auto-container">
          <input class="form-control standard-input shadow-none" id="patient" type="text" v-model="patient">
          <div class="option-container scroll">
              <ul v-if="filteredPatients.length > 0">
                  <li class="option" v-on:click="setPatient(result.id)"  v-for="result in filteredPatients" :key="result.id" v-text="result.name"></li>
              </ul>
          </div>
      </div>
    </div>

  </div>
</div>


</template>


<style>
    .list {
      max-height: 200;
      overflow: auto;
      width: 100%;
      display: flex;
      justify-content: flex-start;
    }
    .wrap-detail {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .option {
        cursor: pointer;
    }
    .option-container {
        width: 300px;
        overflow: auto;
        height: 50px;
        margin-top: 40px;
    }
    .auto-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .back {
      height: 50px;
      width: 50px;
      font-size: 50px;
      margin-right: -50px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .back i{
        font-size: 50px;
    }
    .back-cont {
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }
    .patient-info {
      margin-top: 60px;
      margin-bottom: 30px;
      width: 100%;

    }
    .middle-container {
      width: 600px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .left {
      display: flex;
      justify-content: flex-start;
    }

</style>

<script>
export default {
  data() {
    return {
      hospitalizations: [],
      servings: [],
      exams: [],
      interventions: [],
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      nurses: [],
      patients: [],
      nurse: '',
      patient: '',
      patientInfo: '',
      nurseInfo: '',
    }
  },
  created(){
      this.getInfo();
  },
  props: {
    parentData: Object
  },
  computed: {
    filteredNurses () {
      return this.nurse ? this.nurses.filter(row => row.name.search(new RegExp(`${this.nurse}`, 'i')) !== -1) : this.nurses
    },
    filteredPatients () {
      return this.patient ? this.patients.filter(row => row.name.search(new RegExp(`${this.patient}`, 'i')) !== -1) : this.patients
    }
  },
  methods: {
    back(){
        this.$emit('detailToForm', 'hide')
    },
    setNurse(result) {
        axios.post('/serving/setNurse',{id: this.parentData.id, nurseId: result}).then(response => {
            this.getInfo();
        });
        this.nurse = result;
    },
    setPatient(result) {
        axios.post('/serving/setPatient',{id: this.parentData.id, patientId: result}).then(response => {
            this.getInfo();
        });
        this.patient = result;
    },
    getInfo(){
        axios.post('/serving/getInfo',{id: this.parentData.id}).then(response => {
          this.serving = response;
          return  axios.get('/nurse/getAll');
        }).then( response => {
          this.nurses = response.data;
          this.nurseInfo = this.nurses.find(nurse => nurse.id == this.serving.nurde_id ).name;
          return  axios.get('/pat/get');  
        }).then( response => {
          this.patients = response.data;  
          this.patientInfo = this.patients.find(pat => pat.id == this.serving.patient_id ).name;
          console.log(this.serving);
          console.log( this.nurses);
          console.log(this.patients);
        });

       
    },
    relink() {
      window.history.pushState({}, '', "http://homestead.test/servings"  + '?' + this.parentData.id);

    }
  },
}
</script>
