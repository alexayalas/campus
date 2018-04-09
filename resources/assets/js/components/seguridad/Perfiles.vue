<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Perfiles</h2>
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
                                <li><button type="button" class="btn btn-info" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nuevo Perfil</button></li>
                            </ul>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Perfiles"
                            :columns="columns"
                            :rows="perfiles"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="loadPerfil(props.row)">{{ props.row.nombre }}</td>
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
        <modal name="CreatePerfil" :width="'40%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Perfil</h3>
                <div class="pull-right close-form" @click="$modal.hide('CreatePerfil')"><i class="glyphicon glyphicon-remove"></i></div>                
            </div>
            <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="createPerfil">
                <div class="form-body">
                    <div class="col-md-9 pt-20">                  
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm mayusculas" name="nombre" v-model="dataPerfil.nombre" required>
                            </div>
                        </div><!-- /.form-group -->                                                                                                                                                                                                             
                    </div>                  
                </div><!-- /.form-body -->
                <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                    <div class="pull-right pr-10">
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('CreatePerfil')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de vendedores -->
        </modal>
        <!-- modal de configuracion perfiles-->
        <modal name="perfiles" :width="'80%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de Perfiles -->
            <div class="row">
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Configuración de Perfil {{ nombre }}</h3>
                    <div class="pull-right close-form" @click="$modal.hide('perfiles')"><i class="fa fa-close"></i></div>                
                </div>
                <div>
                    <div class="form-body">
                        <div class="container">
                            <div class="row col-md-11 ml-10 mr-10" style="display: flex; flex-wrap: wrap;">
                                <div class="col-md-6 pl-20 pr-20 pb-10 pt-10" v-for="modulo in modulos" :key="modulo.id" style="display: flex;flex-direction: column;">
                                    <div class="table table-responsive table-bordered mb-10" style="width: 100%">
                                        <table class="table">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">   
                                                        <div class="ckbox ckbox-default rounded">
                                                            <label :for="modulo.idmenu" class="label-cbx">
                                                                <input :id="modulo.idmenu" :value="modulo.idmenu" v-model="dataPerfil.checkedPerfil" type="checkbox" class="invisible" @change="updateChildren($event,modulo)">
                                                                <div class="checkbox mt-0 mb-0">
                                                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                                    <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                                    <polyline points="4 11 8 15 16 6"></polyline>
                                                                </svg>
                                                                </div>
                                                            </label>                                                          
                                                        </div>                                                         
                                                    </th>
                                                    <th><strong>{{modulo.nombre}}</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="opcion in modulo.options" :key="opcion.options.options.id">
                                                    <td class="text-center">                                                    
                                                        <div class="ckbox ckbox-default rounded">
                                                            <label :for="opcion.options.options.id" class="label-cbx">
                                                                <input :id="opcion.options.options.id" :value="opcion.options.options.id" v-model="dataPerfil.checkedPerfil" type="checkbox" class="invisible" @change="updateParent($event,opcion,modulo)">
                                                                <div class="checkbox mt-0 mb-0">
                                                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                                    <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                                    <polyline points="4 11 8 15 16 6"></polyline>
                                                                </svg>
                                                                </div>
                                                                
                                                            </label>      
                                                        </div>                                                        
                                                    </td>
                                                    <td>{{opcion.nombre}}</td> 
                                                </tr> 
                                            </tbody>
                                        </table>
                                    </div><!-- /.table-responsive --> 
                                </div>
                            </div>
                        </div>
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('perfiles')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="button" class="btn btn-primary active" @click="updatePerfil"><i class="fa fa-cloud-upload"></i> Grabar</button>
                        </div>
                    </div><!-- /.form-footer -->                
                </div>
            </div>
            <!-- /. form de Perfiles -->
        </modal>
        <!-- /. modal -->                

    </div>  
</template>
<script>
import  {_} from 'vue-underscore'
import { mapState , mapGetters } from 'vuex'

