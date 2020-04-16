<template>
<div class="screen-center">
  <div class="middle-container">
    <h2>Podání</h2>
    <div class="patient-info">
        <div class="title-box">
            <h4>Datum</h4>
            <div>{{this.servingObj.date | moment('DD.MM.YYYY')}}</div>
        </div>
        <div class="title-box">
            <h4>Pacient</h4>
            <a :href="'/patients?id='+this.patientId"><h4>{{this.patientObj.name}}</h4></a>
        </div>
        <div class="title-box">
            <h4>Sestra</h4>
            <h4>{{this.loadedNurse.name}}</h4>
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
    <div class="left"><label for="nurse">Lék</label></div>
    <div  class="wrap-detail">
      <div class="auto-container">
          <input class="form-control standard-input shadow-none" id="drug" type="text" v-model="drug">
          <div class="option-container scroll">
              <ul v-if="filteredDrugs.length > 0">
                  <li class="option" v-on:click="setDrug(result.id)" v-for="result in filteredDrugs" :key="result.id" v-text="result.name"></li>
              </ul>
          </div>
      </div>
    </div>
    <div class="forms-container">
            <div class="form-block">
                <form @submit.prevent="submit">
                    <div class="form-group input-container">
                        <label for="date">Datum</label>
                        <!--input placeholder="YYYY-MM-DD" type="text" class="form-control standard-input shadow-none" name="date" id="date" v-model="fields.date" /-->
                        <date-picker id="date" v-model='fields.date'/>
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>


                    <div class="form-group input-container">
                        <label for="drugQ">Množství léku</label>
                        <input type="number" class="form-control standard-input shadow-none" name="drugQ" id="drugQ" v-model="fields.quantity" />
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>


                    <button v-if="!editing" type="submit" class="btn btn-primary">Přidat</button>
                    <button v-if="editing" v-on:click="editserving()" class="btn btn-primary">Upravit</button>
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
      servingObj: {
          date: ''
      },
      drugs: [],
      fields: {
        date: new Date()
      },
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      nurses: [],
      patients: [],
      nurse: '',
      drug: '',
      loadedServing: {
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
      patientId: '',
      servingId: ''
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      this.patientId = urlParams.searchParams.get('patientId');
      this.servingId = urlParams.searchParams.get('servingId');

      if (this.patientId !== undefined && this.patientId !== null ) {
        this.getInfo();
      }



  },
  computed: {
    filteredNurses () {
      return this.nurse ? this.nurses.filter(row => row.name.search(new RegExp(`${this.nurse}`, 'i')) !== -1) : this.nurses;
    },
    filteredDrugs () {
      return this.drug ? this.drugs.filter(row => row.name.search(new RegExp(`${this.drug}`, 'i')) !== -1) : this.drugs;
    }
  },
  methods: {
    setNurse(result) {
        this.fields.nurse_id = this.nurses.find(nurse => nurse.id == result ).userable_id;
        this.nurse = this.nurses.find(nurse => nurse.id == result ).name;
        this.nurseObj = this.nurses.find(nurse => nurse.id == result );
    },
    setDrug(result) {
        this.fields.drug_id = result;
        this.drug = this.drugs.find(drug => drug.id == result ).name;
        this.drugObj = this.drugs.find(drug => drug.id == result );
    },

    getInfo(){
        axios.get('/user/getNurses').then(response => {
          this.nurses = response.data;
          return  axios.get('/pat/get');
        }).then( response => {
            this.patients = response.data;
            this.patientObj = this.patients.find(pat => pat.id == this.patientId );
            console.log('data');
            console.log( this.nurses);
            console.log(this.patients);

            return  axios.get('/drugs/getAll');
        }).then( response => {
            this.drugs = response.data;
             console.log(this.drugs);

            if (this.servingId !== undefined && this.servingId !== null ) {
                this.getEditInfo();
            }
        });
    },
    getEditInfo(){

        axios.post('/serving/getInfo',{id: this.servingId}).then(response => {
            console.log("aa");
            this.servingObj = response.data;
            console.log(this.servingObj);
          this.loadedNurse = this.nurses.find(nurse => nurse.userable_id == this.servingObj.nurse_id );
          this.nurseObj = this.nurses.find(nurse => nurse.userable_id == this.servingObj.nurse_id );
          this.nurse = this.nurseObj.name;
          this.drug = this.drugs.find(drug => drug.id == this.servingObj.drug_id ).name;
          this.drugObj = this.drugs.find(drug => drug.id == this.servingObj.drug_id );
          this.fields.quantity = response.data.quantity;
          //this.fields.date = response.data.date;
          console.log('ok');
          console.log(this.loadedNurse);
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
        this.fields.patient_id = this.patientId;
        this.fields.date = this.$moment(this.fields.date).format('YYYY-MM-DD');
        console.log(this.fields);
        axios.post('/servings/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.servingId = response.data.id;
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
