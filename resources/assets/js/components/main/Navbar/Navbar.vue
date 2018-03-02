<template>
    <!-- START PAGE SIDEBAR -->
    <div class="page-sidebar">
        <!-- START X-NAVIGATION -->
        <ul class="x-navigation">
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
            <!--<li class="xn-title">Navigation</li>-->
<!--             <li class="active"> -->
                <router-link :to="{ name: 'Dashboard' }" tag="li"><a href="#"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a></router-link>
<!--                 <a href="index.html"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>-->
                <!-- <router-link :to="{ name: 'Dashboard' }"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></router-link> -->                        
            <!-- </li> -->                    
            <!-- <li> -->
                <router-link :to="{ name: 'Afiliados' }" tag="li"><a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Afiliados</span></a></router-link>
                <!-- <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Afiliados</span></a> -->
                <!-- <router-link :to="{ name: 'Afiliados' }"><span class="fa fa-files-o"></span> <span class="xn-text">Afiliados</span></router-link> -->
            <!-- </li> -->
            <!-- <li> -->
                <!-- <a href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Asociaciones</span></a> -->
                <router-link :to="{ name: 'Asociaciones' }" tag="li"><a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Asociaciones</span></a></router-link>
            <!-- </li> -->
            <li class="xn-openable">
                <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">Ventas</span></a>                        
                <ul>
                    <router-link :to="{ name: 'Preventas' }" tag="li"><a href="#"><span class="fa fa-heart"></span>PreVentas</a></router-link>
                    <router-link :to="{ name: 'Ventas' }" tag="li"><a href="#"><span class="fa fa-cogs"></span>Ventas</a></router-link>

                    <!-- <li><a href="ui-widgets.html"><span class="fa fa-heart"></span> PreVentas</a></li> -->                            
                    <!-- <li><a href="ui-elements.html"><span class="fa fa-cogs"></span> Ventas</a></li> -->
                </ul>
            </li>                    
            <li>
                <a href="#"><span class="fa fa-pencil"></span> <span class="xn-text">Vendedores</span></a>
            </li>
            <li>
                <a href="tables.html"><span class="fa fa-table"></span> <span class="xn-text">Usuarios</span></a>
            </li>
            <li class="xn-openable">
                <a href="#"><span class="fa fa-bar-chart-o"></span> <span class="xn-text">Seguridad</span></a>
                <ul>
                    <li><a href="charts-morris.html"><span class="xn-text">Perfiles</span></a></li>
                    <li><a href="charts-nvd3.html"><span class="xn-text">Modulos</span></a></li>
                </ul>
            </li>                    

            
        </ul>
        <!-- END X-NAVIGATION -->
    </div>
    <!-- END PAGE SIDEBAR -->  
</template>
<script>
export default {
    name: 'navbar',
    data() {
        return {
            message:''            
        }
    }  

}
</script>