export default {
    name:'perfiles',
    data() {
        return {

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Nombre del Perfil',
                field: 'nombre',
                filterable: true,
                width:'70%',
                },
                {
                label: 'Acción',
                html: true    
                }                               
            ],

            dataNuevoPerfil: {
                nombre: ''
            },
            nombre: '',
            dataPerfil : {
                idPerfil : '',
                checkedPerfil :[]
            }            
        }
    },
    created() {
        this.$store.dispatch('LOAD_MODULOS_LIST')
        this.$store.dispatch('LOAD_PERFILES_LIST')
    },    
    computed : {
        ...mapState(['modulos','perfiles']),
        ...mapGetters(['getPerfilById']),
        perfilByid: function(){
            return this.getPerfilById(this.dataPerfil.idPerfil);
        },                          
    },  
    methods : {
      loadForm(){
        this.dataNuevoPerfil = {
          nombre: ''
        }
        this.$modal.show('CreatePerfil')
      },
      loadPerfil(value) {
        this.dataPerfil = {
          idPerfil : value.id,
          checkedPerfil :[]
        }    
        this.cargaPerfiles()            
        this.nombre = value.nombre   
        this.$modal.show('perfiles')
      },
      cargaPerfiles(){
        console.log("perfiles cargando..",this.perfilByid)
        var list=[];
        this.perfilByid.modulos.map(function(value, key) {
            if(value.pivot.state === 1){
              list.push(value.pivot.modulo_id)
            }
        })    
        this.dataPerfil.checkedPerfil = list     
      },
      createPerfil(){
        var url = '/api/perfiles'
        toastr.options.closeButton = true
        toastr.options.progressBar = true

        axios.post(url, this.dataNuevoPerfil).then(response => {
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
          this.errors = [];         
          this.$store.dispatch('LOAD_PERFILES_LIST')          
          this.$modal.hide('CreatePerfil');          
          toastr.success('se creo el perfil con exito');
        }).catch(error => {           
          this.errors = error.response.data.status;
          toastr.error("Hubo un error en el proceso: "+this.errors);
          console.log(error.response.status);
        });
        //this.isSubmitted = true
      },      
      updatePerfil: function(){
        var url = '/api/perfiles/'+this.dataPerfil.idPerfil;
        toastr.options.closeButton = true;
        toastr.options.progressBar = true;
        axios.put(url, this.dataPerfil).then(response => {
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
          this.errors = [];
          this.$store.dispatch('LOAD_PERFILES_LIST')          
          this.$modal.hide('perfiles');          
          toastr.success('se actualizo los modulos del perfil con exito');
        }).catch(error => {
          this.errors = error.response.data.status;
          toastr.error("Hubo un error en el proceso: "+this.errors);
          console.log(error.response.status);
        });
      },
      updateChildren: function(e,valor){
        var list=[]
        valor.options.map(function(value, key) {
          list.push(value.options.options.id)
        })    
        if(e.target.checked){     // seleccionamos todos
          this.dataPerfil.checkedPerfil = _.union(this.dataPerfil.checkedPerfil,list)
        }else{        // deseleccionamos todos
          this.dataPerfil.checkedPerfil = _.difference(this.dataPerfil.checkedPerfil,list)
        }
      } ,
      updateParent: function(e,valor,mod){
        var list=[]
        var search = false
        mod.options.map(function(value, key) {
          list.push(value.options.options.id)
        })      
        if(e.target.checked){
          if(_.indexOf(this.dataPerfil.checkedPerfil,valor.options.idmenu)  == -1){
            this.dataPerfil.checkedPerfil.push(valor.options.idmenu)
          }
        }
        else{
          var self = this
          _.map(list, function(value) {
            if(_.indexOf(self.dataPerfil.checkedPerfil,value)  > -1){
              search = true
            }
          }); 
          if(!search){
            var i = _.indexOf(self.dataPerfil.checkedPerfil,valor.idmenu)
            self.dataPerfil.checkedPerfil.splice(i,1)
          }
        }

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

    /*-- Estilos del input check ---*/
    .label-cbx {
        user-select: none;
        cursor: pointer;
        margin-bottom: 0;
    }
    .label-cbx input:checked + .checkbox {
        border-color: #20C2E0;
    }
    .label-cbx input:checked + .checkbox svg path {
        fill: #20C2E0;
    }
    .label-cbx input:checked + .checkbox svg polyline {
        stroke-dashoffset: 0;
    }
    .label-cbx:hover .checkbox svg path {
        stroke-dashoffset: 0;
    }
    .label-cbx .checkbox {
        position: relative;
        top: 2px;
        float: left;
        margin-right: 8px;
        width: 20px;
        height: 20px;
        border: 2px solid #C8CCD4;
        border-radius: 3px;
    }
    .label-cbx .checkbox svg {
        position: absolute;
        top: -2px;
        left: -2px;
    }
    .label-cbx .checkbox svg path {
        fill: none;
        stroke: #20C2E0;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 71px;
        stroke-dashoffset: 71px;
        transition: all 0.6s ease;
    }
    .label-cbx .checkbox svg polyline {
        fill: none;
        stroke: #FFF;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 18px;
        stroke-dashoffset: 18px;
        transition: all 0.3s ease;
    }
    .label-cbx > span {
        pointer-events: none;
        vertical-align: middle;
    }

    .cntr {
        position: absolute;
        top: 45%;
        left: 0;
        width: 100%;
        text-align: center;
    }

    .invisible {
        position: absolute;
        z-index: -1;
        width: 0;
        height: 0;
        opacity: 0;
    }

</style>


