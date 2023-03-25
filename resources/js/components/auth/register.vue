<template>
    <div>
        <div class="row d-flex justify-content-center mt-5">
            <div class="register-box ">
                <div class="card">
                    <div class="card-body register-card-body">
                    <p class="login-box-msg">Register an Account</p>

                    <form @submit.prevent="signup">
                        <span class="text-danger mb-2" v-if="errors.name">{{errors.name[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Full name" v-model="form.name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <span class="text-danger mb-2" v-if="errors.email">{{errors.email[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" v-model="form.email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <span class="text-danger mb-2" v-if="errors.password">{{errors.password[0]}}</span>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" v-model="form.password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Retype password" v-model="form.password_confirmation">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row d-plex justify-content-center">
                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
                            </div>
                        </div>
                    </form>
                    <router-link to="/" class="text-center">Already have an account?</router-link>
                    </div>
                </div>
                </div>
            </div>
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
                name:'',
                email:'',
                password:'',
                password_confirmation:''
            },
            errors:{}
        }
    },
    methods: {
        signup(){
            this.$Progress.start();
            axios.post('/api/auth/signup',this.form)
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