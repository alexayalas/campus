export default {
    getAfiliadoById: (state, getters) => (id) => {
        return state.afiliados.find(afiliado => afiliado.id == id)
    },  
    getConyugeAfiliadoById: (state, getters) => (id) => {
        return state.afiliados.find((afiliado) => afiliado.titular_id == id && afiliado.activo == 1)
    },
    getHijoAfiliadoById: (state, getters) => (id) => {
        return state.hijos.filter(hijo => hijo.afiliado_id == id)
    },           
    getubigeos: state => {
        return state.ubigeos
    },  
    getUbigeoById: state => id => {
        return state.ubigeos.find(ubigeo => ubigeo.id == id)
    },
    getUbicacionAsociacionById: (state, getters) => (id) => {
        return state.ubicaciones.filter(ubicacion => ubicacion.asociacion_id == id)
    },  
    getLotizacionUbicacionById: (state, getters) => (id) => {
        return state.lotizaciones.filter(lotes => lotes.ubicacion_id == id)
    }, 
    getVendedores: (state, getters) => {
        return state.empleados.filter(empleados => empleados.perfil_id == 2)
    },     
    getEmpleadoById: (state, getters) => (id) => {
        return state.empleados.find(empleado => empleado.id == id)
    }                    
}