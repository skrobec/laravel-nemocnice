<template>
<div class="screen-center">
  <div class="middle-container">
    <h2>Hospitalizace</h2>
    <div class="patient-info">
        <div class="title-box">
            <h4>Datum</h4>
            <div>{{this.loadedHospitalization.date_start}}</div>
        </div>
        <div class="title-box">
            <h4>Pacient</h4>
            <a><h4>{{this.patientObj.name}}</h4></a>
        </div>
        <div class="title-box">
            <h4>Oddělení</h4>
            <h4>{{this.loadedSection.name}}</h4>
        </div>
        <div class="title-box">
            <h4>Důvod</h4>
            <h4>{{this.loadedHospitalization.reason}}</h4>
        </div>
    </div>
    <div class="left"><label for="section">Oddělení</label></div>
    <div  class="wrap-detail">
      <div class="auto-container">
          <input class="form-control standard-input shadow-none" id="section" type="text" v-model="section">
          <div class="option-container scroll">
              <ul v-if="filteredSections.length > 0">
                  <li class="option" v-on:click="setSection(result.id)"  v-for="result in filteredSections" :key="result.id" v-text="result.name"></li>
              </ul>
          </div>
      </div>
    </div>
    <div class="forms-container">
            <div class="form-block">
                <form @submit.prevent="submit">
                    <div class="form-group input-container">
                        <label for="date_start">Datum</label>
                        <input placeholder="YYYY-MM-DD HH:MM:SS" type="text" class="form-control standard-input shadow-none" name="date_start" id="date_start" v-model="fields.date_start" />
                        <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    </div>

                    <div class="form-group input-container">
                        <label for="reason">Důvod</label>
                        <input type="text" class="form-control standard-input shadow-none" name="reason" id="reason" v-model="fields.reason" />
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
      hospitalizationObj: {
          date_start: ''
      },
      drugs: [],
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      patientId: 0,
      sections: [],
      patients: [],
      section: '',
      drug: '',
      loadedHospitalization: {
          date_start: ''
      },
      loadedSection: {
          name: ''
      },
      patientObj: {
          name: ''
      },
      sectionObj: {
          name: ''
      },
      drugObj: {
          name: ''
      },
      patientId: '',
      hospitalizationId: ''
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      this.patientId = urlParams.searchParams.get('patientId');
      this.hospitalizationId = urlParams.searchParams.get('hospitalizationId');
      console.log(this.hospitalizationId);

      if (this.patientId !== undefined && this.patientId !== null ) {
        this.getInfo();
      }



  },
  computed: {
    filteredSections () {
      return this.section ? this.sections.filter(row => row.name.search(new RegExp(`${this.section}`, 'i')) !== -1) : this.sections;
    }
  },
  methods: {
    setSection(result) {
        this.section = this.sections.find(section => section.id == result ).name;
        this.sectionObj = this.sections.find(section => section.id == result );
    },
    getInfo(){

        axios.get('/sections/getAll').then(response => {
          this.sections = response.data;
          return  axios.get('/pat/get');
        }).then( response => {
            this.patients = response.data;
            this.patientObj = this.patients.find(pat => pat.id == this.patientId );
            console.log('data');
            console.log( this.sections);
            console.log(this.patients);
             if (this.hospitalizationId !== undefined && this.hospitalizationId !== null ) {
                this.getEditInfo();
            }
        });
    },
    getEditInfo(){
        console.log("xxxxx" + this.hospitalizationId);
        axios.post('/hospitalization/getInfo',{id: this.hospitalizationId}).then(response => {
          this.loadedHospitalization = response.data;
          this.loadedSection = this.sections.find(section => section.id == this.loadedHospitalization.section_id );
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
        this.fields.patient_id = this.patientObj.id;
        this.fields.section_id = this.sectionObj.id;
        console.log(this.fields);
        axios.post('/hospitalizations/add', this.fields).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.hospitalizationId = response.id;
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
