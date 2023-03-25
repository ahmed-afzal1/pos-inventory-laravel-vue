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
              <li class="breadcrumb-item"><router-link to="/tax">Report</router-link></li>
              <li class="breadcrumb-item active">Loss/Profit Report</li>
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
                <h3 class="card-title">Report</h3>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">
                          <ul class="list-group">
                            <li class="list-group-item active">Profit / Loss Report</li>
                            <li class="list-group-item">Total product: {{reports.total_product}}</li>
                            <li class="list-group-item">Total Expense: {{reports.total_expense}}</li>
                          </ul>
                      </div>
                      <div class="col-md-6">
                          <ul class="list-group">
                            <li class="list-group-item">Total Buy: {{reports.total_buy}} BDT</li>
                            <li class="list-group-item">Total Sell: {{reports.total_sell}} BDT</li>
                            <li class="list-group-item">Profit/Loss: {{reports.profit}} BDT</li>
                         </ul>
                      </div>
                  </div>
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
        this.getProfitLoss();
        
    },
    data(){
        return{
            errors:{},
            reports:{},
        }
    },
    methods:{
        getProfitLoss(){
            axios.get('/api/profit/loss')
            .then(res=>{
                this.reports = res.data;
            })
            .catch(error=>{
                this.errors = error.reponse.data.errors;
            })

        }
    }
}
</script>

<style>

</style>