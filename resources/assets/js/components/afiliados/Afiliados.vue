<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Afiliados</h2>
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
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Afiliado</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Afiliados"
                            :columns="columns"
                            :rows="afiliados"
                            :paginate="true"
                            :lineNumbers="true"
                            :onClick="onClickFn"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped"/>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->


                </div>
            </div>                                
            
        </div>        
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="afiliado" :width="'90%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Afiliados</h3>
                <div class="pull-right close-form" @click="$modal.hide('afiliado')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createAfiliado">
                <div class="form-body">
                <div class="col-md-5 pt-20">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Credencial <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="credencial" v-model="dataAfiliado.credencial" required>
                        </div>
                    </div><!-- /.form-group -->                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombres <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="afiliado_name" v-model="dataAfiliado.nombres" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Apellido Paterno <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="apellido_paterno" v-model="dataAfiliado.apellido_paterno" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Apellido Materno <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="apellido_materno" v-model="dataAfiliado.apellido_materno" required>
                        </div>
                    </div><!-- /.form-group --> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Sexo <span class="asterisk">*</span></label>
                        <div class="col-sm-8 pt-5">
                        <p class="mb-0">
                            Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="dataAfiliado.sexo" required />
                            Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="dataAfiliado.sexo" />
                        </p>
                        </div>
                    </div>                                       
                   
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Numero DNI</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="numero_dni" v-model="dataAfiliado.dni" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>                            
                    </div><!-- /.form-group --> 
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Telefono </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="telefono" v-model="dataAfiliado.telefono" maxlength="7" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Celular </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="celular" v-model="dataAfiliado.celular" maxlength="9" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Email </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" name="email" v-model="dataAfiliado.email">
                        </div>
                    </div><!-- /.form-group -->    
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Fec.Nacimiento </label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                        <masked-input v-model="dataAfiliado.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>
                    </div>
                                                                                                                                                                                  
                </div>
                <div class="col-md-2 pt-20">
                    <label class="col-sm-12 text-center">Foto </label>
                    <div class="form-group pull-right">
                        <file-upload @cargaImagen="getImagen" @removeImage="getClear"></file-upload>
                    </div><!-- /.form-group -->
                </div>                    
                <div class="col-md-5 pt-20 pr-20">                  
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Lugar de Nacimiento </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" name="lugar_nacimiento" v-model="dataAfiliado.lugar_nacimiento">
                        </div>
                    </div><!-- /.form-group --> 
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Departamento </label>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <basic-select :options="departamentosBy"
                            :selected-option="item_dpto"
                            placeholder="seleccione una opción"
                            @select="onSelectDpto">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_dpto.text"></span>
                        <div class="col-md-1 col-sm-1" v-if="item_dpto.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetDpto"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Provincia </label>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <basic-select :options="provinciasBy"
                            :selected-option="item_prov"
                            placeholder="seleccione una opción"
                            @select="onSelectProv">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_prov.text"></span>
                        <div class="col-md-1 col-sm-1" v-if="item_prov.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetProv"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Distrito </label>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <basic-select :options="distritosBy"
                            :selected-option="item_dist"
                            placeholder="seleccione una opción"
                            @select="onSelectDist">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_dist.text"></span>
                        <div class="col-md-1 col-sm-1" v-if="item_dist.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetDist"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Domicilio </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="domicilio" v-model="dataAfiliado.domicilio">
                        </div>
                    </div><!-- /.form-group -->                       
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Estado Civil </label>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <basic-select :options="estadosciviles"
                            :selected-option="item_ec"
                            placeholder="seleccione una opción"
                            @select="onSelectEC">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_ec.text"></span>
                        <div class="col-md-1 col-sm-1" v-if="item_ec.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetEC"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>                     
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Nivel de Instrucción </label>
                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <basic-select :options="nivelesinstruccion"
                            :selected-option="item_ni"
                            placeholder="seleccione una opción"
                            @select="onSelectNI">
                            </basic-select>
                        </div>
                        <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_ni.text"></span>
                        <div class="col-md-1 col-sm-1" v-if="item_ni.text">
                            <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetNI"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Ocupación </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" name="ocupacion" v-model="dataAfiliado.ocupacion">
                        </div>
                    </div><!-- /.form-group -->                                                                                                                                                                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Profesion </label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control input-sm" name="profesion" v-model="dataAfiliado.profesion">
                        </div>
                    </div><!-- /.form-group -->                       
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Estudios </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="estudios" v-model="dataAfiliado.estudios">
                        </div>
                    </div><!-- /.form-group -->                    
                </div>
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('afiliado')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de pacientes -->
        </modal>        

    </div>
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name: 'afiliados',
    mounted() {
        this.$store.dispatch('LOAD_AFILIADOS_LIST').then(() => {
            //this.pagination = this.patients_paginate
            //this.show = false
        })  
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

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Credencial',
                field: 'credencial',
                filterable: true,
                width:'10%',
                },
                {
                label: 'Afiliado',
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
            ],
            rows: [
                {id:1, name:"John",age:20,createdAt: '201-10-31:9:35 am',score: 0.03343},
                {id:2, name:"Jane",age:24,createdAt: '2011-10-31',score: 0.03343},
                {id:3, name:"Susan",age:16,createdAt: '2011-10-30',score: 0.03343},
                {id:4, name:"Chris",age:55,createdAt: '2011-10-11',score: 0.03343},
                {id:5, name:"Dan",age:40,createdAt: '2011-10-21',score: 0.03343},
                {id:6, name:"John",age:20,createdAt: '2011-10-31',score: 0.03343},
                {id:7, name:"Jane",age:24,createdAt: '20111031'},
                {id:8, name:"Susan",age:16,createdAt: '2013-10-31',score: 0.03343},
                {id:9, name:"Chris",age:55,createdAt: '2012-10-31',score: 0.03343},
                {id:10, name:"Dan",age:40,createdAt: '2011-10-31',score: 0.03343},
                {id:11, name:"John",age:20,createdAt: '2011-10-31',score: 0.03343},
                {id:12, name:"Jane",age:24,createdAt: '2011-07-31',score: 0.03343},
                {id:13, name:"Susan",age:16,createdAt: '2017-02-28',score: 0.03343},
                {id:14, name:"Chris",age:55,createdAt: '',score: 0.03343},
                {id:15, name:"Dan",age:40,createdAt: '2011-10-31',score: 0.03343},
                {id:19, name:"Chris",age:55,createdAt: '2011-10-31',score: 0.03343},
                {id:20, name:"Dan mr.bot",age:40,createdAt: '2011-10-31',score: 0.03343},
            ],
            dataAfiliado : {
                credencial:'',
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
            nivelesinstruccion :[
                {value: 1 , text: 'Primaria'},
                {value: 2 , text: 'Secundaria'},
                {value: 3 , text: 'Tecnico'},
                {value: 4 , text: 'Universitario'},         
            ],                       
            errors:[]
        }
    },
    components: {
      MaskedInput ,
      BasicSelect
    },    
    computed: {
        ...mapState(['afiliados','estadosciviles']),
        ...mapGetters(['getubigeos']),
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
        LoadForm: function(){  
            this.item_ec = {}
            this.item_ni = {}               

            this.coddep = ''
            this.codpro = ''
            this.coddis = ''
            this.id_dep = '0',
            this.id_pro = '0',
            this.id_dis = '0',        

            this.dataAfiliado = {
                credencial:'',
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
            }
            this.$emit('getClear')
            this.$store.dispatch('LOAD_DATA_INIT_LIST')       
            this.$modal.show('afiliado')
        },  
        createAfiliado: function(){
            var url = '/api/afiliados';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            if(this.id_dep != '0'){
                this.dataAfiliado.ubigeo_id = this.id_dep
                if (this.id_pro != '0') {
                    this.dataAfiliado.ubigeo_id = this.id_pro
                    if (this.id_dis != '0') {
                        this.dataAfiliado.ubigeo_id = this.id_dis
                    }
                }            
            }

            axios.post(url, this.dataAfiliado).then(response => {
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
            this.$store.dispatch('LOAD_AFILIADOS_LIST')
            //this.getAfiliado(this.pagination.current_page,this.patientSearch);          
            this.errors = [];
            this.$modal.hide('afiliado');
            toastr.success('Nuevo Afiliado creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },              
        onClickFn: function(row, index){
            console.log(row); //the object for the row that was clicked on
            console.log(index); // index of the row that was clicked on
            this.$router.push({ name: 'AfiDatosPersonales',  params: { afiliado : row.id } })
        }, 
        getImagen: function(imagen){
            this.dataAfiliado.image = imagen;
        },
        getClear: function(){
            console.log("evento clear");
        },
        getPro: function(){
            this.codpro = "";
            this.dataAfiliado.ubigeo_id ="";
        },
        getDis: function(){
            this.dataAfiliado.ubigeo_id ="";
        },
        onSelectNI (item_ni) {
            this.item_ni = item_ni
            this.dataAfiliado.nivelinstruccion = item_ni.value
        },
        resetNI () {
            this.item_ni = {}
            this.dataAfiliado.nivelinstruccion = ''   
        },
        onSelectEC (item_ec) {
            this.item_ec = item_ec
            this.dataAfiliado.estadocivil_id = item_ec.value
        },
        resetEC () {
            this.item_ec = {}
            this.dataAfiliado.estadocivil_id = ''
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

</style>


