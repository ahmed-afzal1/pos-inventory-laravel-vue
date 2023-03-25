<template>
    <div>
        <div class="row mt-5">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="register-box ">
                    <div class="card">
                        <div class="card-body register-card-body">
                        <p class="login-box-msg">Login</p>

                        <form @submit.prevent="login">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email Address" v-model="form.email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger mb-2" v-if="errors.email">{{errors.email[0]}}</span>
                            
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger mb-2" v-if="errors.password">{{errors.password[0]}}</span>

                            <div class="row d-plex justify-content-center">
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </div>
                        </form>
                        <router-link to="/register" class="text-center">Register an Account</router-link>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
</template>

<script>
export default {
    created(){
        if(User.loggedIn()){
            this.$router.push({name:'home'})
        }
    },
    data(){
        return{
            form:{
                email:'',
                password:''
            },
            errors:{}
        }
    },
    methods: {
        login(){
            this.$Progress.start();
            axios.post('/api/auth/login',this.form)
            .then(res=> {
                User.resAfterLogin(res)

                Toast.fire({
                icon: 'success',
                title: 'Signed in successfully'
                })

                this.$router.push({name:'home'});
                this.$Progress.finish();
            })
            .catch(error=> {
                this.$Progress.fail();

                this.errors = error.response.data.errors;

                Toast.fire({
                icon: 'warning',
                title: 'Invalid Email Or Password'
                })

                console.log(error.response.data);
            })
        }
    },
}
</script>

<style>

</style>