<template>
<div class="full">
    <div class="wrap">
        <h1>Uživatelé</h1>
        <div class="user-container">
            <div class="input-block">
                <input class="form-control standard-input shadow-none" id="chosenUser" type="text" v-model="chosenUser">
            </div>
            <div class="user-block">
                <div class="user-item" v-for="user of filteredResults" v-bind:key="user.id">
                    <span>Jméno: {{user.name}}</span>
                    <span>Funkce: {{getJob(user.userable_type)}}</span>
                    <div v-on:click="connect(user.id)" class="connect">
                        <i class="material-icons">build</i>
                    </div>
                    <div v-on:click="deleteUser(user.id)" class="delete">
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
    .full {
        height: 100%;
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
    .user-container {
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }
    .form-block {
        width: 60%;
    }
    .user-block {
        width: 60%;
    }
    .user-item {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #F6F7F8;
        border-radius: 5px;
        padding: 5px;
        position: relative;
    }
    .user-item span {
        font-weight: 300;
        font-size: 1.1em;
    }
    .wrap {
        margin-top: 100px;
        margin-bottom: 100px;
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
      users: [],
      chosenUser: '',

      fields: {},
      errors: {},
      enterId: 0,
      success: false,
      loaded: true,
      editing: false,
      userId: 0,
      detail: false,
      detailProp: {}
    }
  },
  created(){
      const queryString = window.location.href;
      const urlParams = new URL(queryString);
      const id = urlParams.searchParams.get('id');

      if (id !== null && id !== undefined) {
          this.enterId = id;
      }
      this.getUsers();


  },
  computed: {
    filteredResults () {
      return this.chosenUser ? this.users.filter(row => row.name.search(new RegExp(`${this.chosenUser}`, 'i')) !== -1) : this.users
    }
  },
  methods: {
    getJob(type){
        if (type == null) return "";
        return (type == 'App\\Doctor') ? 'Doktor' : 'Sestra';
    },

    hideDetail(value){
        this.detail = false;
        this.connectId = 0;
        window.history.replaceState({}, '',  "http://homestead.test/users");
    },
    connect(id){
        window.location.href = "http://homestead.test/users/userDetail" + '?id=' + id;

    },
    getUsers(){
        axios.get('/user/getAll').then(response => {
          this.users = response.data;
          if (this.enterId !== 0) {
            this.connect(this.enterId);
          }
        });
    },
    deleteUser(id){
        this.fields.id = id;
        axios.post('/user/del', this.fields).then(response => {
            this.fields = {};
            this.getUsers();
        });
    },

  },
}
</script>
