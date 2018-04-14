export default {
    LOGOUT(state) {
        state.authenticated = false
        //state.user_system = null
        localStorage.removeItem('autentificado')
        //localStorage.removeItem('user')
    },
    SAVE_TOKEN(state, { datos }) {
        state.authenticated = true
        state.user_system = datos    // aca estan los datos del usuario loggeado        
        localStorage.setItem('autentificado', true)
        localStorage.setItem('user', JSON.stringify(datos))
    },
    SET_AFILIADOS_LIST: (state, { list }) => {      // AFILIADOS
        state.afiliados = list
    },  
    SET_ASOCIACIONES_LIST: (state, { list }) => {      // ASOCIACIONES
        state.asociaciones = list
    },      
    SET_HIJOS_AFILIADO_LIST: (state, { list }) => {      // HIJOS
        state.hijos = list
        console.log("hijosss",list)
    },     
    SET_DATA_INIT_LIST: (state, { list }) => {
        state.estadosciviles = list.estadosciviles
        state.ubigeos = list.ubigeos   
        //console.log('ubigeos',state.ubigeos)
    }, 
    SET_UBICACIONES_LIST: (state, { list }) => {      // UBICACIONES
        state.ubicaciones = list
    }, 
    SET_LOTIZACIONES_LIST: (state, { list }) => {      // LOTES
        state.lotizaciones = list
    }, 
    SET_EMPLEADOS_LIST: (state, { list }) => {      // EMPLEADOS
        state.empleados = list
    },
    SET_MODULOS_LIST: (state, { list }) => {      // MODULOS
        state.modulos = list
    },      
    SET_PERFILES_LIST: (state, { list }) => {      // PERFILES
        state.perfiles = list
    }, 
    SET_DATA_INIT_EMPLEADOS_LIST: (state, { list }) => {
        state.perfiles = list
    },  
    SET_USUARIOS_LIST: (state, { list }) => {      // USUARIOS
        state.usuarios = list
    }, 
    SET_PERFIL_USER: (state, { list }) => {      // PERFIL DE USUARIO
        state.perfil_user = list
    }, 
    SET_TIPOS_PAGOSEXTRAORDINARIOS_LIST: (state, { list }) => {      // PERFIL DE USUARIO
        state.tipo_pagosextraordinarios = list
    },                                   
}