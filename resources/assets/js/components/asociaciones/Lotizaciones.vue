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
                                    <td>
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
        <modal name="venta" :width="'80%'" :height="'auto'" :scrollable="true" :clickToClose="false">
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
                        <masked-input v-model="dataAsociacion.fecha_inicio_labores" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>
                    </div>                   
                    <div class="form-group">
                        <label class="col-sm-4 control-label">DNI <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="asociacion_name" v-model="dataAsociacion.nombre" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Afiliado <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="asociacion_name" v-model="dataAsociacion.nombre" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Kardex <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm " name="ruc" v-model="dataAsociacion.ruc" maxlength="11" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nº Folio <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataAsociacion.nombre_comercial" required>
                        </div>
                    </div><!-- /.form-group -->                                                           
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Precio <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataAsociacion.nombre_comercial" required>
                        </div>
                    </div><!-- /.form-group -->                      
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Num. Cuotas <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataAsociacion.nombre_comercial" required>
                        </div>
                    </div><!-- /.form-group -->
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
//import MaskedInput from 'vue-masked-input'
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
                width:'25%',
                },
                {
                label: 'Lote',
                field: 'lote',
                filterable: true,
                width:'25%',                
                },
                {
                label: 'Estado',
                field: 'estado_lote',
                filterable: true,                
                width:'35%',                
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
}
</script>

