<template>
  <div>
    <errors-modal v-if="errors" :errors="errors"  @close="errors=null"></errors-modal>
    <form @submit.prevent="saveForm" novalidate>
      <div class="large-12 medium-12 small-12 cell">
        <label>Имя
          <input type="text" id="name" v-model="form.name">
        </label>
      </div>
      <div class="large-12 medium-12 small-12 cell">
        <label>Сумма
          <input type="text" id="sum" v-model="form.sum">
        </label>
      </div>
      <input type="submit" name="Заплатить">
      <router-link class="btn btn-secondary" :to="{name:'orders'}">Назад</router-link>
    </form>
  </div>
</template>

<script>
import ErrorsModal from "./ErrorsModal";
export default {
    props:{
        order_id:{
            type:Number,
            required:false,
        }
    },
    components:{
        ErrorsModal
    },
    data() {
        return {
            form: {
                name: '',
                sum: '',
            },
            errors: null,
        }
    },
    mounted() {
        console.log(this.$route.params.id)
        this.form.order_id=this.$route.params.id;
    },
    methods: {
        saveForm() {
            axios.post('/api/form', this.form).then((res) => {
                console.log(res.data.status);
                console.log(res.data.redirect_to);
                if(res.data.status==="success" && res.data.redirect_to!==undefined){
                    console.log("resirect")
                    window.location.href =res.data.redirect_to;
                }
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.message;
                    console.log(this.errors)
                }else {
                    alert("Внутренняя ошибка. Повторите позже")
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
