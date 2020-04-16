<template>
<div class="screen-center">
  <div class="middle-container">
    <div class="back-cont">
      <div v-on:click="back()" class="back">
          <i class="material-icons">arrow_back</i>
      </div>
    </div>
    <h2>Pacient: {{parentData.name}}</h2>
    <div class="patient-info">
      <div class="doctor">

      </div>
      <div class="exams list scroll">

        <div class="title-box">
            <h4>Prohlídky</h4>
            <div class="ico-box cursor" v-on:click="link('examDetail')">
                Přidat prohlídku <i class="material-icons">add</i>
            </div>
        </div>
        <div v-for="exam of exams" v-bind:key="exam.id">
            <a :href="'examDetail?examId=' + exam.id + '&patientId='+exam.patient_id">{{exam.date | moment('DD.MM.YYYY')}}</a>
        </div>
      </div>
      <div class="servings list scroll">
        <div class="title-box">
            <h4>Podání léků</h4>
            <div class="ico-box cursor" v-on:click="link('servingDetail')">
                Přidat podání <i class="material-icons">add</i>
            </div>
        </div>
        <div v-for="serving of servings" v-bind:key="serving.id">Datum: {{serving.date}}</div>
      </div>
      <div class="hospitalization list scroll">
         <div class="title-box">
            <h4>Hospitalizace</h4>
            <div class="ico-box cursor" v-on:click="link('hospitalizationDetail')">
                Přidat hospitalizaci <i class="material-icons">add</i>
            </div>
        </div>
        <div v-for="hosp of hospitalizations" v-bind:key="hosp.id">Začátek: {{hosp.date_start}} Konec: {{hosp.date_end}} </div>
      </div>
      <div class="interventions list scroll">
        <div class="title-box">
            <h4>Zákroky</h4>

            <div class="ico-box cursor" v-on:click="link('interventionDetail')">
                Přidat zákrok <i class="material-icons">add</i>
            </div>


        </div>
        <div v-for="int of interventions" v-bind:key="int.id">Datum: {{int.date}}</div>
      </div>

    </div>
    <div class="left"><label for="doctor">Doktor</label></div>
    <div  class="wrap-detail">
      <div class="auto-container">

          <input class="form-control standard-input shadow-none" id="doctor" type="text" v-model="doctor">
          <div class="option-container scroll">
              <ul v-if="filteredResults.length > 0">
                  <li class="option" v-on:click="setDoc(result)"  v-for="result in filteredResults" :key="result.id" v-text="result.name"></li>
              </ul>
          </div>
      </div>
    </div>

  </div>
</div>


</template>


<style>
    .details {
      display: flex;
      width: 200px;
      justify-content: space-between;
    }
    .list {
      max-height: 200px;
      overflow: auto;
      width: 100%;
      display: flex;
      justify-content: flex-start;
      flex-direction: column;
      align-items: flex-start;
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
      doctors: [],
      current_doctor: '',
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      doctor: '',
      warning: false,
    }
  },
  created(){
      this.getInfo();
  },
  props: {
    parentData: Object
  },
  computed: {
    filteredResults () {
      return this.doctor ? this.doctors.filter(row => row.name.search(new RegExp(`${this.doctor}`, 'i')) !== -1) : this.doctors
    }
  },
  methods: {
    back(){
        this.$emit('detailToForm', 'hide')
    },
    setDoc(result) {
        this.doctor = result;
        this.setDoctor();
    },
    getInfo(){
        axios.post('/patient/getInfo',{id: this.parentData.id}).then(response => {
            this.exams = response.data.exams;
            this.hospitalizations = response.data.hospitalizations;
            this.interventions = response.data.interventions;
            this.servings = response.data.servings;
            this.warning = true;
            return axios.get('/user/getDoctors');
        }).then( response => {
            this.doctors = response.data;
        });
    },
    relink() {
      window.history.pushState({}, '', "http://homestead.test/patients"  + '?' + this.parentData.id);

    },
    link(destination, parameter) {
      window.location.href = "http://homestead.test/" + destination + "?patientId=" + this.parentData.id;
    },
    setDoctor(){
      if (this.loaded) {

        const docId = doctors.find(doc => doc.name === this.doctor).id;
        const postData = {patient_id: this.parentData.id, doctor_id: docId};
        axios.post('/doctor/setPatient', postData).then(response => { // TODO
          this.getInfo();
        });
      }
    }
  },
}
</script>
