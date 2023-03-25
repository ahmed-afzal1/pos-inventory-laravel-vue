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
              <li class="breadcrumb-item"><router-link to="/expense">Expense</router-link></li>
              <li class="breadcrumb-item active">Edit Expense</li>
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
                <h3 class="card-title">Expenses</h3>
              </div>
              <div class="card-body">
                 <form @submit.prevent="updateExpense">
                    <div class="modal-body">
                        <span class="text-danger mb-2" v-if="errors.details">{{errors.details[0]}}</span>
                        <div class="input-group mb-3">
                            <textarea class="form-control" placeholder="Expense Details" cols="5" rows="5" v-model="form.details"></textarea>
                        </div>
                        
                        <span class="text-danger mb-2" v-if="errors.amount">{{errors.amount[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Amount" v-model="form.amount" min="0">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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
        this.getExpenseById();
    },
    data(){
        return{
            form:{
                'amount':'',
                'details':'',
            },
            errors:{},
        }
    },
    methods:{
        updateExpense(){
            this.$Progress.start();
            let id = this.$route.params.id;
            axios.patch('/api/expense/'+id,this.form)
            .then(res=>{
                Toast.fire({
                  icon: 'success',
                  title: 'Data Updated successfully'
                })
                this.$Progress.finish();
               this.$router.push({name:'expense'})
            })
            .catch(error=>{
                this.$Progress.fail();
                Toast.fire({
                  icon: 'warning',
                  title: 'Something went wrong!'
                })
                this.errors = error.response.data.errors;
            })
        },
        getExpenseById(){
            this.$Progress.start();
            let id = this.$route.params.id;
            axios.get('/api/expense/'+id)
            .then(res=>{
                this.form = res.data;
                this.$Progress.finish();
            })
            .catch(error=>{
                this.$router.push('expense');
            })
        }
    }
}
</script>

<style>

</style>