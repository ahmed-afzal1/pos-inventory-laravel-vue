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
              <li class="breadcrumb-item active">All Expense</li>
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
                <h3 class="card-title">Expenses</h3>
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
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Expense Date</th>
                        <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="expense in paginatedExpenses" :key="expense.id">
                        <td>{{expense.details}}</td>
                        <td>{{expense.amount}}</td>
                        <td>{{expense.expense_date}}</td>
                        <td>
                            <router-link :to="{name:'editExpense', params: {id: expense.id}}" class="btn btn-sm btn-info">Edit</router-link>
                            <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger">Delete</a>
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
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">{{modalTitle}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form @submit.prevent="createExpense" id="expenseForm">
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
          modalTitle:'Add Expense',
            form:{
                'amount':'',
                'details':'',
            },
            expenses:{},
            paginatedExpenses: [],
            pagination:{
              rowPerPage: 5,
              totalPage:0,
            },
            errors:{}
        }
    },
    methods:{
        newModal(){
          document.getElementById("expenseForm").reset();
          this.modalTitle = 'Add Expense'
          this.errors = '';
           $('#expenseModal').modal('show');
        },

        loadExpense(){
          this.isLoading = true
          this.$Progress.start();
          axios.get('/api/expense')
            .then(res=>{
               this.expenses = res.data;
               this.pagination.totalPage = this.expenses.length / this.pagination.rowPerPage
               this.paginatedExpenses = this.expenses.slice(0, this.pagination.rowPerPage);
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        },
        clickCallback: function(page) {
          const skip = (page * this.pagination.rowPerPage) - this.pagination.rowPerPage
          this.paginatedExpenses = this.expenses.slice(skip, skip+this.pagination.rowPerPage);
        },
        createExpense(){
            this.$Progress.start();
            axios.post('/api/expense',this.form)
            .then(({res})=>{
                Fire.$emit('AfterCreate');

                $('#expenseModal').modal('hide');
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

        deleteExpense(id)
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
                    axios.delete('/api/expense/'+id)
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
        this.loadExpense();
        Fire.$on('AfterCreate',()=>{
          this.loadExpense();
        })
    }
}
</script>

<style>

</style>