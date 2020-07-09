<template>
    <div class="col-md-9">
        <!-- START FORM VALIDATION STATES -->
        <div class="block">                            
            <h4>Datos Personales</h4>                                
            <div class="col-md-6">
                <div class="form-group has-warning">
                    <label class="control-label">Codigo</label>
                    <input type="text" class="form-control" v-model="vendedorByid.codigo" required/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Numero DNI</label>
                    <input type="text" class="form-control" v-model="vendedorByid.dni" required/>
                </div>                
                <div class="form-group has-warning">
                    <label class="control-label">Nombres</label>
                    <input type="text" class="form-control mayusculas" v-model="vendedorByid.nombres" required/>
                </div>
                <div class="form-group has-warning">         
                    <label class="control-label">Apellidos</label>
                    <input type="text" class="form-control mayusculas" v-model="vendedorByid.apellidos" required/>
                </div> 
                <div class="form-group has-warning">
                    <label class="control-label">Sexo <span class="asterisk">*</span></label>
                    <div class="mb-20">
                    <p class="mb-0">
                        Masculino: <input type="radio" name="gender" id="genderM" value="H" v-model="vendedorByid.sexo" required />
                        Femenino: <input type="radio" name="gender" id="genderF" value="M" v-model="vendedorByid.sexo" />
                    </p>
                    </div>
                </div> 
            </div>
            <div class="col-md-6">
  
                <div class="form-group has-warning">
                    <label class="control-label">Telefono</label>
                    <input type="text" class="form-control" v-model="vendedorByid.telefono"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Celular</label>
                    <input type="text" class="form-control" v-model="vendedorByid.celular"/>
                </div>
                <div class="form-group has-warning">
                    <label class="control-label">Email</label>
                    <input type="text" class="form-control" v-model="vendedorByid.email"/>
                </div> 
                <div class="form-group has-warning">
                    <label class="control-label">Fec.Nacimiento </label>
                    <div>
                    <masked-input v-model="vendedorByid.fecha_nacimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                    </div>
                </div> 
                <div class="form-group has-warning">
                    <label class="control-label">Fec.Ingreso </label>
                    <div>
                    <masked-input v-model="vendedorByid.fecha_ingreso" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                    </div>
                </div>  
                <div class="form-group has-warning">
                    <label class="control-label">Asociaciones <span class="asterisk">*</span></label>
                    <multi-select :options="asociacioncombo"
                                :selected-options="items_asociaciones"
                                placeholder="seleccione la Asociacion"
                                @select="onSelectAso">
                    </multi-select>
                </div><!-- /.form-group -->                                                                    
            </div>                                
            <hr/>
            <div class="col-md-12 mt-20 pt-10" style="border-top:1px solid #000;">
                <div class="form-footer mt-10">
                    <div class="col-sm-offset-3 pull-right mb-20 pr-10">
                        <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>-->
                        <button type="button" @click.prevent="updateVendedor" class="btn btn-success"><i class="fa fa-check-square-o"></i> Actualizar</button>
                    </div>
                </div><!-- /.form-footer -->
            </div>                                                                                
        </div>
        <!-- END FORM VALIDATION STATES -->                          
        
    </div>  
</template>
<script>
//import 'semantic-ui-icon/icon.min.css';
import _ from 'lodash'
import { MultiSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'vendatos',
    mounted() {
        if(typeof this.vendedorByid != 'undefined'){
            if(this.vendedorByid.user != null){
                if(this.vendedorByid.user.asociacionesusers != null){
                    var self = this
                    self.items_aso = []
                    _.forEach(this.vendedorByid.user.asociacionesusers, function(value, key) {
                        self.items_aso.push(_.find(self.asociacioncombo, function(o) { return o.value == value.asociacion_id; }));
                    }); 
                    this.items_asociaciones = self.items_aso
                }
            }

        }      
    },    
    data() {
        return {
            items_asociaciones: [],
            dataCompleta: {}
        }
    },
    components: {
        MaskedInput ,
        MultiSelect  
    },
    computed: {
        ...mapState(['vendedores','asociacioncombo']),
        ...mapGetters(['getEmpleadoById']),
        vendedorByid: function(){
            return this.getEmpleadoById(this.$route.params.vendedor);
        }
    }, 
    methods: {          
        onClickFn: function(row, index){
            console.log(row); //the object for the row that was clicked on
            console.log(index); // index of the row that was clicked on
            this.$router.push({ name: 'VenDatos',  params: { vendedor : row.id } })
        }, 
        updateVendedor: function(){
            var url = '/api/empleados/'+this.$route.params.vendedor;

            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            this.dataCompleta = this.vendedorByid
            this.dataCompleta.items_aso = this.items_asociaciones
            this.dataCompleta.acceso = this.dataCompleta.acceso == 1 ? true : false

            console.log("datitos vendedor ",this.dataCompleta)

            axios.put(url, this.dataCompleta).then(response => {
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
            toastr.success('se actualizo el vendedor con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },        
        getImagen: function(imagen){
            this.vendedorByid.image = imagen;
        },
        getClear: function(){
            console.log("evento clear");
        },
        onSelectAso (items, lastSelectItem) {
            this.items_asociaciones = items
            //this.lastSelectItem = lastSelectItem
        },           
                                    
    }      
  
}
</script>
<style>
    input.mayusculas{
        text-transform:uppercase;
    }   
</style>