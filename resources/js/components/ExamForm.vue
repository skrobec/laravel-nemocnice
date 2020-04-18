<template>
<div class="full">
    <div v-if="detail" class="full">
        <exam-detail></exam-detail>
    </div>
    <div v-else class="wrap">
        <h1>Vyšetření</h1>
        <div class="exam-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenExam" type="text" v-model="chosenExam">
            </div>
            <div class="exam-block">
                <div class="exam-item" v-for="exam of filteredResults" v-bind:key="exam.id">
                    <span>Datum: {{exam.date | moment('DD.MM.YYYY')}}</span>
                    <span>Jméno pacienta: {{getPatient(exam.patient_id)}}</span>
                    <div v-on:click="connect(exam.id,exam.patient_id)" class="connect">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deleteExam(exam.id)" class="delete">
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
    .exam-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .exam-block {
        width: 60%;
    }
    .exam-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .exam-item span {
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
        right: 35px;
    }
    .delete {
        width: 30px;
        height: 30px;
        position: absolute;
        top: 2px;
        right: 2px;
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
      exams: [],
      chosenExam: '',
      exam: {},
      patients: [],
      sections: [],
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      examId: 0,
      detail: false,
      detailProp: {},
      buffer: []
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      const id = urlParams.searchParams.get('id');

      if (id !== null && id !== undefined) {
          this.enterId = id;
      }
      this.getExams();


  },
  computed: {
   filteredResults () {
      return this.chosenExam ? this.exams.filter(row => row.patientName.search(new RegExp(`${this.chosenExam}`, 'i')) !== -1) : this.exams
    }
  },
  methods: {
    getPatient(id){
        return this.patients.find(pat => pat.id == id).name;
    },
    getSection(id){
        return this.sections.find(pat => pat.id == id).name;
    },
    connect(id,patientId){
         window.location.href = "http://homestead.test/" + "examDetail" + "?examId=" + id + "&patientId=" + patientId;
    },
    getExams(){
        axios.get('/exams/getAll').then(response => {
          this.buffer = response.data;
          return axios.get('/pat/get');
        }).then( response => {
            this.patients = response.data;
            return axios.get('/sections/getAll');
        }).then( response => {
            this.sections = response.data;
            this.exams = this.buffer.map( exam => {
                return {
                    id: exam.id,
                    date: exam.date,
                    patient_id: exam.patient_id,
                    doctor_id: exam.doctor_id,
                    nurse_id: exam.nurse_id,
                    record: exam.record,
                    patientName: this.patients.find(pat => pat.id == exam.patient_id).name
                    }
            });
            if (this.enterId !== 0) {
                this.connect(this.enterId);
            }
        });

    },
    deleteExam(id){
        this.fields.id = id;
        axios.post('/exams/del', this.fields).then(response => {
            this.fields = {};
            this.getExams();
        });
    },

  },
}
</script>
