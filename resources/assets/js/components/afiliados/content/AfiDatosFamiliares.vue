<template>
    <div class="col-md-9">
        <transition name="fade">
            <!-- START FORM VALIDATION STATES -->
            <div class="block" v-if="opsee">                            
                <h4>Datos Familiares</h4> 
                <div>
                    <h3>Datos del Conyuge</h3>
                </div>                               
                <div class="col-md-6">
                    <div class="form-group has-warning">
                        <label class="control-label">Nombres</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.nombres" required/>
                    </div>
                    <div class="form-group has-warning">         
                        <label class="control-label">Apellido Paterno</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.apellido_paterno" required/>
                    </div> 
                    <div class="form-group has-warning">
                        <label class="control-label">Apellido Materno</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.apellido_materno" required/>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label">Sexo <span class="asterisk">*</span></label>
                        <div class="mb-20">
                        <p class="mb-0">
                            Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="conyuge_afiliadoByid.sexo" required />
                            Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="conyuge_afiliadoByid.sexo" />
                        </p>
                        </div>
                    </div> 
                    <div class="form-group has-warning">
                        <label class="control-label">Numero DNI</label>
                        <input type="text" class="form-control" v-model="conyuge_afiliadoByid.dni" required/>
                    </div>  
                    <div class="form-group has-warning">
                        <label class="control-label">Telefono</label>
                        <input type="text" class="form-control" v-model="conyuge_afiliadoByid.telefono"/>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label">Celular</label>
                        <input type="text" class="form-control" v-model="conyuge_afiliadoByid.celular"/>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label">Email</label>
                        <input type="text" class="form-control" v-model="conyuge_afiliadoByid.email"/>
                    </div> 
                    <div class="form-group has-warning">
                        <label class="control-label">Fec.Nacimiento </label>
                        <div>
                        <masked-input v-model="conyuge_afiliadoByid.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>
                    </div>                                    
                </div>                                
                <div class="col-md-6">
                    <div class="form-group has-warning">
                        <label class="control-label">Lugar de Nacimiento</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.lugar_nacimiento"/>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0">Departamento</label>
                        <div class="col-md-10 col-sm-10 col-xs-10 pl-0">
                            <basic-select :options="departamentosBy"
                            :selected-option="item_dpto"
                            placeholder="seleccione una opción"
                            @select="onSelectDpto">
                            </basic-select>
                        </div>
                        <span class="col-md-1 col-sm-1 glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_dpto.text"></span>
                        <div class="col-md-1 col-sm-1 ml-10" v-if="item_dpto.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetDpto"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0 mt-10">Provincia</label>
                        <div class="col-md-10 col-sm-10 col-xs-10 pl-0">
                            <basic-select :options="provinciasBy"
                            :selected-option="item_prov"
                            placeholder="seleccione una opción"
                            @select="onSelectProv">
                            </basic-select>
                        </div>
                        <span class="col-md-1 col-sm-1 glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_prov.text"></span>
                        <div class="col-md-1 col-sm-1 ml-10" v-if="item_prov.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetProv"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>  
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0 mt-10">Distrito</label>
                        <div class="col-md-10 col-sm-10 col-xs-10 pl-0">
                            <basic-select :options="distritosBy"
                            :selected-option="item_dist"
                            placeholder="seleccione una opción"
                            @select="onSelectDist">
                            </basic-select>
                        </div>
                        <span class="col-md-1 col-sm-1 glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_dist.text"></span>
                        <div class="col-md-1 col-sm-1 ml-10" v-if="item_dist.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetDist"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0 mt-10">Domicilio</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.domicilio"/>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0 mb-0">Estado Civil </label>
                        <div class="col-md-10 col-sm-10 col-xs-10 pl-0">
                            <basic-select :options="estadosciviles"
                            :selected-option="item_ec"
                            placeholder="seleccione una opción"
                            @select="onSelectEC">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_ec.text"></span>
                        <div class="col-md-1 col-sm-1 ml-10" v-if="item_ec.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right mb-10" @click.prevent="resetEC"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0 mt-10 mb-0">Nivel de Instrucción </label>
                        <div class="col-md-10 col-sm-10 col-xs-10 pl-0">
                            <basic-select :options="nivelesinstruccion"
                            :selected-option="item_ni"
                            placeholder="seleccione una opción"
                            @select="onSelectNI">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_ni.text"></span>
                        <div class="col-md-1 col-sm-1 ml-10" v-if="item_ni.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right mb-10" @click.prevent="resetNI"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label col-md-12 col-sm-12 pl-0 mt-10 mb-0">Ocupación</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.ocupacion"/>
                    </div>  
                    <div class="form-group has-warning">
                        <label class="control-label">Profesión</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.profesion"/>
                    </div>
                    <div class="form-group has-warning">
                        <label class="control-label">Estudios</label>
                        <input type="text" class="form-control mayusculas" v-model="conyuge_afiliadoByid.estudios"/>
                    </div>
                                                    
                </div>
                <hr/>
                <div class="col-md-12 mt-20 pt-10" style="border-top:1px solid #000;">
                    <div class="form-footer mt-10">
                        <div class="col-sm-offset-3 pull-right mb-20 pr-10">
                            <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                            <button type="button" @click.prevent="opsee = false" v-if="opbtn" class="btn btn-danger"><i class="fa fa-check-square-o"></i> Cancelar</button>
                            <button type="button" @click.prevent="createAfiliado" v-if="opbtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> Grabar</button>
                            <button type="button" @click.prevent="updateAfiliado" v-if="!opbtn" class="btn btn-success"><i class="fa fa-check-square-o"></i> Actualizar</button>
                        </div>
                    </div><!-- /.form-footer -->
                </div>                                                                                
            </div>
            <!-- END FORM VALIDATION STATES --> 
        </transition>
        <transition name="fade">        
            <!-- DATA EMPTY CONYUGE -->   
            <div class="block" v-if="!opsee">
                <h4>Datos Familiares</h4> 
                <div>
                    <h3>Datos del Conyuge</h3>
                </div>             
                <div class="text-center">
                    <label for="" class="form-control text-center" >No hay datos para mostrar</label>
                    <button class="btn btn-success" @click.prevent="opsee = true">Agregar Conyuge</button>
                </div>
            </div>                 
            <!-- END DATA EMPTY CONYUGE -->  
        </transition>   
        <div class="row">
            <div class="col-md-12">

                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-default">
                    <div class="panel-heading">                                
