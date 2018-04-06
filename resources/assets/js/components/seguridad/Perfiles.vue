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
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.nombre }}</td>
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
        <modal name="perfil" :width="'40%'" :height="'auto'" :scrollable="true" :clickToClose="false">
        <!-- form de registro de afiliados -->
        <div class="row">
            <div class="row title-form">
                <h3 class="pull-left h3-title">Registro de Perfil</h3>
                <div class="pull-right close-form" @click="$modal.hide('perfil')"><i class="glyphicon glyphicon-remove"></i></div>                
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
                        <button type="button" class="btn btn-danger active" @click="$modal.hide('perfil')"><i class="fa fa-reply-all"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                    </div>
                </div><!-- /.form-footer -->
            </form>
        </div>
        <!-- /. form de registro de vendedores -->
        </modal>        

    </div>  
</template>
<script>
import  {_} from 'vue-underscore'
import { mapState , mapGetters } from 'vuex'

export default {
    name:'perfiles',
    data() {
        return {
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

