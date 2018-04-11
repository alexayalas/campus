export default {
    LOGOUT({ commit }) {
        return new Promise((resolve, reject) => {
            axios.post('/api/logout')
                .then(function (response) {
                    commit('LOGOUT')
                    resolve()
                })
                .catch(function (error) {
                    console.log(error)
                    reject(error)
                });
        }, error => console.log(error))
    },
    SAVE_TOKEN({ commit }, payload) {
        commit('SAVE_TOKEN', { datos: payload })
    },
    CLOSE_SESSION({ commit }) {
        commit('LOGOUT')
    },
    LOAD_AFILIADOS_LIST: function ({ commit }) {
        //commit('SET_BLANK_PATIENTS_LIST')
        var urlAfiliados = '/api/afiliados';
        return axios.get(urlAfiliados).then((response) => {
            commit('SET_AFILIADOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_ASOCIACIONES_LIST: function ({ commit }) {
        //commit('SET_BLANK_PATIENTS_LIST')
        var urlAsociaciones = '/api/asociaciones';
        return axios.get(urlAsociaciones).then((response) => {
            commit('SET_ASOCIACIONES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },     
    LOAD_HIJOS_AFILIADO_LIST: function ({ commit }) {
        //commit('SET_BLANK_PATIENTS_LIST')
        var urlHijos = '/api/hijos';
        return axios.get(urlHijos).then((response) => {
            commit('SET_HIJOS_AFILIADO_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },     
    LOAD_DATA_INIT_LIST: function ({ commit }) {
        var urlType = '/api/afiliados/create';
        return axios.get(urlType).then((response) => {
            commit('SET_DATA_INIT_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_UBICACIONES_LIST: function ({ commit }) {
        //commit('SET_BLANK_PATIENTS_LIST')
        var urlUbicaciones = '/api/ubicaciones';
        return axios.get(urlUbicaciones).then((response) => {
            commit('SET_UBICACIONES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_LOTIZACIONES_LIST: function ({ commit }) {
        //commit('SET_BLANK_PATIENTS_LIST')
        var urlLotizaciones = '/api/lotizaciones';
        return axios.get(urlLotizaciones).then((response) => {
            commit('SET_LOTIZACIONES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_EMPLEADOS_LIST: function ({ commit }) {
        //commit('SET_BLANK_PATIENTS_LIST')
        var urlEmpleados = '/api/empleados';
        return axios.get(urlEmpleados).then((response) => {
            commit('SET_EMPLEADOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_MODULOS_LIST: function ({ commit }) {
        var urlModulos = '/api/modulos';
        return axios.get(urlModulos).then((response) => {
            commit('SET_MODULOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },    
    LOAD_PERFILES_LIST: function ({ commit }) {
        var urlPerfiles = '/api/perfiles';
        return axios.get(urlPerfiles).then((response) => {
            commit('SET_PERFILES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_DATA_INIT_EMPLEADOS_LIST: function ({ commit }) {
        var urlType = '/api/empleados/create';
        return axios.get(urlType).then((response) => {
            commit('SET_DATA_INIT_EMPLEADOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_USUARIOS_LIST: function ({ commit }, payload) {
        var urlUsers = '/api/users';
        return axios.get(urlUsers).then((response) => {
            commit('SET_USUARIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_PERFIL_USER: function ({ commit, state }) {
        if (state.user_system != null) {
            var url = "/api/perfiles/" + state.user_system.user.empleado.perfil_id
            return axios.get(url).then((response) => {
                commit('SET_PERFIL_USER', { list: response.data })
            }, (err) => {
                console.log(err)
            });
        }
        commit('SET_PERFIL_USER', { list: null })
    },                                        
}