<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Vendedores</h2>
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
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Vendedor</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Vendedores"
                            :columns="columns"
                            :rows="getVendedores"
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
                                    <td>{{ props.row.telefono }}</td>
                                    <td>{{ props.row.celular }}</td>
                                    <td>{{ props.row.email }}</td>
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
        <modal name="vendedor" :width="'70%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Vendedor</h3>
                <div class="pull-right close-form" @click="$modal.hide('vendedor')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createVendedor">
                <div class="form-body">
                <div class="col-md-9 pt-20">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Codigo <span class="asterisk">*</span></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm mayusculas" name="codigo" v-model="dataVendedor.codigo" required>
                        </div>
                        <label class="col-sm-2 control-label">Numero DNI <span class="asterisk">*</span></label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" name="numero_dni" v-model="dataVendedor.dni" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                        </div>                         
                    </div><!-- /.form-group -->                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombres <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="afiliado_name" v-model="dataVendedor.nombres" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Apellidos <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="apellidos" v-model="dataVendedor.apellidos" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Sexo <span class="asterisk">*</span></label>
                        <div class="col-sm-8 pt-5">
                        <p class="mb-0">
                            Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="dataVendedor.sexo" required />
                            Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="dataVendedor.sexo" />
                        </p>
                        </div>
                    </div>                                       
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Telefono </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" name="telefono" v-model="dataVendedor.telefono" maxlength="7" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                        <label class="col-sm-2 control-label">Celular </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control input-sm" name="celular" v-model="dataVendedor.celular" maxlength="9" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div> 
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" name="email" v-model="dataVendedor.email">
                        </div>
                    </div><!-- /.form-group -->    
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Fec.Nacimiento </label>
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <masked-input v-model="dataVendedor.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>
                        <label class="control-label col-md-3 col-sm-3 col-xs-3">Fec.de Ingreso </label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <masked-input v-model="dataVendedor.fecha_ingreso" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre de Usuario <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm minusculas" name="empleado_username" v-model="dataVendedor.username" required/>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Asociaciones <span class="asterisk">*</span></label>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <multi-select :options="asociacioncombo"
                                        :selected-options="dataVendedor.items_aso"
                                        placeholder="seleccione la Asociacion"
                                        @select="onSelectAso">
                            </multi-select>
                        </div>

                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!dataVendedor.items_aso.text"></span>
                        <div class="col-md-1 col-sm-1" v-if="dataVendedor.items_aso.text">
                        <button type="button" title="Borrar Opción" class="btn btn-danger btn-md pull-right" @click.prevent="resetAso"><i class="fa fa-close"></i> </button>
                        </div>
                    </div><!-- /.form-group -->                       
                                                                                                                                                                                                 
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
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('vendedor')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de vendedores -->
        </modal>        

    </div>
</template>
<script>
//import 'semantic-ui-icon/icon.min.css';
import { MultiSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'vendedores',
    mounted() {
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')
        this.$store.dispatch('LOAD_ASOCIACION_COMBOBOX')  
    },
    data() {
        return {  
            lastSelectItem: {},

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
                label: 'Vendedor',
                field: 'nombre_completo',
                filterable: true,
                width:'30%',                
                },
                {
                label: 'DNI',
                field: 'dni',
                width:'10%',                
                },
                {
                label: 'Telefono',
                field: 'telefono',
                width:'10%',                
                },
                {
                label: 'Celular',
                field: 'celular',
                width:'10%',                
                }, 
                {
                label: 'Email',
                field: 'email',
                width:'30%',                
                },
                {
                label: 'Acción',
                html: true    
                }                               
            ],
            dataVendedor : {
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
                acceso:1,
                image: '',
                username:'',
                items_aso: []         
            },                       
            errors:[]
        }
    },
    components: {
        MaskedInput,
        MultiSelect        
    },
    computed: {
        ...mapState(['vendedores','asociacioncombo']),
        ...mapGetters(['getVendedores']),        
    }, 
    methods: {
        LoadForm: function(){  
            this.lastSelectItem = {}  

            this.dataVendedor = {
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
                acceso:1,                
                image: '',
                username:'',
                items_aso: []          
            }
            this.$emit('getClear')     
            this.$modal.show('vendedor')
        },  
        createVendedor: function(){
            var url = '/api/empleados';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            if(this.dataVendedor.items_aso.length == 0){
                toastr.warning('Tiene que asignar al menos una asociacion al vendedor !!!');
                return
            }
            //this.dataVendedor.username = this.dataVendedor.dni  // nombre de usuario por defecto de vendedores

            axios.post(url, this.dataVendedor).then(response => {
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
            //this.getAfiliado(this.pagination.current_page,this.patientSearch);          
            this.errors = [];
            this.$modal.hide('vendedor');
            toastr.success('Nuevo Vendedor creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        }, 
        processDelete(row){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Afiliado: " + row.nombre_completo + " ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/empleados/' + row.id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_EMPLEADOS_LIST')                    
                //this.getPatient(this.pagination.current_page,this.patientSearch); 
                //this.$store.dispatch('LOAD_PATIENTS_LIST', { page: this.$route.params.page, search:this.patientSearch });     
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
            this.dataVendedor.image = imagen;
        },
        getClear: function(){
            console.log("evento clear");
        },
        onSelectAso (items, lastSelectItem) {
            this.dataVendedor.items_aso = items
            this.lastSelectItem = lastSelectItem
        },
        resetAso () {
            this.dataVendedor.items_aso = [] // reset
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

  input.minusculas{
    text-transform:lowercase;
  }  
  .enlace:hover {
    cursor:pointer; cursor: hand	      
  } 

</style>

