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
    SET_AFILIADOS_LIST: (state, { list }) => {      // PACIENTES
        state.afiliados = list.afiliados.data
        //state.patients_paginate = list.pagination
    },       
}