<template>
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
                title="Listado de PreVentas"
                :columns="columns"
                :rows="preventas"
                :paginate="true"
                :lineNumbers="true"
                :rowsPerPageText="textpage"
                :nextText="textnext"
                :prevText="textprev"
                :ofText="textof"
                styleClass="table condensed table-bordered table-striped">
                    <template slot="table-row" slot-scope="props">
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.lotizacion.ubicacion.asociacion.nombre }}</td>
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.vendedor.nombre_completo }}</td>
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.lotizacion.ubicacion.sector}} {{ props.row.lotizacion.ubicacion.grupo}} {{ props.row.lotizacion.ubicacion.manzana}}</td>
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.lotizacion.lote }}</td>
                        <td>{{ props.row.importe }}</td>
                        <td>
                            <button @click.prevent="processVenta(props.row)"><i class="material-icons md-18">border_color</i></button>
                            <button @click.prevent="processDelete(props.row)"><i class="material-icons md-18">delete_forever</i></button>
                        </td>
                    </template>                              
                </vue-good-table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->  
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="venta" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de ventas -->
            <div class="row">
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Venta de Lote</h3>
                    <div class="pull-right close-form" @click="$modal.hide('venta')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createVenta">
                    <div class="form-body">
                    <div class="col-md-11 pt-20">
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-4">Fecha </label>
                            <div class="col-md-8 col-sm-8 col-xs-8">
                            <masked-input v-model="dataVenta.fecha_venta" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                            </div>
                        </div>                   
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Afiliado </label>
                            <div class="col-sm-8">
                                <label class="form-control conborde" for="">{{ afiliado }}</label>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Kardex <span class="asterisk">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control input-sm " name="ruc" v-model="dataVenta.kardex" maxlength="11" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                            </div>
                            <label class="col-sm-2 control-label">Nº Folio <span class="asterisk">*</span></label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataVenta.folio" required>
                            </div>                        
                        </div><!-- /.form-group -->                                                       
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Costo Total <span class="asterisk">*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" name="nombre_comercial" v-model="dataVenta.costo_total" autocomplete="off" @keyup="valorizando" step="any" required />
                            </div>
                            <label class="col-sm-2 control-label">Tipo de Venta <span class="asterisk">*</span></label>
                            <div class="col-sm-3 pt-5">
                                <p class="mb-0">
                                    Contado: <input type="radio" name="contado" id="contado" value="0" v-model="dataVenta.tipo_venta" @change="BloqueoNumCuota(0)" />
                                    Credito: <input type="radio" name="credito" id="credito" value="1" v-model="dataVenta.tipo_venta" @change="BloqueoNumCuota(1)" />
                                </p>
                            </div>                        
                        </div><!-- /.form-group -->                                           
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Num. Cuotas (Mensuales)<span class="asterisk">*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" name="numero_cuotas" v-model="dataVenta.numero_cuotas" autocomplete="off" @keyup="valorizando" :disabled="credito" required>
                            </div>
                            <label class="col-sm-2 control-label">Valor de Cuotas <span class="asterisk">*</span></label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control input-sm" name="valor_cuotas" v-model="dataVenta.valor_cuotas" step="any" required>
                            </div>                        
                        </div><!-- /.form-group --> 
                        <div class="form-group">
                            <label class="control-label col-md-4 col-sm-4 col-xs-4">Fecha 1er Pago </label>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                                <masked-input v-model="dataVenta.fecha_inicial" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                            </div>
                            <label class="col-sm-2 control-label">Importe PreV. </label>
                            <div class="col-sm-3">
                                <label class="form-control conborde" for="">{{ dataVenta.cuota_cero }}</label>
                            </div>                           
                        </div>                                       
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Observaciones </label>
                            <div class="col-sm-8">
                                <textarea name="descripcion" rows="4" cols="78" v-model="dataVenta.observaciones"></textarea>
                            </div>
                        </div><!-- /.form-group -->                    
                                                                                                                                                                                    
                    </div>
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mb-10 mt-20 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('venta')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de ventas -->
        </modal>                             
        
    </div>      
