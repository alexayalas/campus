<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Listado de Lotes</h2>
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
                            title="Listado de Lotes"
                            :columns="columns"
                            :rows="lotizacion_ubicacionByid"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td>{{ props.row.ubicacion.manzana }}</td>
                                    <td>{{ props.row.lote }}</td>
                                    <td>{{ props.row.estado_lote }}</td>
                                    <td class="text-center">
                                        <button v-bind:disabled="props.row.estado_lote != 'disponible'" @click.prevent="processPreventa(props.row)"><i class="material-icons">vpn_key</i></button>
                                        <button v-bind:disabled="props.row.estado_lote != 'disponible'" @click.prevent="processVenta(props.row)"><i class="material-icons">shopping_cart</i></button>
                                        <button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button>
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
        <modal name="venta" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de ubicaciones -->
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
                        <label class="col-sm-4 control-label">DNI <span class="asterisk">*</span></label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" name="dni" v-model="dataVenta.dni" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                                <span class="input-group-addon" @click.prevent="buscaAfiliado"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <label class="col-sm-2 control-label">Credencial <span class="asterisk">*</span></label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm" name="credencial" v-model="dataVenta.credencial" required>
                                <span class="input-group-addon" @click.prevent="buscaAfiliado"><i class="fa fa-search"></i></span>
                            </div>
                        </div>                        
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Afiliado <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="asociacion_name" v-model="dataVenta.nombre_completo" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kardex <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm " name="ruc" v-model="dataVenta.kardex" maxlength="11" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nº Folio <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataVenta.folio" required>
                        </div>
                    </div><!-- /.form-group -->                                                           
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Costo Total <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataVenta.costo_total" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Tipo de Venta <span class="asterisk">*</span></label>
                        <div class="col-sm-8 pt-5">
                        <p class="mb-0">
                            Contado: <input type="radio" name="contado" id="contado" value="0" v-model="dataVenta.tipo_venta" required />
                            Credito: <input type="radio" name="credito" id="credito" value="1" v-model="dataVenta.tipo_venta" />
                        </p>
                        </div>
                    </div>                                            
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Num. Cuotas (Mensuales)<span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control input-sm" name="numero_cuotas" v-model="dataVenta.numero_cuotas" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Valor de Cuotas <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm" name="valor_cuotas" v-model="dataVenta.valor_cuotas" required>
                        </div>
                    </div><!-- /.form-group -->                    
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
        <!-- /. form de registro de pacientes -->
        </modal> 
       

    </div>   
</template>
<script>
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'

export default {
    name:'lotizaciones',
    mounted() {
        this.$store.dispatch('LOAD_LOTIZACIONES_LIST')
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
                label: 'Manzana',
                field: 'manzana',
                width:'20%',
                },
                {
                label: 'Lote',
                field: 'lote',
                filterable: true,
                width:'20%',                
                },
                {
                label: 'Estado',
                field: 'estado_lote',
                filterable: true,                
                width:'40%',                
                },
                {
                label: 'Acción',
                html: true    
                }                               
            ],
            dataLotizacion : {
                ubicacion_id:'',
                lote:'',
                estado_lote:'',
                user_id: 1
            }, 
            dataPreventa: {
                afiliado_id:'',
                numero_documento:'',
                importe:'',
                lotizacion_id:'',
                vendedor_id:'',
                user_id:''
            },
            dataVenta: {
                afiliado_id:'',
                kardex:'',
                folio:'',
                lotizacion_id:'',
                fecha_venta:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                costo_total:'',
                tipo_venta:'',
                numero_cuotas:'',
                valor_cuotas:'',
                estado_venta:'',
                observaciones:'',
                vendedor_id:'',
                user_id:'',
                estado_lote:''  // Tabla de lotizacion
            }, 
            dataPago: {
                venta_id:'',
                numero_cuota:'',
                fecha_programada:'',
                fecha_pago:'',
                numero_documento:'',
                importe:'',
                pagado_por:'',
                estado_pago:'',
                user_id:''
            },                
            errors:[]
        }
    },    
    computed: {
        ...mapGetters({ getlotizacion_ubicacion: 'getLotizacionUbicacionById'}),
        lotizacion_ubicacionByid: function(){
            //console.log("ubicacion:",this.getubicacion_asociacion(this.$route.params.asociacion))
            return this.getlotizacion_ubicacion(this.$route.params.ubicacion);
        }
    },
    components: {
      MaskedInput 
    },      
    methods: {
        processVenta: function(row){
            this.$modal.show('venta');
        }, 
        buscaAfiliado: function() {
            console.log("buscando .....")
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

    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 
</style>

