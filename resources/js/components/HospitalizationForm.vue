<template>
<div class="full">
    <div v-if="detail" class="full">
        <hospitalization-detail></hospitalization-detail>
    </div>
    <div v-else class="wrap">
        <h1>Hospitalizace</h1>
        <div class="hospitalization-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenHospitalization" type="text" v-model="chosenHospitalization">
            </div>
            <div class="hospitalization-block">
                <div class="hospitalization-item" v-for="hospitalization of filteredResults" v-bind:key="hospitalization.date_start">
                    <span>Datum začátku: {{hospitalization.date_start}}</span>
                    <span>Datum konce: {{hospitalization.date_end}}</span>
                    <span>Jméno pacienta: {{getPatient(hospitalization.patient_id)}}</span>
                    <span>Jméno oddělení: {{getSection(hospitalization.section_id)}}</span>
                    <span>Důvod: {{hospitalization.reason}}</span>
                    <div v-on:click="connect(hospitalization.id,hospitalization.patient_id)" class="connect">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deleteHospitalization(hospitalization.id)" class="delete">
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
    .hospitalization-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .hospitalization-block {
        width: 60%;
    }
    .hospitalization-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .hospitalization-item span {
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
      hospitalizations: [],
      chosenHospitalization: '',
      hospitalization: {},
      patients: [],
      sections: [],
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      hospitalizationId: 0,
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
      this.getHospitalizations();
      
     
  },
  computed: {
    filteredResults () {
      return this.chosenHospitalization ? this.hospitalizations.filter(row => row.patientName.search(new RegExp(`${this.chosenHospitalization}`, 'i')) !== -1) : this.hospitalizations
    }
  },
  methods: {
    getPatient(id){
        console.log(this.patients);
        console.log(id);
        return this.patients.find(pat => pat.id == id).name;
    },
    getSection(id){
        console.log(this.patients);
        console.log(id);
        return this.sections.find(pat => pat.id == id).name;
    },
    connect(id,patientId){
         window.location.href = "http://homestead.test/" + "hospitalizationDetail" + "?hospitalizationId=" + id + "&patientId=" + patientId;
    },
    getHospitalizations(){
        axios.get('/hospitalizations/getAll').then(response => {
          console.log(this.enterId);
          this.buffer = response.data;
          return axios.get('/pat/get');
        }).then( response => {
            console.log('this.enterId');
            this.patients = response.data;
            return axios.get('/sections/getAll');
        }).then( response => {
            console.log('kg');
            this.sections = response.data;
            this.hospitalizations = this.buffer.map( hospitalization => {
                return {
                    id: hospitalization.id,
                    date_start: hospitalization.date_start,
                    patient_id: hospitalization.patient_id,
                    section_id: hospitalization.section_id,
                    date_end: hospitalization.date_end,
                    reason: hospitalization.reason,
                    patientName: this.patients.find(pat => pat.id == hospitalization.patient_id).name
                    }
            });
            if (this.enterId !== 0) {
                this.connect(this.enterId);
            }
            console.log('ebin');
        });
       
    },
    deleteHospitalization(id){
        this.fields.id = id;
        axios.post('/hospitalizations/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getHospitalizations();
        });
    },
   
  },
}
</script>