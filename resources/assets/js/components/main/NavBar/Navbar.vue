<template>
    <!-- START PAGE SIDEBAR -->
    <div class="page-sidebar">
        <!-- START X-NAVIGATION -->
        <ul class="x-navigation" v-if="listMenu">
            <li class="xn-logo">
                <a href="/Dashboard">JR</a>
                <a href="#" class="x-navigation-control"></a>
            </li>
            <li class="xn-profile">
                <a href="#" class="profile-mini">
                    <img :src="'/images/'+ user_system.user.empleado.foto" alt="JR"/>
                </a>
                <div class="profile">
                    <div class="profile-image">
                        <img :src="'/images/'+ user_system.user.empleado.foto" alt="JR"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name">{{ user_system.user.empleado.nombre_completo }}</div>
                        <div class="profile-data-title">{{ user_system.user.empleado.perfil.nombre }}</div>
                    </div>
                    <div class="profile-controls">
                        <a href="#" class="profile-control-left"><span class="fa fa-info"></span></a>
                        <a href="#" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                    </div>
                </div>                                                                        
            </li>
            <!-- Menu del Sistema -->             
            <router-link v-for="route in listMenu" v-if="route.options.length == 0 || route.menu_interno == 1" tag="li" :to="{ name: route.nombre_ruta}" :key="route.id">
                <a href="#"><span :class="[route.icono]"></span> <span class="xn-text">{{ route.nombre_plantilla }}</span></a>
            </router-link>
            <template v-for="route in listMenu" v-if="route.options.length > 0 && route.menu_interno == 0">
                <li class="xn-openable" :key="route.id">
                    <a href="#"><span :class="[route.icono]"></span> <span class="xn-text">{{ route.nombre_plantilla }}</span></a>
                    <ul>
                        <router-link v-for="subroute in route.options" v-if="subroute.suboptions.length == 0" tag="li" :to="{ name: subroute.nombre_ruta}" :key="subroute.id">
                            <a href="#"><span :class="[subroute.icono]"></span><span class="xn-text">{{ subroute.nombre_plantilla }}</span></a>
                        </router-link> 
                    </ul>
                </li> 
            </template>  
            <!-- Fin del Menu del Sistema-->                                    
            
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
        ...mapState(['perfil_user','user_system']),
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
    updated(){
      this.getMenuClick()

    },         
    mounted() {
      console.log("usuario: ",this.user_system)
    } ,
    methods: {
        getMenuClick() {
            console.log("cargando actions.js")
            $(".x-navigation-control").click(function(){
                $(this).parents(".x-navigation").toggleClass("x-navigation-open");
                
                onresize();
                
                return false;
            });

            if($(".page-navigation-toggled").length > 0){
                x_navigation_minimize("close");
            }    
            
            $(".x-navigation-minimize").click(function(){
                        
                if($(".page-sidebar .x-navigation").hasClass("x-navigation-minimized")){
                    $(".page-container").removeClass("page-navigation-toggled");
                    x_navigation_minimize("open");
                }else{            
                    $(".page-container").addClass("page-navigation-toggled");
                    x_navigation_minimize("close");            
                }
                
                onresize();
                
                return false;        
            });
            
            $(".x-navigation  li > a").click(function(){

                var li = $(this).parent('li');        
                var ul = li.parent("ul");
                
                ul.find(" > li").not(li).removeClass("active");    
                
            });
            
            $(".x-navigation li").click(function(event){
                event.stopPropagation();
                
                var li = $(this);
                        
                    if(li.children("ul").length > 0 || li.children(".panel").length > 0 || $(this).hasClass("xn-profile") > 0){
                        if(li.hasClass("active")){
                            li.removeClass("active");
                            li.find("li.active").removeClass("active");
                        }else
                            li.addClass("active");
                            
                        onresize();
                        
                        if($(this).hasClass("xn-profile") > 0)
                            return true;
                        else
                            return false;
                    }                                     
            });
            
            /* XN-SEARCH */
            $(".xn-search").on("click",function(){
                $(this).find("input").focus();
            })
            
        }
    }       

}
</script>