<!--                         <h3 class="panel-title">JR</h3>  --> 
                        <ul class="panel-controls">
                            <li><button type="button" class="btn btn-info" @click.prevent="$modal.show('hijo')"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Agregar Hijo</button></li>
                        </ul>                                                        
                    </div>
                    <div class="panel-body">
                        <vue-good-table
                        title="Hijos del Afiliado"
                        :columns="columns"
                        :rows="hijosafiliado"                        
                        :paginate="true"
                        :lineNumbers="true"
                        :rowsPerPageText="textpage"
                        :nextText="textnext"
                        :prevText="textprev"
                        :ofText="textof"
                        styleClass="table condensed table-bordered table-striped">
                         
                        </vue-good-table>                       
                      
                    </div>
                </div>
                <!-- END DEFAULT DATATABLE -->

            </div>
            <!-- MODAL DE HIJOS -->
            <modal name="hijo" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de afiliados -->
            <div class="row">
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Registro de Hijos</h3>
                    <div class="pull-right close-form" @click="$modal.hide('hijo')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createHijo">
                    <div class="form-body">
                    <div class="col-md-12 pt-20">                  
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Apellidos <span class="asterisk">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm mayusculas" name="afiliado_name" v-model="dataHijo.apellidos" required>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombres <span class="asterisk">*</span></label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm mayusculas" name="apellido_paterno" v-model="dataHijo.nombres" required>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Sexo <span class="asterisk">*</span></label>
                            <div class="col-sm-7 pt-5">
                            <p class="mb-0">
                                Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="dataHijo.sexo" required />
                                Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="dataHijo.sexo" />
                            </p>
                            </div>
                        </div>                                                           
  
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-4">Fec.Nacimiento </label>
                            <div class="col-md-7 col-sm-7 col-xs-7">
                            <masked-input v-model="dataHijo.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Estudios </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="domicilio" v-model="dataHijo.estudios">
                            </div>
                        </div><!-- /.form-group -->                       
                    
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Centro de Trabajo </label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="ocupacion" v-model="dataHijo.centro_trabajo">
                            </div>
                        </div><!-- /.form-group -->                           
                                                                                                                                                                                    
                    </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mb-10 mt-20 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('hijo')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de pacientes -->
            </modal> 
            <!-- FINAL MODAL DE HIJOS -->

        </div>        
    </div>    
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'afidatospersonales',
    mounted() {
        this.$store.dispatch('LOAD_HIJOS_AFILIADO_LIST').then(() => {
            this.hijosafiliado = this.getHijoAfiliadoById(this.$route.params.afiliado)
        })        

        if(typeof this.getConyugeAfiliadoById(this.$route.params.afiliado) != 'undefined'){
            this.opsee = true
            this.opbtn = false
            //this.show = false
            this.conyuge_afiliadoByid = this.getConyugeAfiliadoById(this.$route.params.afiliado)            
            if(this.conyuge_afiliadoByid.ubigeo_id != null){
                this.coddep = this.conyuge_afiliadoByid.ubigeo.coddpto;
                this.codpro = this.conyuge_afiliadoByid.ubigeo.codprov;
                this.coddis = this.conyuge_afiliadoByid.ubigeo.coddist;          
                this.item_dpto = this.departamentosBy.find(depa => depa.coddpto == this.conyuge_afiliadoByid.ubigeo.coddpto)
                    if(this.codpro != '00'){
                        this.item_prov = this.provinciasBy.find(provi => provi.codprov == this.conyuge_afiliadoByid.ubigeo.codprov)
                    }
                    if(this.coddis != '00'){
                        this.item_dist = this.distritosBy.find(dist => dist.value == this.conyuge_afiliadoByid.ubigeo_id)
                    }
            }
            if(this.conyuge_afiliadoByid.estadocivil_id != null){
                this.item_ec = this.estadosciviles.find(type => type.value == this.conyuge_afiliadoByid.estadocivil_id)
            }
            if(this.conyuge_afiliadoByid.nivel_instruccion != null){
                this.item_ni = this.nivelesinstruccion.find(niv => niv.value == this.conyuge_afiliadoByid.nivel_instruccion)
            }  
        }      
    },    
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem
            item_ec: { value: '', text: ''},  
            item_ni: { value: '', text: ''},                
            item_dpto: { value: '', text: ''},
            item_prov: { value: '', text: ''},
            item_dist: { value: '', text: ''},

            coddep:'',
            codpro:'',
            coddis:'',
            id_dep:'0',
            id_pro:'0',
            id_dis:'0', 

            opsee: false,
            opbtn: true,

            conyuge_afiliadoByid : {
                credencial:'0',
                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',
                domicilio: '',
                dni:'',
                telefono:'',
                celular:'',
                email:'',
                fecha_nacimiento:'',
                lugar_nacimiento:'',
                ubigeo_id:'',
                ocupacion:'',
                nivel_instruccion:'',
                sexo:'H',
                estadocivil_id:'',
                profesion:'',
                foto:'no-image.png',
                condicion:'',
                estudios:'',
                titular_id:'',
                user_id:'',
                image: ''       
            }, 

            dataHijo: {
                apellidos:'',
                nombres:'',
                fecha_nacimiento:'',
                sexo:'H',
                estudios:'',
                centro_trabajo:'',
                afiliado_id:'',
                user_id:'1',
            },
            hijosafiliado:[],

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Apellidos',
                field: 'apellidos',
                filterable: true,
                width:'25%',
                },
                {
                label: 'Nombres',
                field: 'nombres',
                filterable: true,
                width:'25%',                
                },
                {
                label: 'fecha_nac.',
                field: 'fecha_nacimiento',
                type: 'date',
                inputFormat : 'YYYY-MM-DD',
                outputFormat: 'DD/MM/YYYY',
                width:'15%',                
                },
                {
                label: 'Estudios',
                field: 'estudios',
                width:'15%',                
                },
                {
                label: 'Centro Trab.',
                field: 'centro_trabajo',
                width:'20%',                
                },
                { 
                label: 'Action',
                html: true,                                             
                },
            ],

            nivelesinstruccion :[
                {value: 1 , text: 'Primaria'},
                {value: 2 , text: 'Secundaria'},
                {value: 3 , text: 'Tecnico'},
                {value: 4 , text: 'Universitario'},         
            ],             
        }
    },
    components: {
      MaskedInput ,
      BasicSelect
    },
    computed: {
        ...mapState(['afiliados','hijos','estadosciviles']),
        ...mapGetters(['getAfiliadoById','getConyugeAfiliadoById','getHijoAfiliadoById','getubigeos']),
/*         conyuge_afiliadoByid: function(){
            //console.log("afiliado datos: ",this.getAfiliadoById(this.$route.params.afiliado))  
            return this.getConyugeAfiliadoById(this.$route.params.afiliado);
        },    */     
        departamentosBy: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        provinciasBy: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddpto == this.coddep).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        distritosBy: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddpto == this.coddep).filter((ubigeo) => ubigeo.codprov == this.codpro).filter((ubigeo) => ubigeo.coddist != '00');
        }
    }, 
    methods: {          
        onClickFn: function(row, index){
            console.log(row); //the object for the row that was clicked on
            console.log(index); // index of the row that was clicked on
            this.$router.push({ name: 'AfiDatosPersonales',  params: { afiliado : row.id } })
        }, 
        createAfiliado: function(){
            var url = '/api/afiliados';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            if(this.id_dep != '0'){
                this.conyuge_afiliadoByid.ubigeo_id = this.id_dep
                if (this.id_pro != '0') {
                    this.conyuge_afiliadoByid.ubigeo_id = this.id_pro
                    if (this.id_dis != '0') {
                        this.conyuge_afiliadoByid.ubigeo_id = this.id_dis
                    }
                }            
            }
            this.conyuge_afiliadoByid.titular_id = this.$route.params.afiliado

            axios.post(url, this.conyuge_afiliadoByid).then(response => {
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
            this.$store.dispatch('LOAD_AFILIADOS_LIST').then(() => {
                this.conyuge_afiliadoByid = this.getConyugeAfiliadoById(this.$route.params.afiliado)
            })  

            //this.getAfiliado(this.pagination.current_page,this.patientSearch);          
            this.errors = [];
            //this.$modal.hide('afiliado');
            this.opbtn = false
            toastr.success('Conyuge creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },         
        updateAfiliado: function(){
            if(this.id_dep != '0'){
                this.conyuge_afiliadoByid.ubigeo_id = this.id_dep          
            } 
            if (this.id_pro != '0') {
                this.conyuge_afiliadoByid.ubigeo_id = this.id_pro
            }  
            if (this.id_dis != '0') {
                this.conyuge_afiliadoByid.ubigeo_id = this.id_dis
            }                                   
            var data_completa = this.conyuge_afiliadoByid
            var url = '/api/afiliados/'+this.conyuge_afiliadoByid.id;

            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            axios.put(url, data_completa).then(response => {
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
            this.errors = [];
            toastr.success('se actualizo el afiliado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        }, 
        createHijo: function(){
            var url = '/api/hijos';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            this.dataHijo.afiliado_id = this.$route.params.afiliado

            axios.post(url, this.dataHijo).then(response => {
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
            this.$store.dispatch('LOAD_HIJOS_AFILIADO_LIST').then(() => {
                this.hijosafiliado = this.getHijoAfiliadoById(this.$route.params.afiliado)
            }) 

            //this.getAfiliado(this.pagination.current_page,this.patientSearch);   
            this.errors = [];
            this.$modal.hide('hijo');
            //this.opbtn = false
            toastr.success('Hijo creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },                        
        getImagen: function(imagen){
            this.conyuge_afiliadoByid.image = imagen;
        },
        getClear: function(){
            console.log("evento clear");
        },
        getPro: function(){
            this.codpro = "";
            this.conyuge_afiliadoByid.ubigeo_id ="";
        },
        getDis: function(){
            this.conyuge_afiliadoByid.ubigeo_id ="";
        },
        onSelectNI (item_ni) {
            this.item_ni = item_ni
            this.conyuge_afiliadoByid.nivelinstruccion = item_ni.value
        },
        resetNI () {
            this.item_ni = {}
            this.conyuge_afiliadoByid.nivelinstruccion = ''   
        },
        onSelectEC (item_ec) {
            this.item_ec = item_ec
            this.conyuge_afiliadoByid.estadocivil_id = item_ec.value
        },
        resetEC () {
            this.item_ec = {}
            this.conyuge_afiliadoByid.estadocivil_id = ''
        },      
        onSelectDpto (item_dpto) {
            this.item_dpto = item_dpto
            this.coddep = item_dpto.coddpto
            this.resetProv()
            this.id_dep = item_dpto.value        
        },
        resetDpto () {
            this.item_dpto = {}
            this.coddep = ''
            this.id_dep = '0'        
            this.resetProv()   
        },   
        onSelectProv (item_prov) {
            this.item_prov = item_prov
            this.codpro = item_prov.codprov
            this.resetDist()
            this.id_pro = item_prov.value         
        },
        resetProv () {
            this.item_prov = {}
            this.codpro = ''
            this.id_pro = '0'        
            this.resetDist()
        }, 
        onSelectDist (item_dist) {
            this.item_dist = item_dist
            this.id_dis = item_dist.value   
            //this.dataPatient.ubigeo_id = item_dist.value
        },
        resetDist () {
            this.item_dist = {}
            this.id_dis = '0'
            //this.dataPatient.ubigeo_id = ''
        }                                      
    }      
    
  
}
</script>
<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
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
     
</style>


