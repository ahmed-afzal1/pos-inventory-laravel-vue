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
              <li class="breadcrumb-item active">Point Of Sale</li>
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
            <div v-if="isLoading" class="text-center">
                <img :src="this.$baseUrl+'img/vueload.gif'" alt="" width="400px" height="400px">
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Expense Chart</h3>
                        <div class="card-tools">
                            <div class="btn btn-success" @click="newModal">Add Customer</div>
                        </div>
                        </div>
                        <div class="card-body p-0">
                                <div class="card">
                                    <div class="card-body p-0">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                <th style="width: 20%">Name</th>
                                                <th style="width: 40%">QTy</th>
                                                <th style="width: 15%">Unit</th>
                                                <th style="width: 15%">Total</th>
                                                <th style="width: 15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- <tr>{{carts}}</tr> -->
                                                <tr v-for="cart in carts" :key=cart.id>
                                                    <td>{{cart.pro_name}}</td>
                                                    <td>
                                                        <input type="text" :value="cart.pro_quantity" style="width:30px" readonly>
                                                        <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success" v-if="cart.quantity>cart.pro_quantity">+</button>
                                                        <button class="btn btn-sm btn-success" v-else disabled>+</button>
                                                        <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-if="cart.pro_quantity>=2"> -</button>
                                                        <button class="btn btn-sm btn-danger" v-else disabled>-</button>
                                                    </td>
                                                    <td>{{cart.pro_price}}</td>
                                                    <td>{{cart.sub_total}}</td>
                                                    <td><a @click="removeItem(cart.id)" class="badge bg-danger" style="cursor:pointer;">x</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Total Quantity:
                                            <strong>{{qty}}</strong>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Sub Total:
                                            <strong>{{subtotal}}</strong>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            VAT:
                                            <strong>{{vats.rate}}%</strong>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            Total:
                                            <strong>{{subtotal*vats.rate/100 + subtotal}}</strong>
                                        </li>
                                    </ul>
                                </div>
                            <form @submit.prevent="orderdone">
                                <div class="form-group p-1 m-1">
                                    <label for="customername">Customer Name</label>
                                    <select class="form-control" id="customername" v-model="customer_id">
                                        <option :value="customer.id" v-for="customer in customers" :key="customer.id">{{customer.name}}</option>
                                    </select>
                                </div>

                                <div class="form-group p-1 m-1">
                                    <label for="pay_amount">Pay Amount</label>
                                    <input type="number" id="pay_amount" class="form-control" v-model="pay">
                                </div>

                                <div class="form-group p-1 m-1">
                                    <label for="due_amount">Due Amount</label>
                                    <input type="number" id="due_amount" class="form-control" v-model="due">
                                </div>

                                <div class="form-group p-1 m-1">
                                    <label for="pay_by">Pay By</label>
                                    <select class="form-control" v-model="pay_by">
                                        <option value="HandCash">Hand Cash</option>
                                        <option value="Cheaque">Cheaque</option>
                                        <option value="GiftCard">Gift Card</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary m-2">Save</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{modalTitle}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <form @submit.prevent="createCustomer" id="customerForm">
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

                                <span class="text-danger mb-2" v-if="errors.phone">{{errors.phone[0]}}</span>
                                <div class="input-group mb-3">
                                    <input type="number" class="form-control" placeholder="Enter Phone Number" min="1" v-model="form.phone">
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

                <div class="col-lg-7 col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">All</a>
                                </li>
                                <li class="nav-item" v-for="category in categories" :key="category.id">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" @click="subproduct(category.id)">{{category.name}}</a>
                                </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        <div class="card-body p-0">
                                            <input type="text" v-model="searchTerm" class="form-control" placeholder="search">
                                            <div class="row mt-2">
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-6 m-2" v-for="product in filtersearch" :key="product.id">
                                                    <button class="btn btn-sm" @click.prevent="addToCart(product.id,product.quantity)">
                                                        <div class="card" style="width: 8rem;">
                                                            <img :src="product.photo" class="card-img-top" id="pp">
                                                            <div class="card-body">
                                                                <small class="card-title">{{product.name}}</small>
                                                                <span v-if="product.quantity>=1" class="badge badge-success">Available ({{product.quantity}})</span>
                                                                <span v-else class="badge badge-danger">Stock out</span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        <input type="text" v-model="getsearchTerm" class="form-control" placeholder="search">
                                            <div class="row mt-2">
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-6 m-2" v-for="getproduct in getfiltersearch" :key="getproduct.id">
                                                    <button class="btn btn-sm" @click.prevent="addToCart(getproduct.id,getproduct.quantity)" v-if="getproduct.quantity==0 ? 'disabled':''">
                                                        <div class="card" style="width: 8rem;">
                                                            <img :src="getproduct.photo" class="card-img-top" id="pp">
                                                            <div class="card-body">
                                                                <small class="card-title">{{getproduct.name}}</small>
                                                                <span v-if="getproduct.quantity>=1" class="badge badge-success">Available ({{getproduct.quantity}})</span>
                                                                <span v-else class="badge badge-danger">Stock out</span>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
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
          modalTitle:'Add Customer',
            form:{
                name:null,
                email:null,
                phone:null,
                address:null,
                photo:null,
            },
            customer_id:'',
            pay:'',
            due:'',
            pay_by:'',
            customers:{},
            errors:{},
            categories:{},
            getproducts:[],
            products:[],
            searchTerm:'',
            getsearchTerm:'',
            carts:[],
            vats:''
        }
    },
    computed:{
        filtersearch(){
            return this.products.filter(product=>{
                return product.name.match(this.searchTerm);
            })
        },
        getfiltersearch(){
            return this.getproducts.filter(getproduct=>{
                return getproduct.name.match(this.getsearchTerm);
            })
        },
        qty(){
            let sum =0;
            for(let i=0; i<this.carts.length;i++){
                sum+=(parseFloat(this.carts[i].pro_quantity))
            }
            return sum;
        },
        subtotal(){
            let sum =0;
            for(let i=0; i<this.carts.length;i++){
                sum+=(parseFloat(this.carts[i].pro_price)) * (parseFloat(this.carts[i].pro_quantity))
            }
            return sum;
        }
    },
    methods:{
        newModal(){
            document.getElementById("customerForm").reset();
            this.modalTitle = 'Add Customer'
            $('#customerModal').modal('show');
        },

        addToCart(id,quantity){
            if(quantity==0){
                Toast.fire({
                  icon: 'warning',
                  title: 'Product stockout!'
                })
            }else{
                axios.get('/api/addToCart/'+id)
                .then(({res})=>{
                    Fire.$emit('AfterAddedCart');
    
                    Toast.fire({
                      icon: 'success',
                      title: 'Added to cart successfully.'
                    })
                })
                .catch(error=>{
                    this.$Progress.fail();
                     this.errors = error.response.data.errors;
                })
            }
        },
        cartProduct(){
            axios.get('/api/cart/product')
                .then(res=>{
                    this.carts = res.data;
                    console.log(this.carts);
                })
                .catch()
        },
        removeItem(id){
            axios.get('/api/remove/cart/'+id)
            .then(res=>{
                Fire.$emit('AfterAddedCart');

                Toast.fire({
                  icon: 'success',
                  title: 'Cart Item Remove Successfully'
                })
            })
            .catch()
        },
        increment(id){
            axios.get('/api/increment/'+id)
            .then(res=>{
                Fire.$emit('AfterAddedCart');

                Toast.fire({
                  icon: 'success',
                  title: 'Item Incremet Successfully'
                })
            })
            .catch()
        },
        decrement(id){
             axios.get('/api/decrement/'+id)
            .then(res=>{
                Fire.$emit('AfterAddedCart');

                Toast.fire({
                  icon: 'success',
                  title: 'Item Decrement Successfully'
                })
            })
            .catch()
        },
        orderdone(){
            let total = this.subtotal*this.vats.rate/100 + this.subtotal;
            var data = {qty:this.qty,subtotal:this.subtotal,customer_id:this.customer_id,payby:this.pay_by,pay:this.pay,due:this.due,vat:this.vats.rate,total:total};

            axios.post('/api/orderdone',data)
            .then(({res})=>{
                Toast.fire({
                  icon: 'success',
                  title: 'Data added successfully'
                })
                this.$router.push({name:'home'})
            })
            .catch(error=>{
                 this.errors = error.response.data.errors;
            })
        },
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
        loadCategory(){
          axios.get('/api/category')
            .then(res=>{
               this.categories = res.data;
            })
            .catch()
        },
        subproduct(id){
            axios.get('/api/getting/product/'+id)
            .then(res=>{
               this.getproducts = res.data;
            })
            .catch()
        },
        vat(){
            axios.get('/api/vat')
            .then(res=>{
                this.vats = res.data;
            })
            .catch()
        },
        allCustomer(){
             axios.get('/api/customer')
            .then(res=>{
               this.customers = res.data;
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
        createCustomer(){
            this.$Progress.start();
            axios.post('/api/customer',this.form)
            .then(({res})=>{
                Fire.$emit('AfterCreate');

                $('#customerModal').modal('hide');
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
 
        
    },
    created(){
        this.loadProduct();
        this.loadCategory();
        this.allCustomer();
        this.cartProduct();
        this.vat();
        Fire.$on('AfterCreate',()=>{
          this.loadProduct();
          this.allCustomer();
        })

        Fire.$on('AfterAddedCart',()=>{
          this.cartProduct();

        })
    }
}
</script>

<style>

</style>