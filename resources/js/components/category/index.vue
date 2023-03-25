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
              <li class="breadcrumb-item active">All Category</li>
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
                <h3 class="card-title">Categories</h3>
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
                      <th style="width: 50%">Name</th>
                      <th style="width: 40%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="category in paginatedCategories" :key="category.id">
                      <td>{{category.id}}</td>
                      <td>{{category.name}}</td>
                      <td>
                        <router-link :to="{name: 'editCategory', params: {id: category.id}}" class="btn btn-sm btn-info">Edit</router-link>
                        <a @click="deleteCategory(category.id)" class="btn btn-sm btn-danger">
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
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{modalTitle}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form @submit.prevent="categoryUnit" id="categoryForm">
      <div class="modal-body">
        <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Enter Unit Name" v-model="form.name">
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
          modalTitle:'Add Unit',
            form:{
                name:'',
                code:''
            },
            categories:[],
            paginatedCategories: [],
            pagination:{
              rowPerPage: 5,
              totalPage:0,
            },
            errors:{}
        }
    },
    methods:{
        newModal(){
          document.getElementById("categoryForm").reset();
          this.modalTitle = 'Add Category'
          this.errors = '';
           $('#categoryModal').modal('show');
        },

        loadCategory(){
          this.$Progress.start();
          this.isLoading = true
          axios.get('/api/category')
            .then(res=>{
               this.categories = res.data;
               this.pagination.totalPage = this.categories.length / this.pagination.rowPerPage
               this.paginatedCategories = this.categories.slice(0, this.pagination.rowPerPage);
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        },
        clickCallback: function(page) {
          const skip = (page * this.pagination.rowPerPage) - this.pagination.rowPerPage
          this.paginatedCategories = this.categories.slice(skip, skip+this.pagination.rowPerPage);
        },
        categoryUnit(){
            this.$Progress.start();
            axios.post('/api/category',this.form)
            .then(({res})=>{
                Fire.$emit('AfterCreate');

                $('#categoryModal').modal('hide');
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

        deleteCategory(id)
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
                    axios.delete('/api/category/'+id)
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
        this.loadCategory();
        Fire.$on('AfterCreate',()=>{
          this.loadCategory();
        })
    }
}
</script>

<style>

</style>