<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Asociaciones</h2>
        </div>
        <!-- END PAGE TITLE -->                

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">                
        
            <div class="row">
                <div class="col-md-12">

                    <!-- START DEFAULT DATATABLE -->
                    <div class="panel panel-default">
                        <div class="panel-heading">                                
                            <h3 class="panel-title">Vargas Rubio Residencial</h3>  
                            <ul class="panel-controls">
                                <li><button type="button" v-if="user_system.user.empleado.perfil_id == 1" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nueva Asociación</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Asociaciones"
                            :columns="columns"
                            :rows="asociaciones_users"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="onClickFn(props.row.asociacion,props.index)">{{ props.row.asociacion.nombre}}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row.asociacion,props.index)">{{ props.row.asociacion.ruc }}</td>
                                    <td>{{ props.row.asociacion.nombre_comercial }}</td>
                                    <td>{{ props.row.asociacion.fecha_inicio_labores }}</td>
                                    <td>
                                        <button @click.prevent="processEdit(props.row.asociacion)"><i class="material-icons md-18">mode_edit</i></button>
                                        <button @click.prevent="onClickFn(props.row.asociacion,props.index)"><i class="material-icons md-18">location_on</i></button>
                                        <button @click.prevent="processDelete(props.row.asociacion)"><i class="material-icons md-18">delete_forever</i></button>                                    
                                    </td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->


                </div>
            </div>                                
            
        </div>        
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="asociacion" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de ubicaciones -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Estructura de Asociaciones</h3>
                <div class="pull-right close-form" @click="$modal.hide('asociacion')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <div class="form-horizontal form-bordered">
                <div class="form-body">
                    <div class="col-md-11 pt-20">                   
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombres <span class="asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm mayusculas" name="asociacion_name" v-model="dataAsociacion.nombre" required>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">RUC <span class="asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm " name="ruc" v-model="dataAsociacion.ruc" maxlength="11" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre Comercial <span class="asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataAsociacion.nombre_comercial" required>
                            </div>
                        </div><!-- /.form-group -->                                                           
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-4">Fec.Inicio Labores </label>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                            <masked-input v-model="dataAsociacion.fecha_inicio_labores" mask="11-11-1111" placeholder="DD-MM-YYYY" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Descripcion </label>
                            <div class="col-sm-8">
                                <textarea name="descripcion" rows="4" cols="78" v-model="dataAsociacion.descripcion"></textarea>
                            </div>
                        </div><!-- /.form-group -->                    
                                                                                                                                                                                    
                    </div>
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-20 mb-10 mt-20 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('asociacion')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success active" @click.prevent="AccionAsociacion"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </div>
        </div>
        <!-- /. form de registro de pacientes -->
        </modal>        

    </div>
</template>
<script>
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'asociaciones',
    created() {
        //this.$store.dispatch('LOAD_ASOCIACIONES_LIST')
        this.CargaAsociacionUser()        
    },
    mounted(){
        console.log("datos user",this.user_system)
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
                label: 'Nombre',
                field: 'nombre',
                filterable: true,
                width:'30%',
                },
                {
                label: 'RUC',
                field: 'ruc',
                filterable: true,
                width:'15',                
                },
                {
                label: 'Nombre Comercial',
                field: 'nombre_comercial',
                width:'25%',                
                },
                {
                label: 'fecha inicio',
                field: 'fecha_inicio_labores',
                type: 'date',
                inputFormat : 'YYYY-MM-DD',
                outputFormat: 'DD/MM/YYYY',
                width:'15%',                
                },
                {
                label: 'Acción',
                html: true  ,
                width:'15%',  
                }                               
            ],
            dataAsociacion : {
                nombre:'',
                ruc:'',
                nombre_comercial:'',
                user_id: 1,
                fecha_inicio_labores: '',
                descripcion:''
            },                      
            errors:[],
            asociaciones_users:[]
        }
    },
    components: {
      MaskedInput 
    },     
    computed: {
        ...mapState(['asociaciones','user_system'])
    }, 
    methods: {
        LoadForm: function(){
            this.dataAsociacion = {
                nombre:'',
                ruc:'',
                nombre_comercial:'',
                user_id: this.user_system.user.id,
                fecha_inicio_labores: '',
                descripcion:''
            },     
            this.$modal.show('asociacion')            
        },
        CargaAsociacionUser: function(){
            var url = '/api/asociaciones-user'

            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            axios.get(url,{
                params:{
                    user_id: this.user_system.user.id,
                    perfil_id : this.user_system.user.empleado.perfil_id
                }
            }).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                toastr.error(resultado);
                return;
            }
            if(response.data.length >0 ){
                this.asociaciones_users = response.data
            }            
        
            this.errors = [];
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },
        AccionAsociacion: function(){
            if(typeof(this.dataAsociacion.id) === "undefined"){
                this.createAsociacion()
            }else{
                this.updateAsociacion()
            }
        },         
        createAsociacion: function(){
            var url = '/api/asociaciones';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            axios.post(url, this.dataAsociacion).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                toastr.error(resultado);
                return;
            }
            //this.$store.dispatch('LOAD_ASOCIACIONES_LIST')
            this.CargaAsociacionUser()
            //this.getAfiliado(this.pagination.current_page,this.patientSearch);          
            this.errors = [];
            this.$modal.hide('asociacion');
            toastr.success('Nueva Asociacion creada con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },
        updateAsociacion: function(){
            console.log("datos",this.dataAsociacion)
            var url = '/api/asociaciones/'+this.dataAsociacion.id
            toastr.options.closeButton = true
            toastr.options.progressBar = true

            axios.put(url, this.dataAsociacion).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                toastr.error(resultado);
                return;
            }
            this.CargaAsociacionUser()
            this.errors = [];

            this.$modal.hide('asociacion');
            toastr.success('La asociación fue actualizada con exito');          
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },          
        processEdit(asoc) {
            console.log("asociacion",asoc)
            var dataasoc = []
            dataasoc = _.clone(asoc)  
            
            this.dataAsociacion = {
                id:dataasoc.id,
                nombre:dataasoc.nombre,
                ruc:dataasoc.ruc,
                nombre_comercial:dataasoc.nombre_comercial,
                user_id: this.user_system.user.id,
                fecha_inicio_labores: dataasoc.fecha_inicio_labores,
                descripcion:dataasoc.descripcion
            },     
            this.$modal.show('asociacion')                          
        },
        processDelete(row){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar esta Asociacion: " + row.nombre + " ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/asociaciones/' + row.id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                    //this.$store.dispatch('LOAD_ASOCIACIONES_LIST')  
                    this.CargaAsociacionUser()                  
                    toastr.success('Asociacion Eliminada correctamente');
                    dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },
        onClickFn: function(row, index){
            this.$router.push({ name: 'Ubicaciones',  params: { asociacion : row.id } })
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

    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; } 

</style>
