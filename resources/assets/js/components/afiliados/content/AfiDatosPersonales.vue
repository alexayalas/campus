<template>
    <div class="col-md-9">
        <!-- START FORM VALIDATION STATES -->
        <div class="block">                            
            <h4>Datos Personales</h4>                                
            <div class="col-md-6">
                <div class="form-group has-warning">
                    <label class="control-label">Credencial</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Nombres</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="form-group has-warning">         
                    <label class="control-label">Apellido Paterno</label>
                    <input type="text" class="form-control"/>
                </div> 
                <div class="form-group has-warning">
                    <label class="control-label">Apellido Materno</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Sexo <span class="asterisk">*</span></label>
                    <div class="mb-20">
                    <p class="mb-0">
                        Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="dataAfiliado.sexo" required />
                        Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="dataAfiliado.sexo" />
                    </p>
                    </div>
                </div> 
                <div class="form-group has-warning">
                    <label class="control-label">Numero DNI</label>
                    <input type="text" class="form-control"/>
                </div>  
                <div class="form-group has-warning">
                    <label class="control-label">Telefono</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Celular</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Email</label>
                    <input type="text" class="form-control"/>
                </div> 
                <div class="form-group has-warning">
                    <label class="control-label">Fec.Nacimiento </label>
                    <div>
                    <masked-input v-model="dataAfiliado.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                    </div>
                </div>                                    
            </div>                                
            <div class="col-md-6">
                <div class="form-group has-warning">
                    <label class="control-label">Lugar de Nacimiento</label>
                    <input type="text" class="form-control"/>
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
                    <input type="text" class="form-control"/>
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
                    <input type="text" class="form-control"/>
                </div>  
                <div class="form-group has-warning">
                    <label class="control-label">Profesión</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Estudios</label>
                    <input type="text" class="form-control"/>
                </div>
                                                   
            </div>                                                                                
        </div>
        <!-- END FORM VALIDATION STATES -->                          
        
    </div>  
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'afidatospersonales',
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
        }                                      
    }      
  
}
</script>

