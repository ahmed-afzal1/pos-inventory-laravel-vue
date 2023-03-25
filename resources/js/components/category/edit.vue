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
              <li class="breadcrumb-item"><router-link to="/tax">Category</router-link></li>
              <li class="breadcrumb-item active">Edit Category</li>
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
                <h3 class="card-title">Category</h3>
              </div>
              <div class="card-body">
                 <form @submit.prevent="updateCategory">
                    <div class="modal-body">
                        <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter Unit Name" v-model="form.name">
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
        this.getCategoryById();
    },
    data(){
        return{
            form:{
                name:'',
            },
            errors:{},
        }
    },
    methods:{
        updateCategory(){
            this.$Progress.start();
            let id = this.$route.params.id;
            axios.patch('/api/category/'+id,this.form)
            .then(res=>{
                Toast.fire({
                  icon: 'success',
                  title: 'Data Updated successfully'
                })
                this.$Progress.finish();
               this.$router.push({name:'category'})
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
        getCategoryById(){
            let id = this.$route.params.id;
            axios.get('/api/category/'+id)
            .then(res=>{
                this.form = res.data;
            })
            .catch(error=>{
                this.$router.push('category');
            })
        }
    }
}
</script>

<style>

</style>