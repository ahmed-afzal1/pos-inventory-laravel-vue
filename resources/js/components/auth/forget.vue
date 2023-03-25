<template>
    <div>
        <div class="row d-flex justify-content-center mt-5">
            <div class="register-box ">
                <div class="card">
                    <div class="card-body register-card-body">
                    <p class="login-box-msg">Reset Password</p>

                    <form action="../../index.html" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email Address">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row d-plex justify-content-center">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                            </div>
                        </div>
                    </form>
                    <router-link to="/" class="text-center">Back to login</router-link>
                    </div>
                    <!-- /.form-box -->
                </div><!-- /.card -->
                </div>
            </div>
        </div>
</template>

<script>
export default {
    
}
</script>

<style>

</style>