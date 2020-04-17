<template>
<div class="full">
    <div v-if="detail" class="full">
        <intervention-detail></intervention-detail>
    </div>
    <div v-else class="wrap">
        <h1>Zákroky</h1>
        <div class="intervention-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenIntervention" type="text" v-model="chosenIntervention">
            </div>
            <div class="intervention-block">
                <div class="intervention-item" v-for="intervention of filteredResults" v-bind:key="intervention.id">
                    <span>Datum: {{intervention.date | moment('DD.MM.YYYY')}}</span>
                    <span>Jméno pacienta: {{getPatient(intervention.patient_id)}}</span>
                    <div v-on:click="connect(intervention.id,intervention.patient_id)" class="connect">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deleteIntervention(intervention.id)" class="delete">
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
    .intervention-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .intervention-block {
        width: 60%;
    }
    .intervention-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .intervention-item span {
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
      interventions: [],
      chosenIntervention: '',
      intervention: {},
      patients: [],
      hospitalizations: [],
      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      interventionId: 0,
      detail: false,
      detailProp: {},
      buffer: []
    }
  },
  created(){
     
      this.getInterventions();


  },
  computed: {
    filteredResults () {
      return this.chosenIntervention ? this.interventions.filter(row => row.patientName.search(new RegExp(`${this.chosenIntervention}`, 'i')) !== -1) : this.interventions
    }
  },
  methods: {
    getPatient(id){
        return this.patients.find(pat => pat.id == id).name;
    },
    connect(id,patientId){
         window.location.href = "http://homestead.test/" + "interventionDetail" + "?interventionId=" + id + "&patientId=" + patientId;
    },
    getInterventions(){
        axios.get('/interventions/getAll').then(response => {
       
          this.buffer = response.data;
          return axios.get('/pat/get');
        }).then( response => {
          
            this.patients = response.data;
            return axios.get('/hospitalizations/getAll');
        }).then( response => {
            console.log('kg');
            this.hospitalizations = response.data;

            this.interventions = this.buffer.map( intervention => {
                return {
                    id: intervention.id,
                    date: intervention.date,
                    record: intervention.record,
                    patient_id: intervention.patient_id,
                    patientName: this.patients.find(pat => pat.id == intervention.patient_id).name
                    }
            });
          
            console.log('ebin');
        });

    },
    deleteIntervention(id){
        this.fields.id = id;
        axios.post('/interventions/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getInterventions();
        });
    },

  },
}
</script>
