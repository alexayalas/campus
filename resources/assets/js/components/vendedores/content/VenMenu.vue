<template>
    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-body profile" style="background-color: #14171b;">
                <div class="profile-image">
                    <img :src="'/images/'+ vendedorByid.foto" alt="JR"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{ vendedorByid.nombre_completo }}</div>
                    <div class="profile-data-title" style="color: #FFF;">{{ vendedorByid.codigo }}</div>
                </div>
                <div class="profile-controls">
                    <a href="#" class="profile-control-left twitter"><span class="fa fa-twitter"></span></a>
                    <a href="#" class="profile-control-right facebook"><span class="fa fa-facebook"></span></a>
                </div>                                    
            </div>                                
            <div class="panel-body">                                    
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-info btn-rounded btn-block"><span class="fa fa-check"></span> Following</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-rounded btn-block"><span class="fa fa-comments"></span> Chat</button>
                    </div>
                </div>
            </div>
            <div class="panel-body list-group border-bottom">
                <router-link v-for="men in menuPerfil.options" v-if="men.bloque == 1" tag="li" :to="{ name: men.nombre_ruta , params : { vendedor: vendedorByid.id }}" :key="men.id" class="list-group-item enlace" exact><i class="fa fa-angle-double-right pull-left"></i>{{ men.nombre_plantilla }}</router-link>                                              
            </div>
        </div>                            
        
    </div>  
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'venmenu',
    data() {
        return {

        }
    },
    computed: {
      ...mapState(['perfil_user']),          
      ...mapGetters({ getvendedor: 'getEmpleadoById'}),
      vendedorByid: function(){
        return this.getvendedor(this.$route.params.vendedor);
      },
      menuPerfil: function(){
        return this.perfil_user.find((menpac) => menpac.idmenu == 6)  
      }       
    }    
  
}
</script>
<style scoped>
    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 
</style>