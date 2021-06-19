<template>
  <table class="table">
    <thead>
    <tr>
      <th>ID</th>
      <th>Paid</th>
      <th>Detail</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="order in orders" :key="order.id">
      <td>{{ order.id }}</td>
      <td> <span v-if="order.paid===1">Paid</span></td>
      <td>
        <div class="btn-group" role="group">
          <router-link :to="{name: 'order', params: { id: order.id }}" class="btn btn-success">Edit</router-link>
        </div>
      </td>
    </tr>
    </tbody>
  </table>
</template>

<script>
export default {
    name: "Order",

    data() {
        return {
            orders: []
        }
    },
    mounted() {
        this.getOrders()
    },
    methods: {
        getOrders() {
            this.axios.get('/api/orders').then(response=>{
                this.orders = response.data;
            })


        }
    }
}
</script>

<style scoped>

</style>
