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
              <li class="breadcrumb-item"><router-link to="/employee">Employee</router-link></li>
              <li class="breadcrumb-item active">All Employee</li>
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
                <h3 class="card-title">Employees</h3>
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
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Salary</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
       
                  <tr v-for="employee in paginatedEmployees" :key="employee.id">
                    <td>{{employee.name}}</td>
                    <td><img :src="employee.photo" style="height:40px;width:40px;"></td>
                    <td>{{employee.salary}}</td>
                    <td>{{employee.joining_date}}</td>
                    <td>
                        <router-link :to="{name: 'editEmployee', params: {id: employee.id}}" class="btn btn-sm btn-info">Edit</router-link>
                        <a @click="deleteEmployee(employee.id)" class="btn btn-sm btn-danger">Delete</a>
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
<div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{modalTitle}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form @submit.prevent="createEmployee" id="employeeForm">
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
          modalTitle:'Add Employee',
            form:{
                name:null,
                email:null,
                salary:null,
                address:null,
                photo:null,
                nid:null,
                joining_date:null,
            },
            employees:[],
            paginatedEmployees: [],
            pagination:{
              rowPerPage: 5,
              totalPage:0,
            },
            errors:{}

        }
    },
    methods:{
        newModal(){
            document.getElementById("employeeForm").reset();
            this.modalTitle = 'Add Employee'
            this.form.photo = '';
            this.errors = '';
            $('#employeeModal').modal('show');
        },

        loadEmployee(){
          this.$Progress.start();
          this.isLoading = true
          axios.get('/api/employee')
            .then(res=>{
               this.employees = res.data;
               this.pagination.totalPage = this.employees.length / this.pagination.rowPerPage
               this.paginatedEmployees = this.employees.slice(0, this.pagination.rowPerPage);
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
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
        createEmployee(){
            this.$Progress.start();
            axios.post('/api/employee',this.form)
            .then(({res})=>{
                Fire.$emit('AfterCreate');

                $('#employeeModal').modal('hide');
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
          clickCallback: function(page) {
            const skip = (page * this.pagination.rowPerPage) - this.pagination.rowPerPage
            this.paginatedEmployees = this.employees.slice(skip, skip+this.pagination.rowPerPage);
          },

        deleteEmployee(id)
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
                    axios.delete('/api/employee/'+id)
                    .then(()=>{
                        Fire.$emit('AfterCreate');

                        Swal.fire(
                        'Deleted!',
                        'Data has been deleted.',
                        'success'
                        )
                    })
                    .catch(()=>{
                        console.log('ok');
                    })
                }
            })
        }
        
    },
    created(){
        this.loadEmployee();
        Fire.$on('AfterCreate',()=>{
          this.loadEmployee();
        })
    }
}
</script>

<style>

</style>