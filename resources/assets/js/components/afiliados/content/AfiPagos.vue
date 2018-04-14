<template>
    <div class="col-md-9">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <span class="panel-title">
                    <button type="button" class="btn btn-danger" @click.prevent="$router.go(-1)"><i class="material-icons bootstro-prev-btn mr-5">arrow_back</i> Regresar</button>
                </span>
                <ul class="panel-controls">
                    <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">monetization_on</i> Nuevo Pago</button></li>
                </ul>                                                        
            </div>
            <div class="panel-body">
                <vue-good-table
                title="Cronograma de Pagos"
                :columns="columns"
                :rows="pagos"
                :paginate="true"
                :lineNumbers="true"
                :rowsPerPageText="textpage"
                :nextText="textnext"
                :prevText="textprev"
                :ofText="textof"
                styleClass="table condensed table-bordered table-striped">
                    <template slot="table-row" slot-scope="props">
                        <td>{{ props.row.numero_cuota }}</td>
                        <td>{{ props.row.fecha_programada | reversefecha}}</td>
                        <td>{{ props.row.fecha_pago | reversefecha }}</td>
                        <td>{{ props.row.numero_documento }}</td>
                        <td>{{ props.row.importe }}</td>
                        <td>{{ props.row.pagado_por }}</td>
                        <td>{{ props.row.estado_pago_letras }}</td>                        
                        <td><button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button></td>
                    </template>                              
                </vue-good-table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->  
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="pago" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de pagos -->
            <div class="row">
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Pago de Cuota</h3>
                    <div class="pull-right close-form" @click="$modal.hide('pago')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createPago">
                    <div class="form-body">
                        <div class="col-md-11 pt-20">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Fecha </label>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                <masked-input v-model="dataPago.fecha_pago" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                                </div>
                            </div>                   
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Numero Documento <span class="asterisk">*</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control input-sm mayusculas" name="numero_documento" v-model="dataPago.numero_documento" required>
                                </div>
                                <label class="col-sm-2 control-label">Importe <span class="asterisk">*</span></label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control input-sm" name="importe" v-model="dataPago.importe" required>
                                </div>                        
                            </div><!-- /.form-group -->                                                       
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pagado por <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="pagado_por" v-model="dataPago.pagado_por"/>
                                </div>                        
                            </div><!-- /.form-group -->                                           
                                                                                                                                                                                        
                        </div>
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mb-10 mt-20 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('pago')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de pagos -->
        </modal>                              
        
    </div>
</template>
<script>
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
    export default {
        name:'afipagos',
        mounted() {
            this.CargaPagos()
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
                    label: 'Num.Cuota',
                    field: 'numero_cuota',
                    width:'15%',
                    },
                    {
                    label: 'Fec.Programada',
                    field: 'fecha_programada',
                    type: 'date',
                    inputFormat : 'YYYY-MM-DD',
                    outputFormat: 'DD/MM/YYYY',
                    width:'15%',                
                    },
                    {
                    label: 'Fec.Pago',
                    field: 'fecha_pago',
                    type: 'date',
                    inputFormat : 'YYYY-MM-DD',
                    outputFormat: 'DD/MM/YYYY',                    
                    width:'15%',                
                    },
                    {
                    label: 'Num.Documento',
                    field: 'numero_documento',
                    width:'15%',                
                    },
                    {
                    label: 'Importe',
                    field: 'importe',
                    width:'15%',                
                    },
                    {
                    label: 'Pagado por',
                    field: 'pagado_por',
                    width:'15%',                
                    }, 
                    {
                    label: 'Estado',
                    field: 'estado_pago',
                    width:'15%',                
                    },                                                            
                    {
                    label: 'Acción',
                    html: true  ,
                    width:'15%',  
                    }                               
                ],  
                dataPago:{
                    importe:'',
                    pagado_por:'',
                    fecha_pago:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                    venta_id:'',
                    user_id: ''

                },
                pagos:[],                   
                errors:[]
            }
        },
        components: {
            MaskedInput         
        },
        computed: {
            ...mapState(['user_system']),
        },                 
        methods: {
            LoadForm: function(){
                this.dataPago = {
                    importe:'',
                    pagado_por:'',
                    fecha_pago:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                    venta_id:'',
                    user_id:this.user_system.user.id
                }
                //this.CargaPagos()       
                this.$modal.show('pago')                
            },
            CargaPagos: function(){
                var url ="/api/pagosventa"
                axios.get(url,{
                params:{
                    venta_id: this.$route.params.venta
                }
                }).then(response => {

                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }
                    return;
                }
                if(response.data.length >0 ){
                    this.pagos = response.data
                }

                }).catch(error => {
                console.log("error en el componente: ",error.response);
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                });
            },
/*             onClickFn: function(row, index){
                console.log(row); //the object for the row that was clicked on
                console.log(index); // index of the row that was clicked on
                this.$router.push({ name: 'AfiPagos',  params: { afiliado: this.$route.params.afiliado ,venta : row.id } })
            }, */
            createPago: function(){
                var url = '/api/pagos/'+ this.$route.params.venta;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;

                this.dataPago.venta_id = this.$route.params.venta

                axios.put(url, this.dataPago).then(response => {
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
                this.CargaPagos()
                //this.getAfiliado(this.pagination.current_page,this.patientSearch);          
                this.errors = [];
                this.$modal.hide('pago');
                toastr.success('Nuevo Pago creado con exito');
                }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                console.log(error.response.status);
                });

            }             
        },
        filters:{
            reversefecha: function(value){
                if(!value) return ''
                value = value.toString()
                return value.split('-').reverse().join('-')
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


