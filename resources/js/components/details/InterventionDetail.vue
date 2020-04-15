<template>
<div class="screen-center">
  <div class="middle-container">
    <h2>Zákrok</h2>
    <div class="patient-info">
        <div class="title-box">
            <h4>Datum</h4>
            <div>{{this.interventionObj.date}}</div>
        </div>
        <div class="title-box">
            <h4>Průběh</h4>
            <div>{{this.interventionObj.record}}</div>
        </div>
    </div>
    <div class="participants-container">
        <div class="lists">
            <div class="nurses-list">
                <div class="title-box">
                    <h4>Sestry</h4>
                    <i v-on:click="clearNurses()" class="material-icons cursor right-m">clear</i>
                </div>
                <div class="inner-list" v-for="nurse of chosenNurses" v-bind:key="nurse.id">Jméno: {{nurse.user.name}}</div>
            </div>
            <div class="doctors-list">
                <div class="title-box">
                    <h4>Doktoři</h4>
                    <i v-on:click="clearDoctors()" class="material-icons cursor right-m">clear</i>
                </div>
                <div class="inner-list" v-for="doc of chosenDoctors" v-bind:key="doc.id">Jméno: {{doc.user.name}}</div>
            </div>
        </div>
        <div class="autocompletes">
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
            <button v-on:click="addNurse()" class="btn btn-primary">Přidat sestru</button>
            </div>
            <div class="left"><label for="nurse">Doktor</label></div>
            <div  class="wrap-detail">
            <div class="auto-container">
                <input class="form-control standard-input shadow-none" id="doctor" type="text" v-model="doctor">
                <div class="option-container scroll">
                    <ul v-if="filteredDoctors.length > 0">
                        <li class="option" v-on:click="setDoctor(result.id)"  v-for="result in filteredDoctors" :key="result.id" v-text="result.name"></li>
                    </ul>
                </div>
            </div>
            <button v-on:click="addDoctor()" class="btn btn-primary">Přidat doktora</button>
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
                        <textarea type="text" class="form-control standard-input shadow-none" name="record" id="record" v-model="fields.record" />
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>


                    <button v-if="!editing" type="submit" class="btn btn-primary">Přidat</button>
                    <button v-if="editing" v-on:click="editintervention()" class="btn btn-primary">Upravit</button>
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
    .middle-container {
      width: 600px;

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
      interventionObj: {
          date: '',
          record: ''
      },
      chosenNurses: [],
      chosenDoctors: [],
      doctors: [],
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      nurses: [],
      patients: [],
      nurse: '',
      doctor: '',
      loadedIntervention: {
          date: ''
      },
      loadedNurse: {
          name: ''
      },
      patientObj: {
          name: ''
      },
      nurseObj: {
          name: ''
      },
      drugObj: {
          name: ''
      },
      doctorObj: {
        name: ''
      },
      patientId: '',
      interventionId: ''
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      this.patientId = urlParams.searchParams.get('patientId');
      this.interventionId = urlParams.searchParams.get('interventionId');

      if (this.patientId !== undefined && this.patientId !== null ) {
        this.getInfo();
      }

  },
  computed: {
    filteredNurses () {
      return this.nurse ? this.nurses.filter(row => row.name.search(new RegExp(`${this.nurse}`, 'i')) !== -1) : this.nurses;
    },
    filteredDoctors () {
      return this.doctor ? this.doctors.filter(row => row.name.search(new RegExp(`${this.doctor}`, 'i')) !== -1) : this.doctors;
    }
  },
  methods: {
    clearNurses(){
        this.chosenNurses = [];
    },
    clearDoctors(){
        this.chosenDoctors = [];
    },
    setNurse(result) {
        this.nurse = this.nurses.find(nurse => nurse.id == result ).name;
        this.nurseObj = this.nurses.find(nurse => nurse.id == result );
    },
    setDoctor(result) {
        this.doctor = this.doctors.find(doc => doc.id == result ).name;
        this.doctorObj = this.doctors.find(doc => doc.id == result );
    },
    addNurse() {

        const contains = this.chosenNurses ? this.chosenNurses.find( nurse => nurse.id == this.nurseObj.id ) : undefined;
        if (this.nurseObj !== undefined && (contains === undefined || contains === null )){
            if (this.nurseObj.id !== undefined) {
                this.chosenNurses.push(this.nurseObj);
            }

        }
    },
    addDoctor() {

        const contains =  this.chosenDoctors.find( doc => doc.id == this.doctorObj.id );
        if (this.doctorObj !== undefined && (contains === undefined || contains === null )){
            if (this.doctorObj.id !== undefined) {
                this.chosenDoctors.push(this.doctorObj);
            }
        }
    },
    getInfo(){

        axios.get('/user/getNurses').then(response => {
          this.nurses = response.data;
          return  axios.get('/pat/get');
        }).then( response => {
            this.patients = response.data;
            this.patientObj = this.patients.find(pat => pat.id == this.patientId );
            console.log('data');
            console.log(this.nurses);
            this.chosenNurses = [];
            console.log(this.chosenNurses);
            console.log(this.patients);

            return  axios.get('/user/getDoctors');
        }).then( response => {
            this.doctors = response.data;
            if (this.interventionId !== undefined && this.interventionId !== null ) {
                this.getEditInfo();
            }
        });
    },
    getEditInfo(){

        axios.post('/intervention/getInfo',{id: this.interventionId}).then(response => { // TODO need more data
            this.interventionObj = response.data;
            this.chosenNurses = this.interventionObj.nurses;
            this.chosenDoctors = this.interventionObj.doctors;
        });
    },
    relink() {
      window.history.pushState({}, '', "http://homestead.test/patients"  + '?' + this.parentData.id);
    },
    submit() {
        if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        this.fields.nurses = this.chosenNurses.map(a => a.userable_id);
        this.fields.doctors = this.chosenDoctors.map(a => a.userable_id);
        this.fields.patient_id = this.patientObj.id;
        console.log(this.fields);
        axios.post('/interventions/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.interventionId = response.id;
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
