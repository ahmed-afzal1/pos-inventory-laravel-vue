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
                        <th>Selling Price</th>
                        <th>Status</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
       
                    <tr v-for="product in products" :key="product.id">
                        <td>{{product.name}}</td>
                        <td>{{product.code}}</td>
                        <td><img :src="product.photo" style="height:40px;width:40px;"></td>
                        <td>{{product.category.name}}</td>
                        <td>{{product.selling_price}}</td>
                        <td v-if="product.quantity>=1"><span class="badge badge-success">Available</span></td>
                        <td v-else><span class="badge badge-danger">Stock out</span></td>
                        <td>{{product.quantity}}</td>
                        <td>
                            <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-sm btn-info">Edit</router-link>
                        </td>
                    </tr>
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
export default {
      created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    },
    data(){
        return{
          isLoading: true,
          products:{},
        }
    },
    methods:{
        loadProduct(){
          this.isLoading = true
          this.$Progress.start();
          axios.get('/api/product')
            .then(res=>{
               this.products = res.data;
               this.$Progress.finish();
            }).finally(()=>{
              this.isLoading = false;
            })
            .catch()
        },
        
    },
    created(){
        this.loadProduct();
        Fire.$on('AfterCreate',()=>{
          this.loadProduct();
        })
    }
}
</script>

<style>

</style>