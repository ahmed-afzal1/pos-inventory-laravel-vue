<template>
<div>
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link to="/expense">Sales History</router-link></li>
              <li class="breadcrumb-item active">All Sale</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
         <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sale Log</h3>
              </div>
              <div class="card-body p-0">
                <div v-if="isLoading" class="text-center">
                  <img :src="this.$baseUrl+'img/vueload.gif'" alt="" width="400px" height="400px">
                </div>
                <table class="table table-striped" v-else>
                  <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total Amount</th>
                        <th>Pay</th>
                        <th>Due</th>
                        <th>PayBy</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="order in orders" :key="order.id">
                        <td>{{order.name}}</td>
                        <td>{{order.total}}</td>
                        <td>{{order.pay}}</td>
                        <td>{{order.due}}</td>
                        <td>{{order.payby}}</td>
                        <td>
                            <router-link :to="{name:'view-order', params: {id: order.id}}" class="btn btn-sm btn-info">View</router-link>
                            <a @click="deleteOrder(order.id)" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
</div>
</template>

<script>
export default {
      created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    },
    data(){
        return{
          isLoading: true,
            orders:[],
            errors:{}
        }
    },
    methods:{
        loadOrder(){
          this.isLoading = true
          this.$Progress.start();
          axios.get('/api/orders')
            .then(res=>{
               this.orders = res.data;
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        },

        deleteOrder(id)
        {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    axios.delete('/api/order/'+id)
                    .then(()=>{
                        Fire.$emit('AfterCreate');

                        Swal.fire(
                        'Deleted!',
                        'Data has been deleted.','success')
                    })
                    .catch(()=>{
                        Swal.fire(
                        'Warning!',
                        'Something Went Wrong!','warning')
                    })
                }
            })
        }
        
    },
    created(){
        this.loadOrder();
        Fire.$on('AfterCreate',()=>{
          this.loadOrder();
        })
    }
}
</script>

<style>

</style>