export default {
    getAfiliadoById: (state, getters) => (id) => {
        return state.afiliados.find(afiliado => afiliado.id == id)
    },  
    getConyugeAfiliadoById: (state, getters) => (id) => {
        return state.afiliados.find((afiliado) => afiliado.titular_id == id && afiliado.activo == 1)
    },      
    getubigeos: state => {
        return state.ubigeos
    },  
    getUbigeoById: state => id => {
        return state.ubigeos.find(ubigeo => ubigeo.id == id)
    },      
}