<template>
    <div class="col-md-9">
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
                title="Precompras Efectuadas"
                :columns="columns"
                :rows="precompras"
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
                        <td>{{ props.row.importe }}</td>
                        <td>{{ props.row.vendedor.nombre_completo }}</td>
                        <td><button @click.prevent="processDelete(props.row)"><i class="material-icons md-18">delete_forever</i></button></td>
                    </template>                              
                </vue-good-table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->                       
        
    </div>    
</template>
<script>
    export default {
        name:'afiprecompras',
        mounted() {
            this.CargaPrecompras()
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
                    width:'25%',
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
                    width:'10%',                
                    },
                    {
                    label: 'Importe',
                    field: 'importe',
                    width:'10%',                
                    },
                    {
                    label: 'Vendedor',
                    field: 'vendedor',
                    width:'25%',                
                    },                                       
                    {
                    label: 'Acción',
                    html: true  ,
                    width:'15%',  
                    }                               
                ],  
                precompras:[],                   
                errors:[]
            }
        },
        methods: {
            CargaPrecompras: function(){
                var url ="/api/precompras"
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
                    this.precompras = response.data
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

    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }     
</style>




