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
              <li class="breadcrumb-item"><router-link to="/tax">Brand</router-link></li>
              <li class="breadcrumb-item active">Edit Brand</li>
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
                <h3 class="card-title">Brand</h3>
              </div>
              <div class="card-body">
                 <form @submit.prevent="updateBrand">
                    <div class="modal-body">
                       <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter Full Name" v-model="form.name">
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
        this.getBrandById();
    },
    data(){
        return{
            form:{
                name:null,
                photo:null,
                new_photo:null
            },
            showphoto:'',
            errors:{},
        }
    },
    methods:{
        updateBrand(){
            this.$Progress.start();
            let id = this.$route.params.id;
            axios.patch('/api/brand/'+id,this.form)
            .then(res=>{
                Toast.fire({
                  icon: 'success',
                  title: 'Data Updated successfully'
                })
                this.$Progress.finish();
               this.$router.push({name:'brand'})
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
        getBrandById(){
            let id = this.$route.params.id;
            axios.get('/api/brand/'+id)
            .then(res=>{
                this.form = res.data;
                console.log(this.form)
            })
            .catch(error=>{
                this.$router.push('brand');
            })
        }
    }
}
</script>

<style>

</style>