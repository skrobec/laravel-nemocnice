<template>
<div class="screen-center">
  <div class="middle-container">
    <h2>Vyšetření</h2>
    <div class="patient-info">
        <div class="title-box">
            <h4>Datum</h4>
            <div>{{this.loadedExam.date}}</div>
        </div>
        <div class="title-box">
            <h4>Pacient</h4>
            <a :href="'/patients?id='+this.patientId"><h4>{{this.patientObj.name}}</h4></a>
        </div>
        <div class="title-box">
            <h4>Doktor</h4>
            <h4>{{this.loadedDoctor.name}}</h4>
        </div>
        <div class="title-box">
            <h4>Sestra</h4>
            <h4>{{this.loadedNurse.name}}</h4>
        </div>
        <div class="title-box">
            <h4>Průběh</h4>
            <h4>{{this.loadedExam.record}}</h4>
        </div>
    </div>
    <div class="left"><label for="doctor">Doktor</label></div>
    <div  class="wrap-detail">
      <div class="auto-container">
          <input class="form-control standard-input shadow-none" id="doctor" type="text" v-model="doctor">
          <div class="option-container scroll">
              <ul v-if="filteredDoctors.length > 0">
                  <li class="option" v-on:click="setDoctor(result.id)"  v-for="result in filteredDoctors" :key="result.id" v-text="result.name"></li>
              </ul>
          </div>
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
    </div>

    <div class="forms-container">
            <div class="form-block">
                <form @submit.prevent="submit">
                    <div class="form-group input-container">
                        <label for="date">Datum</label>
                        <input placeholder="YYYY-MM-DD HH:MM:SS" type="text" class="form-control standard-input shadow-none" name="date" id="date" v-model="fields.date" />
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group input-container">
                        <label for="record">Průběh</label>
                        <input type="text" class="form-control standard-input shadow-none" name="record" id="record" v-model="fields.record" />
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>


                    <button type="submit" class="btn btn-primary">Přidat</button>
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
    .list {
      max-height: 200px;
      overflow: auto;
      width: 100%;
      display: flex;
      justify-content: flex-start;
    }
    .wrap-detail {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
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
    .left {
      display: flex;
      justify-content: flex-start;
      width: 300px;
    }
    .titles {
        margin-top: 10px;
    }
    .forms-container {
        width: 300px;
    }
    .form-block {
        width: 300px;
    }

</style>

<script>
export default {
  data() {
    return {
      examObj: {
          date: ''
      },
      doctor: '',
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      doctors: [],
      exams: [],
      nurses: [],
      patients: [],
      nurse: '',
      loadedExam: {
          date: ''
      },
      loadedNurse: {
          name: ''
      },
      loadedDoctor: {
          name: ''
      },
      patientObj: {
          name: ''
      },
      drugObj: {
          name: ''
      },
      patientId: '',
      examId: '',
      buffer: []
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      this.patientId = urlParams.searchParams.get('patientId');
      this.examId = urlParams.searchParams.get('examId');

      if (this.patientId !== undefined && this.patientId !== null ) {
        this.getInfo();
      }



  },
  computed: {
    filteredDoctors () {
      return this.doctor ? this.doctors.filter(row => row.name.search(new RegExp(`${this.doctor}`, 'i')) !== -1) : this.doctors;
    },
    filteredNurses () {
      return this.nurse ? this.nurses.filter(row => row.name.search(new RegExp(`${this.nurse}`, 'i')) !== -1) : this.nurses;
    }

  },
  methods: {
    setSection(result) {
        this.section = this.sections.find(section => section.id == result ).name;
        this.sectionObj = this.sections.find(section => section.id == result );
    },
    setDoctor(result) {
        this.doctor = this.doctors.find(doctor => doctor.id == result ).name;
        this.doctorObj = this.doctors.find(doctor => doctor.id == result );
    },
    setNurse(result) {
        this.nurse = this.nurses.find(nurse => nurse.id == result ).name;
        this.nurseObj = this.nurses.find(nurse => nurse.id == result );
    },
    getInfo(){

        axios.get('/exams/getAll').then(response => {
          this.buffer = response.data;
          return  axios.get('/pat/get');
        }).then( response => {
            this.patients = response.data;
            this.patientObj = this.patients.find(pat => pat.id == this.patientId );
            return  axios.get('/user/getDoctors');

        }).then( response => {

             this.doctors = response.data;
            return  axios.get('/user/getNurses');
        }).then( response => {

            this.nurses = response.data;
            this.exams = this.buffer;
            if (this.examId !== undefined && this.examId !== null ) {
                    this.getEditInfo();
            }
        });;
    },
    getEditInfo(){

        axios.post('/exam/getInfo',{id: this.examId}).then(response => {
          this.loadedExam = response.data;
          console.log(this.loadedExam);
          console.log('gangow');
          this.loadedNurse = this.nurses.find(section => section.userable_id == this.loadedExam.doctor_id );
          this.loadedDoctor = this.doctors.find(section => section.userable_id == this.loadedExam.nurse_id );

        });
    },
    relink() {
      window.history.pushState({}, '', "http://homestead.test/patients"  + '?' + this.patientObj.id);
    },
    submit() {
        if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        this.fields.patientId = this.patientObj.id;
        this.fields.sectionId = this.sectionObj.id;
        axios.post('/exam/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.examId = response.id;
          this.getEditInfo();
        }).catch(error => {
          this.loaded = true;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
      }
    }
  },
}
</script>
