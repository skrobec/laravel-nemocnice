<template>
<div class="screen-center">
  <div class="middle-container">
    <div v-if="admin" class="back-cont">
      <div v-on:click="back()" class="back">
          <i class="material-icons">arrow_back</i>
      </div>
    </div>
    <h2>Správa uživatele</h2>
    <div class="patient-info">
        <div class="title-box">
            <h4>Jméno</h4>
            <h4>{{this.user.name}}</h4>
        </div>
        <div class="title-box">
            <h4>Datum nástupu</h4>
            <h4>{{this.userInfo.entry_date | moment('DD.MM.YYYY')}}</h4>
        </div>
        <div class="title-box">
            <h4>Datum ukončení</h4>
            <h4>{{this.userInfo.termination_date | moment('DD.MM.YYYY')}}</h4>
        </div>
        <div v-if="!admin" class="title-box" >
            <h4>Funkce</h4>
            <h4>{{getJob(this.userInfo.userable_type)}}</h4>
        </div>
        <div v-if="admin" class="title-box"> 
            <h4>Funkce</h4>

                <div class="cursor non-marked" v-bind:class="{'marked': nurseChosen}" v-on:click="addJob('nurse')">
                    Sestra
                </div>
                <div class="cursor non-marked" v-bind:class="{'marked': doctorChosen}" v-on:click="addJob('doctor')">
                    Doktor
                </div>

        </div>
    </div>
    <div v-if="admin">
      <div v-if="editActive"  class="wrap-detail">
      <div class="auto-container">
            <h4>Ukončit hospitalizaci</h4>
            <label for="date_start">Datum</label>
            <date-picker id="date_start" v-model='hospitalization_date_end'/>
            <div v-if="errors && errors.hospitalization_date_end" class="text-danger">{{ errors.hospitalization_date_end[0] }}</div>
            <button v-on:click="endHospitalization()"  class="btn btn-primary end-button">Ukončit</button>
      </div>
    </div>
      <div class="left"><label for="section">Oddělení</label></div>
          <div  class="wrap-detail">
            <div class="auto-container">
                <input class="form-control standard-input shadow-none" id="section" type="text" v-model="section">
                <div class="option-container scroll">
                    <ul v-if="filteredResults.length > 0">
                        <li class="option" v-on:click="setSection(result.id)"  v-for="result in filteredResults" :key="result.id" v-text="result.name"></li>
                    </ul>
                </div>
            </div>
          </div>
          <div class="forms-container">
              <div class="form-block">
                  <form @submit.prevent="submit">
                      <div class="form-group input-container">
                          <label for="entry_date">Datum nástupu</label>
                          <date-picker id="entry_date" v-model='fields.entry_date'/>
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
</div>


</template>


<style>
    .non-marked{
        padding: 6px;
    }

    .marked{
        border: 2px solid darkgray;
        border-radius: 5px;
        padding: 5px;
        color: black;
    }

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
      user: {},
      fields: {
          entry_date: new Date()
      },
      errors: {},
      doctorChosen: false,
      nurseChosen: false,
      job: '',
      success: false,
      loaded: true,
      editing: false,
      results: [],
      section: '',
      sectionId: '',
      userInfo: {},
      admin: false
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
      return this.section ? this.results.filter(row => row.name.search(new RegExp(`${this.section}`, 'i')) !== -1) : this.results
    }
  },
  methods: {
    getJob(type){
        return (type=='doctor') ? 'Doktor' : 'Sestra';
    },
    back(){
        this.$emit('detailToForm', 'hide')
    },
    setSection(result) {
        this.sectionId = result;
        this.section = this.results.find(sec => sec.id == result).name;
    },
    addJob(type){
      if (type !== 'null' && this.admin == false)
      {
        if (type === 'nurse') {
            this.nurseChosen = true;
            this.doctorChosen = false;
        } else {
            this.doctorChosen = true;
            this.nurseChosen = false;
        }
        this.job = type;
      }

    },
    getInfo(){

        this.user = this.parentData;
         console.log(this.user);

        axios.post('/user/getInfo', {id:this.user.id}).then(response => {

          this.userInfo = response.data;
          this.addJob(this.userInfo.userable_type);
          return axios.get('/sections/getAll');
        }).then(response => {
          this.results = response.data;
          this.section = this.results.find(sec => sec.id == this.userInfo.section_id.id).name;
          return axios.get('/user/isAdmin');
        }).then(response => {
          this.admin = response.data.isAdmin;
          console.log(this.admin)
        });
    },
    submit(){
      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        this.fields.entry_date = this.$moment(this.fields.entry_date).format('YYYY-MM-DD');
        const postData = {id: this.parentData.id, job: this.job, entry_date: this.fields.entry_date, section: this.sectionId };
        axios.post('/user/addJob', postData).then(response => {
          console.log(response);
          this.fields = {};
          this.loaded = true;
          this.success = true;
          this.getInfo();
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
