<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Estructura de la Asociacion</h2>
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
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nueva Asociacion</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Estructura General de la Asociación"
                            :columns="columns"
                            :rows="ubicaciones"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.sector}}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.grupo }}</td>
                                    <td>{{ props.row.manzana }}</td>
                                    <td>{{ props.row.lotes_disponibles }}</td>
                                    <td>{{ props.row.lotes_prevendidos }}</td>
                                    <td>{{ props.row.lotes_vendidos }}</td>

                                    <td>
                                        <button @click.prevent="processDelete(props.row)"><i class="material-icons">mode_edit</i></button>
                                        <button @click.prevent="processDelete(props.row)"><i class="material-icons">location_on</i></button>
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
        <modal name="ubicacion" :width="'40%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Estructura de la Asociación</h3>
                <div class="pull-right close-form" @click="$modal.hide('ubicacion')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createUbicacion">
                <div class="form-body">
                <div class="col-md-11 pt-20">
                   
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Sector </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm " name="sector" v-model="dataUbicacion.sector" />
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Grupo </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm " name="grupo" v-model="dataUbicacion.grupo" />
                        </div>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Manzana <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control input-sm mayusculas" name="manzana" v-model="dataUbicacion.manzana" required>
                        </div>
                    </div><!-- /.form-group -->                                                           
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Cantidad de Lotes <span class="asterisk">*</span></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control input-sm" name="lotes" v-model="dataUbicacion.lotes" required>
                        </div>
                    </div><!-- /.form-group --> 
                                                                                                                                                                                                    
                </div>
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-20 mb-10 mt-20 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('ubicacion')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-success active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de pacientes -->
        </modal>        

    </div>
</template>