<template>
    <div class="col-md-9">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">JR</h3>  
                <ul class="panel-controls">
                    <li><button type="button" class="btn btn-info" @click.prevent="$router.go(-1)"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Regresar</button></li>
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
                        <td>{{ props.row.estado_pago }}</td>                        
                        <td><button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button></td>
                    </template>                              
                </vue-good-table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->                       
        
    </div>
</template>
<script>
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
                    filterable: true,
                    width:'30%',
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
                    width:'25%',                
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
                pagos:[],                   
                errors:[]
            }
        },
        methods: {
            CargaPagos: function(){
                var url ="/api/pagos"
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
            onClickFn: function(row, index){
                console.log(row); //the object for the row that was clicked on
                console.log(index); // index of the row that was clicked on
                this.$router.push({ name: 'AfiPagos',  params: { afiliado: this.$route.params.afiliado ,venta : row.id } })
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

