<template>
    <div class="col-md-3">        
        <div class="panel panel-default">
            <div class="panel-body profile" style="background-color: #14171b;">
                <div class="profile-image">
                    <img :src="'/assets/images/users/user5.jpg'" alt="Nadia Ali"/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">Alexander Ayala</div>
                    <div class="profile-data-title" style="color: #FFF;">Web Developer</div>
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
                <router-link class="list-group-item" :to="{ name: 'AfiDatosPersonales' , params : { afiliado: afiliadoByid.id }}" exact><span class="fa fa-bar-chart-o"></span> Datos Personales</router-link>
<!--                 <a href="#" class="list-group-item active"><span class="fa fa-bar-chart-o"></span> Datos Personales</a> -->
                <router-link class="list-group-item" :to="{ name: 'AfiDatosFamiliares' , params : { afiliado: afiliadoByid.id }}" exact><span class="fa fa-coffee"></span> Datos Familiares</router-link>
                <a href="#" class="list-group-item"><span class="fa fa-users"></span> Compras </a>
                <a href="#" class="list-group-item"><span class="fa fa-folder"></span> Pagos Extraordinarios</a>
                <a href="#" class="list-group-item"><span class="fa fa-cog"></span> Documentos</a>
            </div>
        </div>                            
        
    </div>  
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'afimenu',
    data() {
        return {
            nombre:''
        }
    },
    computed: {
      ...mapGetters({ getafiliado: 'getAfiliadoById'}),
      afiliadoByid: function(){
        return this.getafiliado(this.$route.params.afiliado);
      }
    } 
  
}
</script>

