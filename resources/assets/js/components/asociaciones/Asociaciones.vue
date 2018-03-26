<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Asociaciones</h2>
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
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Afiliado</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Asociaciones"
                            :columns="columns"
                            :rows="asociaciones"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.nombre}}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.ruc }}</td>
                                    <td>{{ props.row.nombre_comercial }}</td>
                                    <td>{{ props.row.fecha_inicio_labores }}</td>
                                    <td><button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button></td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->


                </div>
            </div>                                
            
        </div>        
        <!-- PAGE CONTENT WRAPPER -->  
        <modal name="asociacion" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Asociaciones</h3>
                <div class="pull-right close-form" @click="$modal.hide('asociacion')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createAfiliado">
                <div class="form-body">
                <div class="col-md-12 pt-20">
                   
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombres <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="asociacion_name" v-model="dataAsociacion.nombre" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">RUC <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm " name="ruc" v-model="dataAsociacion.ruc" maxlength="11" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required>
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre Comercial <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="nombre_comercial" v-model="dataAsociacion.nombre_comercial" required>
                        </div>
                    </div><!-- /.form-group -->                                                           
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-4">Fec.Inicio Labores </label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                        <masked-input v-model="dataAsociacion.fecha_inicio_labores" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                        </div>
                    </div>
                                                                                                                                                                                  
                </div>
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('asociacion')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de pacientes -->
        </modal>        

    </div>
</template>
<script>
export default {
    name:'asociaciones',
    mounted() {
        this.$store.dispatch('LOAD_ASOCIACIONES_LIST')
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
                label: 'Nombre',
                field: 'nombre',
                filterable: true,
                width:'10%',
                },
                {
                label: 'RUC',
                field: 'ruc',
                filterable: true,
                width:'30%',                
                },
                {
                label: 'Nombre Comercial',
                field: 'nombre_comercial',
                width:'10%',                
                },
                {
                label: 'fecha inicio',
                field: 'fecha_inicio_labores',
                type: 'date',
                inputFormat : 'YYYY-MM-DD',
                outputFormat: 'DD/MM/YYYY',
                width:'15%',                
                },
                {
                label: 'Acción',
                html: true    
                }                               
            ],
            dataAsociacion : {
                nombre:'',
                ruc:'',
                nombre_completo:'',
                user_id: 1,
                fecha_inicio_labores: '',
                descripcion:''
            },                      
            errors:[]
        }
    },
}
</script>
