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
              <li class="breadcrumb-item"><router-link to="/tax">Order</router-link></li>
              <li class="breadcrumb-item active">Order Details</li>
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
                <h3 class="card-title">Order</h3>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">
                          <ul class="list-group">
                            <li class="list-group-item active">Customer Details</li>
                            <li class="list-group-item">Name: {{orders.name}}</li>
                            <li class="list-group-item">Phone: {{orders.phone}}</li>
                            <li class="list-group-item">Address: {{orders.address}}</li>
                            <li class="list-group-item">Date: {{orders.order_date}}</li>
                          </ul>
                      </div>
                      <div class="col-md-6">
                          <ul class="list-group">
                            <li class="list-group-item">Sub Total: {{orders.sub_total}} BDT</li>
                            <li class="list-group-item">Vat: {{orders.vat}}%</li>
                            <li class="list-group-item">Total: {{orders.total}} BDT</li>
                            <li class="list-group-item">Pay: {{orders.pay}} BDT</li>
                            <li class="list-group-item">Due: {{orders.due}} BDT</li>
                         </ul>
                      </div>
                  </div>
              </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Details</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Photo</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
            
                            <tr v-for="detail in details" :key="detail.id">
                                <td>{{detail.name}}</td>
                                <td>{{detail.code}}</td>
                                <td><img :src="'/'+detail.photo" style="height:40px;width:40px;"></td>
                                <td>{{detail.quantity}}</td>
                                <td>{{detail.price}}</td>
                                <td>{{detail.sub_total}}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>$180</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
            this.$router.push('/');
        }
        this.getOrderById();
        
    },
    data(){
        return{
            errors:{},
            orders:{},
            details:{},
        }
    },
    methods:{
        getOrderById(){
            let id = this.$route.params.id;
            axios.get('/api/order/details/'+id)
            .then(res=>{
                this.orders = res.data;
                console.log(this.orders);
            })
            .catch(error=>{
                this.$router.push('orders');
            })

            axios.get('/api/order/orderdetails/'+id)
            .then(res=>{
                this.details = res.data;
            })
            .catch(error=>{
                this.$router.push('orders');
            })

        }
    }
}
</script>

<style>

</style>