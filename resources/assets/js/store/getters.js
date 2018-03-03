export default {
    getubigeos: state => {
        return state.ubigeos
    },  
    getUbigeoById: state => id => {
        return state.ubigeos.find(ubigeo => ubigeo.id == id)
    },      
}