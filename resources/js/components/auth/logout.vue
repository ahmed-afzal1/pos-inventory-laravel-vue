<template>
    <div>
        
    </div>
</template>

<script>
export default {
    created(){
        User.loggedOut();

         Toast.fire({
            icon: 'success',
            title: 'Successfully Logout'
        })
        this.$router.push({name:'/'})
    },
}
</script>

<style>

</style>