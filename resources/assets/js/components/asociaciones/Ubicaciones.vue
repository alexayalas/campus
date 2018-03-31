<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Estructura de la Asociacion</h2>
        </div>
        <!-- END PAGE TITLE -->                

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">                
        
            <div class="row">
                <div class="col-md-12">

                    <!-- START DEFAULT DATATABLE -->
                    <div class="panel panel-default">
                        <div class="panel-heading">                                
                            <h3 class="panel-title">JR</h3>  
                            <ul class="panel-controls">
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nueva Ubicacion</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Estructura de Asociacion"
                            :columns="columns"
                            :rows="ubicacion_asociacionByid"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.sector}}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.grupo }}</td>
                                    <td>{{ props.row.manzana }}</td>
                                    <td>{{ props.row.disponible }}</td>
                                    <td><button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button></td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->


                </div>
            </div>                                
            
        </div>        
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="ubicacion" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de ubicaciones -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Estructura de Asociaciones</h3>
                <div class="pull-right close-form" @click="$modal.hide('ubicacion')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createUbicacion">
                <div class="form-body">
                    <div class="block col-md-12 p-0 mt-10 mb-5">
                    
                        <div class="form-group col-md-3 ml-20 mr-0">
                            <label class="control-label">Sector </label>
                            <input type="text" class="form-control input-sm mayusculas" name="sector" v-model="dataUbicacion.sector">
                        </div><!-- /.form-group -->
                        <div class="form-group col-md-3 mr-0">
                            <label class="control-label">Grupo </label>
                            <input type="text" class="form-control input-sm " name="grupo" v-model="dataUbicacion.grupo" >
                        </div><!-- /.form-group -->
                        <div class="form-group col-md-3 mr-0">
                            <label class="control-label">Manzana <span class="asterisk">*</span></label>
                            <input type="text" class="form-control input-sm mayusculas" name="manzana" v-model="dataUbicacion.manzana" required>
                        </div><!-- /.form-group -->    
                        <div class="form-group col-md-3 pl-15">
                            <label class="control-label">Numero Lotes <span class="asterisk">*</span></label>
                            <input type="number" class="form-control input-sm" name="lotes" v-model="dataUbicacion.lotes" required>
                        </div><!-- /.form-group -->
                        <div class="pull-right mr-20 pr-10">
                            <label><input type="checkbox" v-model="noclose"> Grabar sin cerrar formulario </label>
                        </div>                                                                                            
                                                                                                                                                                                    
                    </div>                    
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-10 mb-10 mt-0 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('ubicacion')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de pacientes -->
        </modal>        

    </div>  
</template>
<script>
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'ubicaciones',
    mounted() {
        this.$store.dispatch('LOAD_UBICACIONES_LIST')
    },  
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Sector',
                field: 'sector',
                filterable: true,
                width:'15%',
                },
                {
                label: 'Grupo',
                field: 'grupo',
                filterable: true,
                width:'15%',                
                },
                {
                label: 'Manzana',
                field: 'manzana',
                width:'15%',                
                },
                {
                label: 'lotes Disponibles',
                field: 'disponible',
                width:'10%',                
                },
                {
                label: 'lotes Vendidos',
                field: 'vendido',
                width:'10%',                
                },
                {
                label: 'Total lotes',
                field: 'lotes_total',
                width:'15%',                
                },                                
                {
                label: 'Acción',
                html: true    
                }                               
            ],
            dataUbicacion : {
                sector:'',
                grupo:'',
                manzana:'',
                lotes:0,
                user_id: 1,
                asociacion:''
            }, 
            noclose: false,                     
            errors:[]
        }
    },    
    computed: {
        ...mapGetters({ getubicacion_asociacion: 'getUbicacionAsociacionById'}),
        ubicacion_asociacionByid: function(){
            console.log("ubicacion:",this.getubicacion_asociacion(this.$route.params.asociacion))
            return this.getubicacion_asociacion(this.$route.params.asociacion);
        }
    },
    methods: {
        LoadForm: function(){
            this.dataUbicacion = {
                sector:'',
                grupo:'',
                manzana:'',
                lotes:0,
                user_id: 1,
                asociacion_id:''
            },       
            this.$modal.show('ubicacion')            
        },  
        createUbicacion: function(){
            var url = '/api/ubicaciones'
            toastr.options.closeButton = true
            toastr.options.progressBar = true
            this.dataUbicacion.asociacion_id = this.$route.params.asociacion

            axios.post(url, this.dataUbicacion).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors
                var resultado = ""
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n"
                    }
                }
                toastr.error(resultado)
                return
            }
            this.$store.dispatch('LOAD_UBICACIONES_LIST')
            //this.getAfiliado(this.pagination.current_page,this.patientSearch);          
            this.errors = []
            if(!this.noclose) {
                this.$modal.hide('asociacion')
            }

            toastr.success('Nueva Estructura creada con exito')
            }).catch(error => {
            this.errors = error.response.data.status
            toastr.error("Hubo un error en el proceso: "+this.errors)
            console.log(error.response.status)
            });
        },               
    }      
}
</script>
<style scoped>
    .title-form {
        background-color: #347c7c;
        color: white;
        margin:0;
        padding:0
    }

    .h3-title {
        margin:10px 0 10px 20px;
        color: white;
    }

    .close-form {
        margin:15px;
        border-radius: 50%;
        cursor: pointer;
    }

    .img-thumbs {
        max-width: 35px;
    }

    .separator {
        border-top: 1px solid #CCC7B8;
    }

    input.mayusculas{
        text-transform:uppercase;
    }  

    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 
</style>

