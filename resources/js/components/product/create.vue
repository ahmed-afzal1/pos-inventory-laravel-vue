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
              <li class="breadcrumb-item"><router-link to="/product">Product</router-link></li>
              <li class="breadcrumb-item active">Add New Product</li>
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
                <h3 class="card-title">Product</h3>
              </div>
              <div class="card-body">
                 <form @submit.prevent="createProduct">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Product Name" v-model="form.name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.code">{{errors.code[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Product code" v-model="form.code">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.category_id">{{errors.category_id[0]}}</span>
                                <div class="input-group mb-3">
                                     <select id="category" class="form-control" v-model="form.category_id">
                                        <option disabled value="">Please select one</option>
                                        <option :value="category.id" v-for="category in allcategories" :key="category.id">{{category.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.supplier_id">{{errors.supplier_id[0]}}</span>
                                <div class="input-group mb-3">
                                     <select id="category" class="form-control" v-model="form.supplier_id">
                                        <option disabled value="">Please select one</option>
                                        <option :value="supplier.id" v-for="supplier in allsuppliers" :key="supplier.id">{{supplier.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.brand_id">{{errors.brand_id[0]}}</span>
                                <div class="input-group mb-3">
                                     <select id="category" class="form-control" v-model="form.brand_id">
                                        <option disabled value="">Please select one</option>
                                        <option :value="brand.id" v-for="brand in allbrands" :key="brand.id">{{brand.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.unit_id">{{errors.unit_id[0]}}</span>
                                <div class="input-group mb-3">
                                     <select id="category" class="form-control" v-model="form.unit_id">
                                        <option disabled value="">Please select one</option>
                                        <option :value="unit.id" v-for="unit in allunits" :key="unit.id">{{unit.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.root">{{errors.root[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Root" v-model="form.root">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.buying_date">{{errors.buying_date[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control" placeholder="Buying Date" v-model="form.buying_date">
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.buying_price">{{errors.buying_price[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Buying Price" min="1" v-model="form.buying_price">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.selling_price">{{errors.selling_price[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Buying Price" min="1" v-model="form.selling_price">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center mb-2">
                                    <img :src="form.photo" style="height:250px;width:250px;">
                                </div>


                                <span class="text-danger mb-2" v-if="errors.photo">{{errors.photo[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" @change="onFileSelected">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.quantity">{{errors.quantity[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Quantity" min="1" v-model="form.quantity">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <span class="text-danger mb-2" v-if="errors.tax_id">{{errors.tax_id[0]}}</span>
                                <div class="input-group mb-3">
                                     <select id="category" class="form-control" v-model="form.tax_id">
                                        <option disabled value="">Please select one</option>
                                        <option :value="tax.id" v-for="tax in alltaxes" :key="tax.id">{{tax.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
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
        this.$Progress.start();
        this.$Progress.finish();
        this.categories();
        this.suppliers();
        this.units();
        this.brands();
        this.taxes();
    },
    data(){
        return{
            form:{
                name:'',
                code:'',
                category_id:'',
                supplier_id:'',
                unit_id:'',
                brand_id:'',
                tax_id:'',
                root:'',
                buying_price:'',
                selling_price:'',
                buying_date:'',
                quantity:'',
                photo:'',
            },
            showphoto:'',
            allcategories:{},
            allsuppliers:{},
            allunits:{},
            allbrands:{},
            alltaxes:{},
            errors:{},
        }
    },
    methods:{
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
        createProduct(){
            this.$Progress.start();
            axios.post('/api/product',this.form)
            .then(({res})=>{
                Toast.fire({
                  icon: 'success',
                  title: 'Data added successfully'
                })
                this.$Progress.finish();
               this.$router.push({name:'product'})

            })
            .catch(error=>{
                this.$Progress.fail();
                 this.errors = error.response.data.errors;
            })
        },
         categories(){
            axios.get('/api/category')
            .then(res=>{
                this.allcategories = res.data;
            })
            .catch(error=>{
                console.log(error);
            })
        },
        suppliers(){
            axios.get('/api/supplier')
            .then(res=>{
                this.allsuppliers = res.data;
            })
            .catch(error=>{
                console.log(error);
            }) 
        },
        units(){
            axios.get('/api/unit')
            .then(res=>{
                this.allunits = res.data;
            })
            .catch(error=>{
                console.log(error);
            })
        },
        brands(){
            axios.get('/api/brand')
            .then(res=>{
                this.allbrands = res.data;
            })
            .catch(error=>{
                console.log(error);
            }) 
        },
        taxes(){
            axios.get('/api/tax')
            .then(res=>{
                this.alltaxes = res.data;
            })
            .catch(error=>{
                console.log(error);
            }) 
        },

    }
}
</script>

<style>

</style>