</template>
<script>
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'preventas',
    mounted() {
        this.$store.dispatch('LOAD_PREVENTAS_LIST')            
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
                label: 'Asociacion',
                field: 'asociacion',
                filterable: true,
                width:'20%',
                },
                {
                label: 'Afiliado',
                field: 'afiliado',
                filterable: true,
                width:'20%',
                },                    
                {
                label: 'Ubicacion',
                field: 'ubicacion',
                filterable: true,
                width:'10',                
                },
                {
                label: 'Lote',
                field: 'lote',
                width:'10%',                
                },
                {
                label: 'Importe',
                field: 'importe',
                width:'10%',                
                },                                       
                {
                label: 'Acción',
                html: true  ,
                width:'10%',  
                }                               
            ], 
            dataVenta: {
                preventa_id:'',
                afiliado_id:'',
                kardex:'',
                folio:'',
                lotizacion_id:'',
                ubicacion_id:'',
                fecha_venta:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                costo_total:'',
                tipo_venta:'1',
                numero_cuotas:'',
                valor_cuotas:'',
                fecha_inicial:'',
                estado_venta:'0',
                observaciones:'',
                vendedor_id:'',
                user_id:'',
                cuota_cero:'',
                estado_lote:''  // Tabla de lotizacion
            },  
            afiliado:'', 
            credito: false,              
            errors:[]
        }
    },
    components: {
      MaskedInput 
    },         
    computed: {
        ...mapState(['preventas','user_system']),
    },     
    methods: {
        processVenta: function(row){
            this.dataVenta = {
                preventa_id:row.id,
                afiliado_id:row.afiliado_id,
                kardex:'',
                folio:'',
                lotizacion_id:row.lotizacion_id,
                ubicacion_id:row.lotizacion.ubicacion_id,
                fecha_venta:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                costo_total:'',
                tipo_venta:'1',
                numero_cuotas:'',
                valor_cuotas:'',
                fecha_inicial:'',
                estado_venta:'0',
                observaciones:'',
                vendedor_id:this.user_system.user.empleado_id,
                user_id:this.user_system.user.id,
                cuota_cero:row.importe,
                estado_lote:''  // Tabla de lotizacion
            }
            this.afiliado = row.afiliado.nombre_completo
            this.$modal.show('venta')
        },
        createVenta: function(){
            var url = '/api/ventas';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            this.dataVenta.vendedor_id = this.user_system.user.empleado.id
            this.dataVenta.user_id = this.user_system.user.id            
            //this.dataVenta.ubicacion_id = this.$route.params.ubicacion

            axios.post(url, this.dataVenta).then(response => {
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
            this.$store.dispatch('LOAD_PREVENTAS_LIST')       
            this.errors = [];
            this.$modal.hide('venta');
            toastr.success('Nueva Venta creada con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },        
        onClickFn: function(row, index){
            console.log(row)
        },
        BloqueoNumCuota: function(value){
            if(value == 0){
                this.credito = true
                this.dataVenta.numero_cuotas = '1'
            }
            else
            {
                this.credito = false
            }
            this.valorizando()
        }, 
        valorizando: function(){
            console.log("valorizando ....")
            if(parseInt(this.dataVenta.numero_cuotas) > 0 && parseFloat(this.dataVenta.costo_total).toFixed(2) > 0.00){
                this.dataVenta.valor_cuotas = (parseFloat(this.dataVenta.costo_total).toFixed(2) - parseFloat(this.dataVenta.cuota_cero).toFixed(2)) / parseInt(this.dataVenta.numero_cuotas)
            }
        }                      
    },
       
  
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

    .conborde {
        border:1px solid black;
    }

    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }     
</style>





