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
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'vendatos',
    mounted() {
      
    },    
    data() {
        return {
      
        }
    },
    components: {
      MaskedInput 
    },
    computed: {
        ...mapState(['vendedores']),
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

            axios.put(url, this.vendedorByid).then(response => {
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
        }
                                    
    }      
  
}
</script>
<style>
    input.mayusculas{
        text-transform:uppercase;
    }   
</style>