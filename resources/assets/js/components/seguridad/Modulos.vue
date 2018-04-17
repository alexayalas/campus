<template>
    <div class="col-md-12">
        <!-- START DEFAULT DATATABLE -->
        <div class="panel panel-default">
            <div class="panel-heading">                                
                <h3 class="panel-title">JR</h3>  
                <ul class="panel-controls">
                    <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Modulo</button></li>
                </ul>                                                        
            </div>
            <div class="panel-body">
                <vue-good-table
                title="Lista General de Modulos"
                :columns="columns"
                :rows="modulos"
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
                        <td>{{ props.row.costo_total }}</td>
                        <td>{{ props.row.acuenta }}</td>
                        <td>{{ props.row.costo_total - props.row.acuenta }}</td>
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
  
}
</script>

