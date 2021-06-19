<template>
  <div class="container">


      <router-view></router-view>

  </div>
</template>

<script>


export default {
    components:{

    },
    data() {
        return {

        }
    },
    computed : {
          /*getSettings: {
              get: function () {
                  return this.$store.getters.get_settings
              },
              set:function (newValue){
                  this.$store.dispatch('SAVE_SETTINGS',newValue)
              }
          },*/
    },
    mounted() {
       // this.$store.dispatch('GET_SETTINGS')
 //       console.log(this.example())
    },

    methods: {
    /*    ...mapActions('SAVE_SETTINGS'),
        example(){
            console.log("example");
         //   console.log(this.getSettings);

            console.log(this.getSettings['id']);
            console.log(this.getSettings['color']);
            console.log(this.getSettings['user_id']);

        //    this.$store.commit('set_settings',{key: 'color', value: 'gren'});
            this.getSettings={ 'color': 'red'}
            this.getSettings={ 'user_id': 2}



        },*/
        logout() {
            this.axios
                .post('/logout')
                .then(response => (
                   // this.$router.push({name: 'home'})
                    window.location.href = "/"
                ))
                .catch(err => {
                    if (err.response.status === 422) {
                        this.errors = err.response.data.errors;
                    }
                })
                .finally(() => this.loading = false)
        },

    }
}
</script>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: auto;
    background-color: #f1f1f1;
    position: fixed;
  /*  height: 100%;*/
    margin-top: 5%;
    margin-left: 10%;
    overflow: auto;
}

li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
}

li a.active {
    background-color: #04AA6D;
    color: white;
}

li a:hover:not(.active) {
    background-color: #555;
    color: white;
}
</style>

