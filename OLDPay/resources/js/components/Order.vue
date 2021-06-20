<template>
  <div>
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
        <td><span v-if="order.paid===1">Paid</span></td>
        <td>
          <div class="btn-group" role="group">
            <router-link :to="{name: 'order', params: { id: order.id }}" class="btn btn-success">Edit</router-link>
          </div>
        </td>
      </tr>
      </tbody>
    </table>
    <div id="flex-container">
      <div class="flex-item" id="flex" v-if="prev_page_url!=null">
        <button v-on:click="getOrders(prev_page_url)">Назад</button>
      </div>
      <div class="flex-item" id="flex" v-if="next_page_url!=null">
        <button v-on:click="getOrders(next_page_url)">Вперед</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "Order",

    data() {
        return {
            orders: [],
            prev_page_url: null,
            next_page_url: null,
        }
    },
    mounted() {
        this.getOrders()
    },
    methods: {
        getOrders(url = '/api/orders') {
            this.axios.get(url).then(response => {
                this.orders = response.data.data;
                this.prev_page_url = response.data.prev_page_url;
                this.next_page_url = response.data.next_page_url;
            })


        }
    }
}
</script>

<style scoped>

#flex-container {
    display: -webkit-flex;
    display: flex;
    -webkit-flex-direction: row;
    flex-direction: row;
}

#flex-container > .flex-item {
    -webkit-flex: auto;
    flex: 1px;
}

#flex-container > .raw-item {
    width: 1px;
}
</style>
