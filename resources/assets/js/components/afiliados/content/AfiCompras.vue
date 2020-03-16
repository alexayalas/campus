<template>
    <div class="col-md-9">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">JR</h3>  
                <!--<ul class="panel-controls">
                    <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Afiliado</button></li>
                </ul>-->                                                        
            </div>
            <div class="panel-body">
                <vue-good-table
                title="Compras Efectuadas"
                :columns="columns"
                :rows="compras"
                :paginate="true"
                :lineNumbers="true"
                :rowsPerPageText="textpage"
                :nextText="textnext"
                :prevText="textprev"
                :ofText="textof"
                styleClass="table condensed table-bordered table-striped">
                    <template slot="table-row" slot-scope="props">
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.lotizacion.ubicacion.asociacion.nombre }}</td>
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.lotizacion.ubicacion.sector}} {{ props.row.lotizacion.ubicacion.grupo}} {{ props.row.lotizacion.ubicacion.manzana}}</td>
                        <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.lotizacion.lote }}</td>
                        <td>{{ props.row.costo_total }}</td>
                        <td>{{ props.row.acuenta }}</td>
                        <td>{{ props.row.costo_total - props.row.acuenta }}</td>
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
        name:'aficompras',
        mounted() {
            this.CargaCompras()
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
                    width:'30%',
                    },
                    {
                    label: 'Ubicacion',
                    field: 'ubicacion',
                    filterable: true,
                    width:'15',                
                    },
                    {
                    label: 'Lote',
                    field: 'lote',
                    width:'25%',                
                    },
                    {
                    label: 'Precio',
                    field: 'precio',
                    width:'15%',                
                    },
                    {
                    label: 'A Cuenta',
                    field: 'acuenta',
                    width:'15%',                
                    },
                    {
                    label: 'Saldo',
                    field: 'saldo',
                    width:'15%',                
                    },                                        
                    {
                    label: 'Acción',
                    html: true  ,
                    width:'15%',  
                    }                               
                ],  
                compras:[],                   
                errors:[]
            }
        },
        methods: {
            CargaCompras: function(){
                var url ="/api/compras"
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
                    this.compras = response.data
                }

                }).catch(error => {
                console.log("error en el componente: ",error.response);
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                });
            },
            onClickFn: function(row, index){
                this.$router.push({ name: 'AfiPagos',  params: { afiliado: this.$route.params.afiliado ,venta : row.id } })
            }              
        },
       
    }
</script>
<style scoped>
    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 
</style>


