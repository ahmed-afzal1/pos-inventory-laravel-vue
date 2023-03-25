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
              <li class="breadcrumb-item"><router-link to="/given-salary">Employee Salary</router-link></li>
              <li class="breadcrumb-item active">Edit Salary</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row d-flex justify-content-center">
         <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Update Salary</h3>
              </div>
              <div class="card-body">
                 <form @submit.prevent="employeeSalaryUpdate">
                    <div class="modal-body">
                        <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full Name" v-model="form.name">
                        </div>
                        
                        <span class="text-danger mb-2" v-if="errors.email">{{errors.email[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email Address" v-model="form.email">
                        </div>

                        <span class="text-danger mb-2" v-if="errors.salary_month">{{errors.salary_month[0]}}</span>
                        <div class="input-group mb-3">
                            <select id="category" class="form-control" v-model="form.salary_month">
                                <option disabled value="">Please select a month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>

                        <input type="hidden" v-model="form.employee_id">

                        <span class="text-danger mb-2" v-if="errors.amount">{{errors.amount[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Salary" v-model="form.amount" min="0">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pay Salaray</button>
                    </div>
                </form>
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
        this.getEditSalaryById();
    },
    data(){
        return{
            form:{
                name:null,
                email:null,
                amount:null,
                salary_month:null,
                employee_id:null,
            },
          errors:{}
        }
    },
    methods:{
          employeeSalaryUpdate(){
            this.$Progress.start();
            let id = this.$route.params.id
            axios.post('/api/salary/update/'+id,this.form)
            .then(res=>{
                     Toast.fire({
                    icon: 'success',
                    title: 'Salary Updated Successfully'
                    })
                    this.$Progress.finish();
                    this.$router.push('/given-salary');
            })
            .catch(error=>{
                this.errors = error.response.data.errors;
            })
        },
        getEditSalaryById(){
            this.$Progress.start();
            let id = this.$route.params.id
            axios.get('/api/edit/salary/'+id)
            .then(({data})=>{
                this.form = data;
                this.$Progress.finish();
            })
            .catch(error=>{
                this.$router.push('employee');
            })
        }
    }
}
</script>

<style>

</style>