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
              <li class="breadcrumb-item"><router-link to="/all">Salary</router-link></li>
              <li class="breadcrumb-item active">Monthly Employee Salary</li>
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
                <h3 class="card-title">Monthly Employee Salary</h3>
               
              </div>
              <div class="card-body p-0">
                <div v-if="isLoading" class="text-center">
                  <img :src="this.$baseUrl+'img/vueload.gif'" alt="" width="400px" height="400px">
                </div>
                <table class="table table-striped" v-else>
                  <thead>
                    <tr>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr v-for="employee in employees" :key="employee.id">
                        <td>{{employee.name}}</td>
                        <td>{{employee.salary_month}}</td>
                        <td>{{employee.amount}}</td>
                        <td>{{employee.salary_date}}</td>
                        <td>
                            <router-link :to="{name: 'editSalary', params: {id: employee.id}}" class="btn btn-sm btn-info">Edit Salary</router-link>
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
            this.$router.push('/');
        }
        this.getMonthlySalaryById();
    },
    data(){
        return{
            isLoading: true,
            employees:{},
        }
    },
    methods:{
        getMonthlySalaryById(){
            this.isLoading = true
            let id = this.$route.params.id;
            axios.get('/api/salary/'+id)
            .then(res=>{
                this.employees = res.data;
                console.log(this.employees);
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch(error=>{
                this.$router.push('salary');
            })
        }
    }
}
</script>

<style>

</style>