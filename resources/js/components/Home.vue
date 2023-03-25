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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{todaySell}} BDT</h3>

                <p>Today Sell</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{todayIncome}} BDT</h3>

                <p>Today Income</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{todayDue}} BDT</h3>

                <p>Today Due</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{todayexpense}} BDT</h3>

                <p>Today Expense</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
        </div>


        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products</h3>
               
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Code</th>
                        <th>Selling Price</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="product in products" :key="product.id">
                        <td>{{product.name}}</td>
                        <td><img :src="product.photo" style="height:40px;width:40px;"></td>
                        <td>{{product.code}}</td>
                        <td>{{product.selling_price}}</td>
                        <td v-if="product.quantity>=1"><span class="badge badge-success">Available</span></td>
                        <td v-else><span class="badge badge-danger">Stock out</span></td>
                        <td>{{product.quantity}}</td>
                        <td>
                            <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-sm btn-info">Edit</router-link>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
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
        this.TodaySell();
        this.TodayIncome();
        this.TodayDue();
        this.TodayExpense();
        this.Stockout();
    },
    data(){
      return{
        todaySell:'',
        todayIncome:'',
        todayDue:'',
        todayexpense:'',
        products:[]
      }
    },
    methods:{
      TodaySell(){
            axios.get('/api/today/sell')
            .then(res=>{
                this.todaySell = res.data;
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        },
          TodayIncome(){
            axios.get('/api/today/income')
            .then(res=>{
                this.todayIncome = res.data;
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        },
          TodayDue(){
            axios.get('/api/today/due')
            .then(res=>{
                this.todayDue = res.data;
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        },
          TodayExpense(){
            axios.get('/api/today/expense')
            .then(res=>{
                this.todayexpense = res.data;
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        },
        Stockout(){
          axios.get('/api/stockout/product')
            .then(res=>{
                this.products = res.data;
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