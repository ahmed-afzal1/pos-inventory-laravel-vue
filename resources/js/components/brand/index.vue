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
              <li class="breadcrumb-item active">All Brand</li>
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
                <h3 class="card-title">Brands</h3>
                <div class="card-tools">
                    <div class="btn btn-success" @click="newModal">Add New</div>
                </div>
              </div>
              <div class="card-body p-0">
                <div v-if="isLoading" class="text-center">
                  <img :src="this.$baseUrl+'img/vueload.gif'" alt="" width="400px" height="400px">
                </div>
                <table class="table table-striped" v-else>
                  <thead>
                    <tr>
                      <th style="width: 10%">#</th>
                      <th style="width: 40%">Photo</th>
                      <th style="width: 20%">Name</th>
                      <th style="width: 30%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="brand in paginatedBrands" :key="brand.id">
                      <td>{{brand.id}}</td>
                      <td> <img :src="brand.photo" alt="" height="60" width="60"> </td>
                      <td>{{brand.name}}</td>
                      <td>
                        <router-link :to="{name: 'editBrand', params: {id: brand.id}}" class="btn btn-sm btn-info">Edit</router-link>
                        <a @click="deleteBrand(brand.id)" class="btn btn-sm btn-danger">
                           Delete
                        </a>
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


<!-- Modal -->
<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{modalTitle}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form @submit.prevent="createBrand" id="brandForm">
      <div class="modal-body">
        <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter Unit Name" v-model="form.name">
        </div>
        
        <div class="text-center mb-2">
            <img :src="form.photo" style="height:250px;width:250px;">
        </div>


        <span class="text-danger mb-2" v-if="errors.photo">{{errors.photo[0]}}</span>
        <div class="input-group mb-3">
            <input type="file" class="form-control" @change="onFileSelected">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>
    </div>
  </div>
</div>


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
          modalTitle:'Add Brand',
            form:{
                name:'',
                photo:''
            },
            brands:[],
            paginatedBrands: [],
            pagination:{
              rowPerPage: 5,
              totalPage:0,
            },
            errors:{}
        }
    },
    methods:{
        newModal(){
          document.getElementById("brandForm").reset();
          this.modalTitle = 'Add Brand'
          this.errors = '';
           $('#brandModal').modal('show');
        },

        loadUnit(){
          this.$Progress.start();
          this.isLoading = true
          axios.get('/api/brand/')
            .then(res=>{
               this.brands = res.data;
               this.pagination.totalPage = this.brands.length / this.pagination.rowPerPage
               this.paginatedBrands = this.brands.slice(0, this.pagination.rowPerPage);
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        },
        clickCallback: function(page) {
          const skip = (page * this.pagination.rowPerPage) - this.pagination.rowPerPage
          this.paginatedBrands = this.brands.slice(skip, skip+this.pagination.rowPerPage);
        },
        onFileSelected(event){
            let file = event.target.files[0];
            if(file.size>1048770){
                Notification.error();
            }else{
                let reader = new FileReader();
                reader.onload = event=>{
                    this.form.photo = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        createBrand(){
            this.$Progress.start();
            axios.post('/api/brand',this.form)
            .then(({res})=>{
                Fire.$emit('AfterCreate');

                $('#brandModal').modal('hide');
                Toast.fire({
                  icon: 'success',
                  title: 'Data added successfully'
                })
                this.$Progress.finish();
            })
            .catch(error=>{
                this.$Progress.fail();
                 this.errors = error.response.data.errors;
            })
        },

        deleteBrand(id)
        {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    axios.delete('/api/brand/'+id)
                    .then(()=>{
                        Fire.$emit('AfterCreate');

                        Swal.fire(
                        'Deleted!',
                        'Data has been deleted.','success')
                    })
                    .catch(()=>{
                        Swal.fire(
                        'Warning!',
                        'Something Went Wrong!','warning')
                    })
                }
            })
        }
        
    },
    created(){
        this.loadUnit();
        Fire.$on('AfterCreate',()=>{
          this.loadUnit();
        })
    }
}
</script>

<style>

</style>