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
import AfiVentas from './components/afiliados/content/AfiVentas.vue'

import Asociaciones from './components/asociaciones/Asociaciones.vue'
import Modulos from './components/seguridad/Modulos.vue'
import Perfiles from './components/seguridad/Perfiles.vue'
import Usuarios from './components/usuarios/Usuarios.vue'
import Vendedores from './components/vendedores/Vendedores.vue'
import Ventas from './components/ventas/Ventas.vue'
import Preventas from './components/ventas/Preventas.vue'

import NotFound from './components/errors/NotFound.vue'

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
                        path: 'ventas/:afiliado',
                        name: 'AfiVentas',
                        component: AfiVentas,
                        props: true
                    },
                    {
                        path: 'pagosextraordinarios/:afiliado',
                        name: 'AfiPagosextraordinarios',
                        component: AfiPagosExtraordinarios,
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
            /*<!-- Menu Vendedores -->*/
            {
                path: '/vendedores',
                name: 'Vendedores',
                component: Vendedores,
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
        ]
    },
    {
        path: '*',
        name: 'not-found',
        component: NotFound
    }

]
