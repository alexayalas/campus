export default {
    LOGOUT(state) {
        state.authenticated = false
        //state.user_system = null
        localStorage.removeItem('autentificado')
        //localStorage.removeItem('user')
    },
    SAVE_TOKEN(state) {
        state.authenticated = true
        //state.user_system = datos    // aca estan los datos del usuario loggeado        
        localStorage.setItem('autentificado', true)
        //localStorage.setItem('user', JSON.stringify(datos))
    },
    SET_AFILIADOS_LIST: (state, { list }) => {      // AFILIADOS
        state.afiliados = list
        //state.patients_paginate = list.pagination
    },  
    SET_ASOCIACIONES_LIST: (state, { list }) => {      // ASOCIACIONES
        state.asociaciones = list
        //state.patients_paginate = list.pagination
    },      
    SET_HIJOS_AFILIADO_LIST: (state, { list }) => {      // HIJOS
        state.hijos = list
        console.log("hijosss",list)
        //state.patients_paginate = list.pagination
    },     
    SET_DATA_INIT_LIST: (state, { list }) => {
        state.estadosciviles = list.estadosciviles
        state.ubigeos = list.ubigeos   
        //console.log('ubigeos',state.ubigeos)
    },        
}