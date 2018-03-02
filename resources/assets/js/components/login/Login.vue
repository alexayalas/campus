<template>
    <div class="login-container">
    
        <div class="login-box animated fadeInDown">
            <div class="login-logo"></div>
            <div class="login-body">
                <div class="login-title"><strong>Welcome</strong>, Please login</div>
                <form action="index.html" class="form-horizontal" method="post">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="text" class="form-control" v-model="dataLogin.name" placeholder="Username"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="password" class="form-control" v-model="dataLogin.password" placeholder="Password"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-info btn-block" @click.prevent="login">Log In</button>
                    </div>
                </div>
                </form>
            </div>
            <div class="login-footer">
                <div class="pull-left">
                    &copy; 2014 AppName
                </div>
                <div class="pull-right">
                    <a href="#">About</a> |
                    <a href="#">Privacy</a> |
                    <a href="#">Contact Us</a>
                </div>
            </div>
        </div>
        
    </div>  
</template>
<script>
export default {
    name:'login',
    data() {
        return {
            dataLogin: {
                name: '',
                password: '',
            },   
            errors:[]          
        }
    },
    methods: {
        login() {
            var url = "/api/login";
            axios.post(url, this.dataLogin).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                    }
                    toastr.error(resultado);
                    return;
                }
                console.log("loggin :",response.data)
                this.$store.dispatch('SAVE_TOKEN');
                //console.log('usuario login:', response.data.user[0])
                this.$router.push({ name: 'Dashboard' })
                toastr.success('Ingreso exitoso')
            }).catch(error => {

                this.errors = error.response;
                console.log("err: ",this.errors) 
                toastr.error("Hubo un error en el proceso: "+this.errors)

            });
        }
    }
}
</script>

