<template>
<div class="wrap">
    <h1>Oddělení</h1>
    <div class="section-container">
        <div class="section-block">
            <div class="section-item" v-for="section of sections" v-bind:key="section.name">
                <span>Jméno oddělení: {{section.name}}</span>
                <span>Kapacita: {{section.surname}}</span>
                <div v-on:click="deleteSection(section.id)" class="delete">
                    <i class="material-icons">clear</i>
                </div>
                <div v-on:click="prepareEdit(section.id)" class="edit">
                    <i class="material-icons">edit</i>
                </div>
            </div>
        </div>
    </div>
    <div class="form-container">
    <div class="form-block">
        <form @submit.prevent="submit">
            <div class="form-group input-container">
                <label for="name">Jméno oddělení</label>
                <input type="text" class="form-control standard-input shadow-none" name="name" id="name" v-model="fields.name" />
                <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
            </div>
        
            <div class="form-group input-container">
                <label for="email">Kapacita</label>
                <input type="text" class="form-control standard-input shadow-none" name="surname" id="surname" v-model="fields.surname" />
                <div v-if="errors && errors.surname" class="text-danger">{{ errors.surname[0] }}</div>
            </div>
        

            <button v-if="!editing" type="submit" class="btn btn-primary">Submit</button>
            <button v-if="editing" v-on:click="editSection()" class="btn btn-primary">Edit</button>
            <div v-if="success" class="alert alert-success mt-3">
                Úspěšně provedeno !
            </div>
        </form>
    </div>
</div>
</div>

</template>

<style>
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
    .section-container {
        display: flex;
        justify-content: center;
    }
    .form-block {
        width: 60%;
    }
    .section-block {
        width: 60%;
    }
    .section-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .section-item span {
        font-weight: 300;
        font-size: 1.1em;
    }
    .wrap {
        margin-top: 100px;
        margin-bottom: 100px;
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

</style>

<script>
export default {
  data() {
    return {
      sections: [],
      section: {
          id: '',
          name: '',
          capacity: ''
      },
      fields: {},
      errors: {},
      success: false,
      loaded: true,
      editing: false,
      sectionId: 0
    }
  },
  created(){
      this.getSections();
  },
  methods: {
    prepareEdit(id){
        const section = this.sections.find(pat => pat.id === id);
        this.fields.name = section.name;
        this.fields.surname = section.surname;
        this.fields.issues = section.issues;
        this.editing = true;
        this.sectionId = id;
    },
    getSections(){
        axios.get('/sections/get').then(response => {
          console.log(response);
          this.sections = response.data;
        });
    },
    deleteSection(id){
        this.fields.id = id;
        axios.post('/sections/del', this.fields).then(response => {
            console.log(response);
            this.fields = {};
            this.getSections();
        });
    },
    editSection(id){
        if (this.loaded) {
            this.editing = false;
            this.loaded = false;
            this.success = false;
            this.errors = {};
            this.fields.id = this.sectionId;
            axios.post('/sections/edit', this.fields).then(response => {
            console.log(response);
            this.fields = {}; 
            this.loaded = true;
            this.success = true;
            this.getSections();
            }).catch(error => {
            this.loaded = true;
            if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
            }
            });
      }
    },
    submit() {
      if (this.loaded) {
        this.loaded = false;
        this.success = false;
        this.errors = {};
        axios.post('/sections/add', this.fields).then(response => {
          console.log(response);
          this.fields = {}; 
          this.loaded = true;
          this.success = true;
          this.getSections();
        }).catch(error => {
          this.loaded = true;
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          }
        });
      }
    },
  },
}
</script>