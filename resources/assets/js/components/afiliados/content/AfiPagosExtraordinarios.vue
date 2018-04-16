<template>
    <div class="col-md-9">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">JR</h3>  
                <ul class="panel-controls">
                    <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">monetization_on</i> Nuevo Pago</button></li>
                </ul>                                                        
            </div>
            <div class="panel-body">
                <vue-good-table
                title="Lista de Pagos Extraordinarios"
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
                        <td>{{ props.row.tipopagoextraordinario.nombre }}</td>
                        <td>{{ props.row.fecha_pago | reversefecha}}</td>
                        <td>{{ props.row.importe }}</td>
                        <td><button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button></td>
                    </template>                              
                </vue-good-table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->  
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="pago_extraordinario" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de pagos -->
            <div class="row">
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Pago Extraordinario</h3>
                    <div class="pull-right close-form" @click="$modal.hide('pago_extraordinario')"><i class="glyphicon glyphicon-remove"></i></div>                
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
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Tipo de Pago </label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                <basic-select :options="tipo_pagosextraordinarios"
                                    :selected-option="item_pag"
                                    placeholder="seleccione una opción"
                                    @select="onSelectPag">
                                </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_pag.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_pag.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetPag"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>                                               
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Importe <span class="asterisk">*</span></label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control input-sm" name="importe" v-model="dataPago.importe" required>
                                </div>                        
                            </div><!-- /.form-group -->                                                       
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Observaciones </label>
                                <div class="col-sm-8">
                                    <textarea name="descripcion" rows="4" cols="60" v-model="dataPago.observaciones" class="mayusculas"></textarea>
                                </div>
                            </div><!-- /.form-group -->                                        
                                                                                                                                                                                        
                        </div>
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mb-10 mt-20 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('pago_extraordinario')"><i class="fa fa-reply-all"></i> Cancelar</button>
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
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'afipagosextraordinarios',
    mounted() {
        this.$store.dispatch('LOAD_TIPOS_PAGOSEXTRAORDINARIOS_LIST')
        this.CargaPagos();
    },    
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem

            item_pag: { value: '', text: ''},  

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Tipo Pago',
                field: 'tipo_pagoextraordinario',
                width:'50%',
                },
                {
                label: 'Fecha Pago',
                field: 'fecha_pago',
                type: 'date',
                inputFormat : 'YYYY-MM-DD',
                outputFormat: 'DD/MM/YYYY',
                width:'20%',                
                },
                {
                label: 'Importe',
                field: 'importe',
                width:'15%',                
                },                                                           
                {
                label: 'Acción',
                html: true  ,
                width:'15%',  
                }                               
            ],  
            dataPago:{
                afiliado_id:'',
                tipopagoextraordinario_id:'',
                importe:'',
                fecha_pago:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                observaciones:'',
                user_id: ''

            }, 
            pagos:'',                 
            errors:[]

        }
    },
    components: {
      MaskedInput ,
      BasicSelect
    },    
    computed: {
        ...mapState(['tipo_pagosextraordinarios','user_system'])
    }, 
    methods: {
        LoadForm: function(){
            this.item_pag = {}
            this.dataPago = {
                afiliado_id:'',
                tipopagoextraordinario_id:'',
                importe:'',
                fecha_pago:("0" + (new Date().getDate())).slice(-2) + "/" + ("0" + (parseInt(new Date().getMonth()) + 1)).slice(-2) + "/" + new Date().getFullYear() ,
                observaciones:'',
                user_id: this.user_system.user.id
            }
            //this.CargaPagos()       
            this.$modal.show('pago_extraordinario')                
        },
        CargaPagos: function(){
            var url ="/api/pagos-extraordinarios-afiliado"
            axios.get(url,{
            params:{
                afiliado_id: this.$route.params.afiliado
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
            var url = '/api/pagos-extraordinarios'
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;

            this.dataPago.afiliado_id = this.$route.params.afiliado

            axios.post(url, this.dataPago).then(response => {
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
            this.$modal.hide('pago_extraordinario');
            toastr.success('Nuevo Pago creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });

        },

        onSelectPag (item_pag ) {
            this.item_pag = item_pag
            this.dataPago.tipopagoextraordinario_id = item_pag.value
        },
        resetPag () {
            this.item_pag = {}
            this.dataPago.tipopagoextraordinario_id = ''   
        },                     
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

    .mayusculas{
        text-transform:uppercase;
    }  

    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 

</style>


