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
              <li class="breadcrumb-item"><router-link to="/tax">Employee</router-link></li>
              <li class="breadcrumb-item active">Edit Employee</li>
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
                <h3 class="card-title">Employee</h3>
              </div>
              <div class="card-body">
                 <form @submit.prevent="updateEmployee">
                    <div class="modal-body">
                        <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.name">
                        </div>
                        
                        <span class="text-danger mb-2" v-if="errors.email">{{errors.email[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" v-model="form.email">
                        </div>

                        <span class="text-danger mb-2" v-if="errors.address">{{errors.address[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Address" v-model="form.address">
                        </div>

                        <span class="text-danger mb-2" v-if="errors.salary">{{errors.salary[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Enter Salary" min="1" v-model="form.salary">
                        </div>

                        <span class="text-danger mb-2" v-if="errors.joining_date">{{errors.joining_date[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="date" class="form-control" placeholder="Joining Date" v-model="form.joining_date">
                        </div>

                        <span class="text-danger mb-2" v-if="errors.nid">{{errors.nid[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="NID Number" min="1" v-model="form.nid">
                        </div>


                        <div class="text-center mb-2">
                              <img v-if="showphoto" :src="showphoto" style="height:200px;width:200px;">
                              <img  v-else :src="'/'+form.photo" style="height:200px;width:200px;">
                        </div>


                        <span class="text-danger mb-2" v-if="errors.photo">{{errors.photo[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" @change="onFileSelected">
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
        this.getEmployeeById();
    },
    data(){
        return{
            form:{
                name:null,
                email:null,
                salary:null,
                address:null,
                photo:null,
                nid:null,
                joining_date:null,
                new_photo:null
            },
            showphoto:'',
            errors:{},
        }
    },
    methods:{
        updateEmployee(){
            this.$Progress.start();
            let id = this.$route.params.id;
            axios.patch('/api/employee/'+id,this.form)
            .then(res=>{
                Toast.fire({
                  icon: 'success',
                  title: 'Data Updated successfully'
                })
                this.$Progress.finish();
               this.$router.push({name:'employee'})
            })
            .catch(error=>{
                this.$Progress.fail();
                this.errors = error.response.data.errors;
            })
        },
        onFileSelected(event){
            let file = event.target.files[0];
            if(file.size>1048770){
                Notification.error();
            }else{
                let reader = new FileReader();
                reader.onload = event=>{
                    this.showphoto = event.target.result;
                    this.form.new_photo = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        getEmployeeById(){
            let id = this.$route.params.id;
            axios.get('/api/employee/'+id)
            .then(res=>{
                this.form = res.data;
                console.log(this.form)
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