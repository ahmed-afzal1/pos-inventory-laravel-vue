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
              <li class="breadcrumb-item active">Salary Report</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
         <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Salary Report</h3>
               
              </div>
              <div class="card-body p-0">
                <div v-if="isLoading" class="text-center">
                  <img :src="this.$baseUrl+'img/vueload.gif'" alt="" width="400px" height="400px">
                </div>
                <table class="table table-striped" v-else>
                  <thead>
                    <tr>
                      <th>Month Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="salary in paginatedSalaries" :key="salary.id">
                        <td>{{salary.salary_month}}</td>
                        <td>
                          <router-link :to="{name: 'viewSalary', params: {id: salary.salary_month}}" class="btn btn-sm btn-info">View Salary</router-link>
                        </td>
                    </tr>
                  <paginate 
                    :pageCount="pagination.totalPage"
                    :containerClass="'pagination'"
                    :clickHandler="clickCallback">
                  </paginate>
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
          salaries:{},
          paginatedSalaries: [],
            pagination:{
              rowPerPage: 5,
              totalPage:0,
            },
            errors:{}
        }
    },
    methods:{
        loadSalary(){
          this.isLoading = true
          this.$Progress.start();
          axios.get('/api/salary')
            .then(res=>{
               this.salaries = res.data;
               this.pagination.totalPage = this.salaries.length / this.pagination.rowPerPage
               this.paginatedSalaries = this.salaries.slice(0, this.pagination.rowPerPage);
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        }
        
    },
    clickCallback: function(page) {
      const skip = (page * this.pagination.rowPerPage) - this.pagination.rowPerPage
      this.paginatedSalaries = this.salaries.slice(skip, skip+this.pagination.rowPerPage);
    },
    created(){
        this.loadSalary();
        Fire.$on('AfterCreate',()=>{
          this.loadSalary();
        })
    }
}
</script>

<style>

</style>