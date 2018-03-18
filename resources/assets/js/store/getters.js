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
}