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
      <div class="title-box">
          <h4>Ošetřující doktor</h4>
          <h4>{{this.doctorName}}</h4>
      </div>
      <div class="exams list scroll">

        <div class="title-box">
            <h4>Vyšetření</h4>
            <div class="ico-box cursor" v-on:click="link('examDetail')">
                Přidat vyšetření <i class="material-icons">add</i>
            </div>
        </div>
        <div class="scroll items">
          <div v-for="exam of exams" v-bind:key="exam.id">
              <a :href="'examDetail?examId=' + exam.id + '&patientId='+exam.patient_id">{{exam.date | moment('DD.MM.YYYY')}}</a>
          </div>
        </div>
      </div>
      <div class="servings list">
        <div class="title-box">
            <h4>Podání léků</h4>
            <div class="ico-box cursor" v-on:click="link('servingDetail')">
                Přidat podání <i class="material-icons">add</i>
            </div>
        </div>
        <div class="scroll items">
          <div v-for="serving of servings" v-bind:key="serving.id">
              <a :href="'servingDetail?servingId=' + serving.id + '&patientId='+serving.patient_id">{{serving.date | moment('DD.MM.YYYY')}}</a>
          </div>
        </div>
      </div>
      <div class="hospitalization list scroll">

         <div class="title-box">
            <h4>Hospitalizace</h4>
            <div class="ico-box cursor" v-on:click="link('hospitalizationDetail')">
                Přidat hospitalizaci <i class="material-icons">add</i>
            </div>
        </div>
        <div class="scroll items">
           <div v-for="hosp of hospitalizations" v-bind:key="hosp.id">
               <a :href="'hospitalizationDetail?hospitalizationId=' + hosp.id + '&patientId='+hosp.patient_id">
                   {{hosp.date_start | moment('DD.MM.YYYY')}} - <span v-if="hosp.date_end == null">AKTIVNÍ</span>{{hosp.date_end | moment('DD.MM.YYYY')}}
               </a>
           </div>
        </div>

      </div>
      <div class="interventions list scroll">
        <div class="title-box">
            <h4>Zákroky</h4>

            <div class="ico-box cursor" v-on:click="link('interventionDetail')">
                Přidat zákrok <i class="material-icons">add</i>
            </div>


        </div>
        <div class="scroll items">
          <div v-for="int of interventions" v-bind:key="int.id">
              <a :href="'interventionDetail?interventionId=' + int.id + '&patientId='+int.patient_id">{{int.date | moment('DD.MM.YYYY')}}</a>
          </div>
        </div>
      </div>

    </div>
    <div class="left"><label for="doctor">Doktor</label></div>
    <div  class="wrap-detail">
      <div class="auto-container">

          <input class="form-control standard-input shadow-none" id="doctor" type="text" v-model="doctor">
          <div class="option-container scroll">
              <ul v-if="filteredResults.length > 0">
                  <li class="option" v-on:click="setDoc(result.userable_id)"  v-for="result in filteredResults" :key="result.id" v-text="result.name"></li>
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
      width: 100%;
      display: flex;
      justify-content: flex-start;
      flex-direction: column;
      align-items: flex-start;
    }
    .items {
       max-height: 200px;
       overflow: auto;
       text-align: start;
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
      doctorName: '',
      doctorId: null
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
        this.doctor = result.name;
        this.setDoctor(result.userable_id);
    },
    getInfo(){
        axios.post('/patient/getInfo',{id: this.parentData.id}).then(response => {
            this.exams = response.data.exams;
            this.hospitalizations = response.data.hospitalizations;
            this.interventions = response.data.interventions;
            this.servings = response.data.servings;
            this.warning = true;
            this.doctorId = response.data.doctor_id;
            return axios.get('/user/getDoctors');
        }).then( response => {
            this.doctors = response.data;
             if (this.doctorId !== null) {
              this.doctor = this.doctors.find(doc => doc.userable_id == this.doctorId).name;
              this.doctorName = this.doctors.find(doc => doc.userable_id == this.doctorId).name;
            }
        });
    },
    relink() {
      window.history.pushState({}, '', "http://homestead.test/users");

    },
    link(destination, parameter) {
      window.location.href = "http://homestead.test/" + destination + "?patientId=" + this.parentData.id;
    },
    setDoctor(id){
        const postData = {patient_id: this.parentData.id, doctor_id: id};
        axios.post('/doctor/setPatient', postData).then(response => { // TODO
          this.getInfo();
        });

    }
  },
}
</script>
