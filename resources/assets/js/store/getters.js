export default {
    getAfiliadoById: (state, getters) => (id) => {
        return state.afiliados.find(afiliado => afiliado.id == id)
    },    
    getubigeos: state => {
        return state.ubigeos
    },  
    getUbigeoById: state => id => {
        return state.ubigeos.find(ubigeo => ubigeo.id == id)
    },      
}