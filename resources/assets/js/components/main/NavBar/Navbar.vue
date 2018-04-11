<template>
    <!-- START PAGE SIDEBAR -->
    <div class="page-sidebar">
        <!-- START X-NAVIGATION -->
        <ul class="x-navigation" v-if="listMenu">
            <li class="xn-logo">
                <a href="index.html">Terrain Admin</a>
                <a href="#" class="x-navigation-control"></a>
            </li>
            <li class="xn-profile">
                <a href="#" class="profile-mini">
                    <img src="assets/images/users/avatar.jpg" alt="John Doe"/>
                </a>
                <div class="profile">
                    <div class="profile-image">
                        <img src="assets/images/users/avatar.jpg" alt="John Doe"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name">John Doe</div>
                        <div class="profile-data-title">Web Developer/Designer</div>
                    </div>
                    <div class="profile-controls">
                        <a href="pages-profile.html" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                    </div>
                </div>                                                                        
            </li>
            <!-- Menu del Sistema -->
<!--             <router-link :to="{ name: 'Dashboard' }" tag="li"><a href="#"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a></router-link>
            <router-link :to="{ name: 'Afiliados' }" tag="li"><a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Afiliados</span></a></router-link>
            <router-link :to="{ name: 'Asociaciones' }" tag="li"><a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Asociaciones</span></a></router-link>
            <li class="xn-openable">
                <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Ventas</span></a>                        
                <ul>
                    <router-link :to="{ name: 'Preventas' }" tag="li"><a href="#"><span class="fa fa-heart"></span>PreVentas</a></router-link>
                    <router-link :to="{ name: 'Ventas' }" tag="li"><a href="#"><span class="fa fa-cogs"></span>Ventas</a></router-link>
                </ul>
            </li>                    
            <router-link :to="{ name: 'Empleados' }" tag="li"><a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Empleados</span></a></router-link>            
            <router-link :to="{ name: 'Vendedores' }" tag="li"><a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Vendedores</span></a></router-link>
            <router-link :to="{ name: 'Usuarios' }" tag="li"><a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Usuarios</span></a></router-link>            
            <li class="xn-openable">
                <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Seguridad</span></a>
                <ul>
                    <router-link :to="{ name: 'Perfiles' }" tag="li"><a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Perfiles</span></a></router-link>                                
                    <li><a href="charts-nvd3.html"><span class="xn-text">Modulos</span></a></li>
                </ul>
            </li> -->  
            <!-- Fin del Menu del Sistema-->   
            <router-link v-for="route in listMenu" v-if="route.options.length == 0 || route.menu_interno == 1" tag="li" :to="{ name: route.nombre_ruta}" :key="route.id">
                <a href="#"><span :class="[route.icono]"></span> <span class="xn-text">{{ route.nombre_plantilla }}</span></a>
            </router-link>
            <li v-for="route in listMenu" v-if="route.options.length > 0 && route.menu_interno == 0" :key="route.id" class="xn-openable">
                <a href="#"><span :class="[route.icono]"></span> <span class="xn-text">{{ route.nombre_plantilla }}</span></a>
                <ul>
                    <router-link v-for="subroute in route.options" v-if="subroute.suboptions.length == 0" tag="li" :to="{ name: subroute.nombre_ruta}" :key="subroute.id">
                        <a href="#"><span :class="[subroute.icono]"></span><span class="xn-text">{{ subroute.nombre_plantilla }}</span></a>
                    </router-link>              
                </ul>
            </li>                           
            
        </ul>
        <!-- END X-NAVIGATION -->
        <div v-if="listMenu.length == 0" class="text-center pt-20">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
            <span>Cargando...</span>
        </div>        
    </div>
    <!-- END PAGE SIDEBAR -->  
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'navbar',
    data () {
      return {
        listMenu : []
      }
    },
    computed: {
        ...mapState(['perfil_user']),
    },   
    created() {
      this.$store.dispatch('LOAD_PERFIL_USER')      
    },
    watch:{
      perfil_user: function(newVal){
        if(newVal != 'undefined' && newVal != null){
          this.listMenu = this.perfil_user
        }
        if(newVal == null){
          this.listMenu = []
        }
      }
    },     
    mounted() {
      console.log("usuario: ",this.user_system)
    }        

}
</script>

