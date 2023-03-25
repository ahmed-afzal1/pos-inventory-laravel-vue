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
              <li class="breadcrumb-item"><router-link to="/employee">Products</router-link></li>
              <li class="breadcrumb-item active">All Product</li>
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
                <h3 class="card-title">Products</h3>
               <div class="card-tools">
                    <div class="btn btn-success" @click="exportCsv(products)">Export</div>
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
                        <th>Code</th>
                        <th>Photo</th>
                        <th>Category</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="product in paginatedProducts" :key="product.id">
                        <td>{{product.name}}</td>
                        <td>{{product.code}}</td>
                        <td><img :src="product.photo" style="height:40px;width:40px;"></td>
                        <td>{{product.category.name}}</td>
                        <td>{{product.buying_price}}</td>
                        <td>{{product.selling_price}}</td>
                        <td>
                            <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-sm btn-info">Edit</router-link>
                            <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger">Delete</a>
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
import * as XLSX from "xlsx";
export default {
      created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    },
    data(){
        return{
          isLoading: true,
          products:[],
          paginatedProducts: [],
          pagination:{
            rowPerPage: 2,
            totalPage:0,
          }
        }
    },
    methods:{

        loadProduct(){
          this.isLoading = true
          this.$Progress.start();
          axios.get('/api/product')
            .then(res=>{
               this.products = res.data;
               this.pagination.totalPage = this.products.length / this.pagination.rowPerPage
               this.paginatedProducts = this.products.slice(0, this.pagination.rowPerPage);
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        },
        deleteProduct(id)
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
                    axios.delete('/api/product/'+id)
                    .then(()=>{
                        Fire.$emit('AfterCreate');

                        Swal.fire(
                        'Deleted!',
                        'Data has been deleted.',
                        'success'
                        )
                    })
                    .catch(()=>{
                       Swal.fire(
                        'Warning!',
                        'Something Went wrong.',
                        'warning'
                        )
                    })
                }
            })
        },
        
      exportCsv(products){
        let toSkip = ['created_at','updated_at']
        let rowsToExport = products.map( product =>{
              let row = {}
            Object.keys(product).filter(e => !toSkip.includes(e)).forEach(each =>{
            if(each === 'category')
              row[each] = product[each]['name']
            else 
              row[each] = product[each]
          })
          return row
        })

        let wb = XLSX.utils.book_new()
          let ws = XLSX.utils.json_to_sheet(rowsToExport)
          XLSX.utils.book_append_sheet(wb, ws, 'products')
          let wbout = XLSX.write(wb, {bookType: 'xlsx', type: 'array'})
          var pom = document.createElement('a');
          var csvContent=wbout; //here we load our csv data 
          var blob = new Blob([csvContent],{type: 'text/csv;charset=utf-8;'});
          var url = URL.createObjectURL(blob);
          pom.href = url;
          pom.setAttribute('download', 'foo.csv');
          pom.click();
          },
          clickCallback: function(page) {
            const skip = (page * this.pagination.rowPerPage) - this.pagination.rowPerPage
            this.paginatedProducts = this.products.slice(skip, skip+this.pagination.rowPerPage);
          }
        
    },
    created(){
        this.loadProduct();
        Fire.$on('AfterCreate',()=>{
          this.loadProduct();
        })
    }
}
</script>

<style lang='css'>


.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border-radius: 5px;
}

</style>