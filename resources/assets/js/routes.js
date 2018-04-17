import Login from './components/login/Login.vue'
import TemplateMain from './components/main/TemplateMain.vue'
import Dashboard from './components/dashboard/Dashboard.vue'
/*<!-- Opciones del Menu Afiliados -->*/
import Afiliados from './components/afiliados/Afiliados.vue'
import AfiliadosMain from './components/afiliados/AfiliadosMain.vue'
import AfiDatosPersonales from './components/afiliados/content/AfiDatosPersonales.vue'
import AfiDatosFamiliares from './components/afiliados/content/AfiDatosFamiliares.vue'
import AfiDocumentos from './components/afiliados/content/AfiDocumentos.vue'
import AfiPagosExtraordinarios from './components/afiliados/content/AfiPagosExtraordinarios.vue'
import AfiCompras from './components/afiliados/content/AfiCompras.vue'
import AfiPrecompras from './components/afiliados/content/AfiPrecompras.vue'
import AfiPagos from './components/afiliados/content/AfiPagos.vue'
/*<!-- Opciones del Menu Vendedores -->*/
import Vendedores from './components/vendedores/Vendedores.vue'
import VendedoresMain from './components/vendedores/VendedoresMain.vue'
import VenDatos from './components/vendedores/content/VenDatos.vue'
import VenVentas from './components/vendedores/content/VenVentas.vue'
import VenEstadisticas from './components/vendedores/content/VenEstadisticas.vue'

import Empleados from './components/empleados/Empleados.vue'
import Asociaciones from './components/asociaciones/Asociaciones.vue'
import Ubicaciones from './components/asociaciones/Ubicaciones.vue'
import Lotizaciones from './components/asociaciones/Lotizaciones.vue'
import Modulos from './components/seguridad/Modulos.vue'
import Perfiles from './components/seguridad/Perfiles.vue'
import Usuarios from './components/usuarios/Usuarios.vue'
import Ventas from './components/ventas/Ventas.vue'
import Preventas from './components/ventas/Preventas.vue'

import NotFound from './components/errors/NotFound.vue'
import Reportes from './components/reportes/Reportes.vue'

export default [
    {
        path: '/',
        name: 'Admin',
        component: TemplateMain,
        //meta: { requiresAuth: true },
        children: [
            {
                path: '/dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: { requiresAuth: true }
            },
            {
                path: '/afiliados',
                name: 'Afiliados',
                component: Afiliados,
                meta: { requiresAuth: true }
            },
            /*<!-- Menu Afiliados -->*/
            {
                path: '/detalle-afiliados',
                name: 'DetalleAfiliados',
                component: AfiliadosMain,
                children: [
                    {
                        path: 'datospersonales/:afiliado',
                        name: 'AfiDatosPersonales',
                        component: AfiDatosPersonales,
                        props: true
                    },
                    {
                        path: 'datosfamilares/:afiliado',
                        name: 'AfiDatosFamiliares',
                        component: AfiDatosFamiliares,
                        props: true
                    },                    
                    {
                        path: 'documentos/:afiliado',
                        name: 'AfiDocumentos',
                        component: AfiDocumentos,
                        props: true
                    },
                    {
                        path: 'compras/:afiliado',
                        name: 'AfiCompras',
                        component: AfiCompras,
                        props: true
                    },
                    {
                        path: 'precompras/:afiliado',
                        name: 'AfiPrecompras',
                        component: AfiPrecompras,
                        props: true
                    },                    
                    {
                        path: 'pagosextraordinarios/:afiliado',
                        name: 'AfiPagosextraordinarios',
                        component: AfiPagosExtraordinarios,
                        props: true
                    },
                    {
                        path: 'pagos/:afiliado/:venta',
                        name: 'AfiPagos',
                        component: AfiPagos,
                        props: true
                    },                    
                    ]
            },
            /*<!-- Menu Empleados -->*/            
            {
                path: '/empleados',
                name: 'Empleados',
                component: Empleados,
                meta: { requiresAuth: true }
            },            
            /*<!-- Menu Principal Vendedores -->*/
            {
                path: '/vendedores',
                name: 'Vendedores',
                component: Vendedores,
                meta: { requiresAuth: true }
            },            
            /*<!-- Menu Vendedores -->*/
            {
                path: '/detalle-vendedores',
                name: 'DetalleVendedores',
                component: VendedoresMain,
                children: [
                    {
                        path: 'datos/:vendedor',
                        name: 'VenDatos',
                        component: VenDatos,
                        props: true
                    },
                    {
                        path: 'ventas/:vendedor',
                        name: 'VenVentas',
                        component: VenVentas,
                        props: true
                    },                    
                    {
                        path: 'estadisticas/:vendedor',
                        name: 'VenEstadisticas',
                        component: VenEstadisticas,
                        props: true
                    },
                    ]
            },            
            /*<!-- Menu Asociaciones -->*/
            {
                path: '/asociaciones',
                name: 'Asociaciones',
                component: Asociaciones,
                meta: { requiresAuth: true }
            },
            /*<!-- Menu Ubicaciones -->*/
            {
                path: '/ubicaciones/:asociacion',
                name: 'Ubicaciones',
                component: Ubicaciones,
                props: true,
                meta: { requiresAuth: true }
            }, 
            /*<!-- Menu Lotizaciones -->*/    
            {
                path: '/lotizaciones/:ubicacion',
                name: 'Lotizaciones',
                component: Lotizaciones,
                props: true,
                meta: { requiresAuth: true }
            },                      
            /*<!-- Menu Ventas -->*/
            {
                path: '/ventas/ventas',
                name: 'Ventas',
                component: Ventas,
                meta: { requiresAuth: true }
            },
            {
                path: '/ventas/preventas',
                name: 'Preventas',
                component: Preventas,
                meta: { requiresAuth: true }
            },
            {
                path: '/usuarios',
                name: 'Usuarios',
                component: Usuarios,
                meta: { requiresAuth: true }
            },
            /* <!-- Menu Seguridad -->*/
            {
                path: '/seguridad/modulos',
                name: 'Modulos',
                component: Modulos,
                meta: { requiresAuth: true }
            },
            {
                path: '/seguridad/perfiles',
                name: 'Perfiles',
                component: Perfiles,
                meta: { requiresAuth: true }
            },            
            {
                path: '/login',
                name: 'login',
                component: Login,
                meta: { redirectIfLogged: true }
            },
            {
                path: '/reportes',
                name: 'Reportes',
                component: Reportes,
                meta: { requiresAuth: true }
            },            
        ]
    },
    {
        path: '*',
        name: 'not-found',
        component: NotFound
    }

]
