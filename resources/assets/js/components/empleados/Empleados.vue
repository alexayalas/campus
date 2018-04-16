<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Empleados</h2>
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
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Empleado</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Empleados"
                            :columns="columns"
                            :rows="empleados"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.codigo }}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.nombre_completo}}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.dni }}</td>
                                    <td>{{ props.row.perfil.nombre }}</td>
                                    <td>{{ props.row.telefono }}</td>
                                    <td>{{ props.row.celular }}</td>
                                    <td>{{ props.row.email }}</td>
                                    <td>
                                        <button @click.prevent="processEdit(props.row)"><i class="material-icons md-18">mode_edit</i></button>
                                        <button @click.prevent="processDelete(props.row)"><i class="material-icons md-18">delete_forever</i></button>
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
        <modal name="empleado" :width="'70%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Empleado</h3>
                <div class="pull-right close-form" @click="$modal.hide('empleado')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="AccionEmpleado">
                <div class="form-body">
                <div class="col-md-9 pt-20">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Numero DNI <span class="asterisk">*</span></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" name="numero_dni" v-model="dataEmpleado.dni" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                        </div>                         
                    </div><!-- /.form-group -->                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombres <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="afiliado_name" v-model="dataEmpleado.nombres" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Apellidos <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="apellidos" v-model="dataEmpleado.apellidos" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Sexo <span class="asterisk">*</span></label>
                        <div class="col-sm-8 pt-5">
                        <p class="mb-0">
                            Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="dataEmpleado.sexo" required />
                            Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="dataEmpleado.sexo" />
                        </p>
                        </div>
                    </div>                                       
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Telefono </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" name="telefono" v-model="dataEmpleado.telefono" maxlength="7" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <label class="col-sm-2 control-label">Celular </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" name="celular" v-model="dataEmpleado.celular" maxlength="9" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>                        
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" name="email" v-model="dataEmpleado.email">
                        </div>
                    </div><!-- /.form-group -->                          
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Fec.Nacimiento </label>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <masked-input v-model="dataEmpleado.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Fec.de Ingreso </label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <masked-input v-model="dataEmpleado.fecha_ingreso" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>                        
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right">
                            <button id="btn-access" v-show="false" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">...</button>
                            <label class="control-label">Acceso al Sistema </label>
                            <toggle-button :value="dataEmpleado.acceso" v-model="dataEmpleado.acceso" :color="{checked: '#337ab7', unchecked: '#FF0000'}" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" @change="cambioAcceso"/>                            
                        </div>
                        <div class="clearfix"></div>
                        
                        <div :class="[collapse]" id="collapseExample" class="col-md-11 mt-10 pull-right">
                        <div class="well">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Perfil </label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                <basic-select :options="getPerfilesEmpleados"
                                    :selected-option="item_per"
                                    placeholder="seleccione una opción"
                                    @select="onSelectPer"
                                    :isDisabled="editable">
                                </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_per.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_per.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetPer" :disabled="editable"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre de Usuario </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm minusculas" name="empleado_username" v-model="dataEmpleado.username" :disabled="editable"/>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Asociaciones <span class="asterisk">*</span></label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <multi-select :options="asociacioncombo"
                                                :selected-options="dataEmpleado.items_aso"
                                                placeholder="seleccione la Asociacion"
                                                @select="onSelectAso">
                                    </multi-select>
                                </div>
                            </div><!-- /.form-group -->                                                           
                        </div>
                        </div>
                    </div>                    
                                                                                                                                                                                                 
                </div>
                <div class="col-md-2 pt-20">
                    <label class="col-sm-12 text-center">Foto </label>
                    <div class="form-group pull-right">
                        <file-upload @cargaImagen="getImagen" @removeImage="getClear"></file-upload>
                    </div><!-- /.form-group -->
                </div>                    
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('empleado')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i v-show="ShowIcon" :class="[IconClass]"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de vendedores -->
        </modal>        

    </div>
