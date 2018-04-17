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
                        <td><button @click.prevent="processDelete(props.row)"><i class="material-icons md-18">delete_forever</i></button></td>
                    </template>                              
                </vue-good-table>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->                       
        
    </div>      
</template>
<script>
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
            errors:[]
        }
    },
    computed: {
        ...mapState(['preventas']),
    },     
    methods: {
        onClickFn: function(row, index){
            console.log(row)
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



