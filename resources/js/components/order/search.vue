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
              <li class="breadcrumb-item"><router-link to="/search">Search</router-link></li>
              <li class="breadcrumb-item active">Search Order</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
         <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                 <form @submit.prevent="searchDate">
                    <div class="modal-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Search By Date</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="Search By Date" v-model="date">
                    </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row d-flex justify-content-center">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Details</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Sub Total</th>
                                <th>Vat</th>
                                <th>Total</th>
                                <th>Pay</th>
                                <th>Due</th>
                            </tr>
                        </thead>
                        <tbody>
            
                            <tr v-for="order in orders" :key="order.id">
                                <td>{{order.name}}</td>
                                <td>{{order.qty}}</td>
                                <td>{{order.sub_total}}</td>
                                <td>{{order.vat}}</td>
                                <td>{{order.total}}</td>
                                <td>{{order.pay}}</td>
                                <td>{{order.due}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
    },
    data(){
        return{
            date:'',
            month:'',
            errors:{},
            orders:[]
        }
    },
    methods:{
        searchDate(){
            axios.post('/api/search/order',this.form)
            .then(res=>{
                this.orders = res.data;
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        },
        searchMonth(){
            axios.post('/api/search/month',this.form)
            .then(res=>{
                
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        }
    }
}
</script>

<style>

</style>