</template>
<script>
import 'semantic-ui-icon/icon.min.css';
import _ from 'lodash'
import { MultiSelect } from 'vue-search-select'
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'empleados',
    mounted() {
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')
        this.$store.dispatch('LOAD_ASOCIACION_COMBOBOX')  
    },
    data() {
        return {  
            searchText: '', // If value is falsy, reset searchText & searchItem
            item_per: { value: '', text: ''},  

            lastSelectItem: {},

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',          

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Codigo',
                field: 'codigo',
                filterable: true,
                width:'10%',
                },
                {
                label: 'Empleado',
                field: 'nombre_completo',
                filterable: true,
                width:'25%',                
                },
                {
                label: 'DNI',
                field: 'dni',
                width:'10%',                
                },
                {
                label: 'Perfil',
                field: 'perfil',
                width:'10%',                
                },                
                {
                label: 'Telefono',
                field: 'telefono',
                width:'8%',                
                },
                {
                label: 'Celular',
                field: 'celular',
                width:'9%',                
                }, 
                {
                label: 'Email',
                field: 'email',
                width:'20%',                
                },
                {
                label: 'Acción',
                html: true,
                width:'10%',                     
                }                               
            ],
            dataEmpleado : {
                codigo:'',
                apellidos:'',
                nombres:'',
                dni:'',
                telefono:'',
                celular:'',
                email:'',
                fecha_nacimiento:'',
                fecha_ingreso:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                sexo:'H',
                foto:'no-image.png',
                perfil_id:'',
                habilitado:1,
                acceso: false,
                username:'',
                image: '',
                items_aso: []       
            },                       
            errors:[],
            editable: false,
            editing : false,
            collapse : 'collapse'            
        }
    },
    components: {
        MaskedInput ,
        BasicSelect,
        MultiSelect  
    },
    computed: {
        ...mapState(['empleados','perfiles','asociacioncombo']),
        ...mapGetters(['getPerfilesEmpleados'])
    }, 
    methods: {
        LoadForm: function(){  
            this.editing = false
            this.editable = false
            this.item_per = { value: '', text: ''}  

            this.lastSelectItem = {}  

            this.dataEmpleado = {
                codigo:'',
                apellidos:'',
                nombres:'',
                dni:'',
                telefono:'',
                celular:'',
                email:'',
                fecha_nacimiento:'',
                fecha_ingreso:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                sexo:'H',
                foto:'no-image.png',
                perfil_id:2,
                habilitado:1,
                acceso:false,   
                username:'',             
                image: '',
                items_aso: []           
            }
            this.$emit('getClear')
            this.$store.dispatch('LOAD_DATA_INIT_EMPLEADOS_LIST')                  
            this.$modal.show('empleado')
        }, 
        AccionEmpleado: function(){
            if(typeof(this.dataEmpleado.id) === "undefined"){
                this.createEmpleado()
            }else{
                this.updateEmpleado()
            }
        },          
        createEmpleado: function(){
            var url = '/api/empleados';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'    

            axios.post(url, this.dataEmpleado).then(response => {
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
            this.$store.dispatch('LOAD_EMPLEADOS_LIST')
            this.errors = [];

            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'  

            this.$modal.hide('empleado');
            toastr.success('Nuevo Empleado creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        }, 
        updateEmpleado: function(){
            var url = '/api/empleados/'+this.dataEmpleado.id;
            toastr.options.closeButton = true
            toastr.options.progressBar = true

            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'   

            axios.put(url, this.dataEmpleado).then(response => {
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
            this.$store.dispatch('LOAD_EMPLEADOS_LIST') 
            this.errors = [];

            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'  

            this.$modal.hide('empleado');
            toastr.success('el Empleado fue actualizado con exito');          
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },        
        processEdit(empl){
            this.collapse = 'collapse'
            this.editing = true
            this.editable = true
            var dataempl = []
            dataempl = _.clone(empl)
            dataempl.acceso = dataempl.acceso == 1 ? true : false
 
            if(dataempl.perfil_id != null){
                this.item_per = this.perfiles.find((perf) => perf.value == dataempl.perfil_id)
            }  

            if(dataempl.acceso){
                this.collapse = 'collapse in'
            }
            this.dataEmpleado = dataempl
            var self = this
            self.items_aso = []

            _.forEach(this.dataEmpleado.user.asociacionesusers, function(value, key) {
                self.items_aso.push(_.find(self.asociacioncombo, function(o) { return o.value == value.asociacion_id; }));
            });            
            this.dataEmpleado.items_aso = self.items_aso      
            if(dataempl.user != null){
                this.dataEmpleado.username = dataempl.user.name
            }
            this.$modal.show('empleado')
        
        },        
        processDelete(row){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Empleado: " + row.nombre_completo + " ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/vendedores/' + row.id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_VENDEDORES_LIST')                    
                toastr.success('Vendedor Eliminado correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },                     
        onClickFn: function(row, index){
            console.log(row); //the object for the row that was clicked on
            console.log(index); // index of the row that was clicked on
            this.$router.push({ name: 'VenDatos',  params: { vendedor : row.id } })
        }, 
        getImagen: function(imagen){
            this.dataEmpleado.image = imagen;
        },
        getClear: function(){
            console.log("evento clear");
        },
        onSelectPer (item_per) {
            this.item_per = item_per
            this.dataEmpleado.perfil_id = item_per.value
        },
        resetPer () {
            this.item_per = {}
            this.dataEmpleado.perfil_id = ''
        }, 
        onSelectAso (items, lastSelectItem) {
            this.dataEmpleado.items_aso = items
            this.lastSelectItem = lastSelectItem
        },          
        cambioAcceso() {
            console.log("checked ",this.dataEmpleado.acceso)
            $('#btn-access').click()
            if(this.editing){      // editando
                if(this.dataEmpleado.user == null){
                    this.resetPer()  
                    this.dataEmpleado.username ='' 
                    this.editable = false                   
                }
            }else{                  // creando
                if(!this.dataEmpleado.acceso){
                    this.resetPer()  
                    this.dataEmpleado.username =''
                }     
            }
  
        }              
 
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

    input.minusculas{
        text-transform:lowercase;
    }   

    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 

    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }    

</style>

