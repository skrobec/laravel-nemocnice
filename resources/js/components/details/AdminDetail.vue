<template>
<div class="screen-center">
  <div class="middle-container">
    <div class="back-cont">
      <div v-on:click="back()" class="back">
          <i class="material-icons">arrow_back</i>
      </div>
    </div>
    <h2>Uživatel: {{parentData.name}}</h2>
    <div class="patient-info">
        <div class="title-box">
            <h4>Datum nástupu</h4>
            <div>{{this.user.date}}</div>
        </div>
        <div class="title-box">
            <h4>Datum ukončení</h4>
            <div>{{this.user.date}}</div>
        </div>
        <div class="title-box">
            <h4>Funkce</h4>
            <div class="job-box">
                <div class="cursor" v-bind:class="{'marked': nurseChosen}" v-on:click="addJob('nurse')">
                    Sestra 
                </div>
                <div class="cursor" v-bind:class="{'marked': doctorChosen}" v-on:click="addJob('doctor')">
                    Doktor
                </div>
            </div>
        </div>

    </div>
    <div class="left"><label for="doctor">Oddělení</label></div>
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
                    <label for="date">Datum</label>
                    <input placeholder="YYYY-MM-DD HH:MM:SS" type="text" class="form-control standard-input shadow-none" name="date" id="date" v-model="fields.date" />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>          

                <button type="submit" class="btn btn-primary">Submit</button>
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
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
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
      fields: {},
      errors: {},
      doctorChosen: false,
      nurseChosen: false,
      job: '',
      success: false,
      loaded: true,
      editing: false,
      results: [],
      section: '',
      sectionId: ''
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
    back(){
        this.$emit('detailToForm', 'hide')
    },
    setSection(result) {
        this.sectionId = result;
        this.section = this.results.find(sec => sec.id == result);
    },
    addJob(type){
        if (type === 'nurse') {
            this.nurseChosen = true;
        } else {
            this.doctorChosen = true;
        }
        this.job = type;
    },
    getInfo(){

        this.user = this.parentData;
         console.log(this.user);
        axios.get('/sections/getAll').then(response => {
          console.log(response);
          this.results = response.data;

        });
    },
    submit(){
      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        const postData = {id: this.parentData.id, job: this.job, date: fields.date, section: this.sectionId };
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
