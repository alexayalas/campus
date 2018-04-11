<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Usuarios</h2>
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
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Lista General de Usuarios"
                            :columns="columns"
                            :rows="usuarios"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.name }}</td>
                                    <td class="enlace" @click.prevent="onClickFn(props.row,props.index)">{{ props.row.empleado.nombre_completo }}</td>
                                    <td>
                                        <select class="input-sm" v-model="props.row.empleado.perfil_id" @change="updateAtributos(props.row.empleado.id,props.row.empleado.perfil_id,null)">
                                            <option v-for="perfil in perfiles" :value="perfil.id" :key="perfil.id">
                                                {{ perfil.nombre }}
                                            </option>
                                        </select>                                    
                                    </td>
                                    <td>
                                        <toggle-button :value="props.row.acceso" :color="{checked: '#337ab7', unchecked: '#FF0000'}" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" @change="updateAtributos(props.row.empleado.id,null,props.row.acceso)"/>                            
                                    </td>
                                    <td><button @click.prevent="processDelete(props.row)"><i class="material-icons">delete_forever</i></button></td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->
                </div>
            </div>                                            
        </div>            

    </div>  
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'usuarios',
    data() {
        return {
            dataAtributos: {
                perfil_id:null,
                habilitado:null
            },

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',

            columns: [
                {
                label: 'Usuario',
                field: 'name',
                filterable: true,
                width:'15%',
                },
                {
                label: 'Empleado',
                field: 'empleado',
                filterable: true,
                width:'30%',                
                },
                {
                label: 'Perfil',
                field: 'perfil',
                width:'30%',                
                },
                {
                label: 'Habilitado',
                field: 'habilitado',
                width:'10%',                
                },                
                {
                label: 'Acción',
                html: true    
                }                               
            ],            
            errors:[]                  
        }
    },
    created(){
      this.$store.dispatch('LOAD_PERFILES_LIST')
      this.$store.dispatch('LOAD_USUARIOS_LIST')  
    },
    computed: {
        ...mapState([ 'usuarios','perfiles']),
    },  
    methods: {
      updateAtributos: function(id,perf,acce){
        this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Actualizar este atributo ?</strong></span>", {
            html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
            loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
            reverse: false, // switch the button positions (left to right, and vise versa)
            okText: 'Aceptar',
            cancelText: 'Cancelar',
            animation: 'fade', // Available: "zoom", "bounce", "fade"
            type: 'basic',
          })
        	.then((dialog) => {
            var url = '/api/empleados/updateattribute/'+id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            if(perf != null){
              this.dataAtributos.perfil_id = perf
              this.dataAtributos.habilitado = null
            }
            if(acce != null){
              if(acce == true){
                this.dataAtributos.habilitado = 0
              }else{
                this.dataAtributos.habilitado = 1
              }
              this.dataAtributos.perfil_id = null
            }            
            axios.put(url, this.dataAtributos).then(response => {
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
              toastr.success('se actualizaron los datos correctamente');
              dialog.close();
              this.$store.dispatch('LOAD_USUARIOS_LIST')               
            }).catch(error => {
              this.errors = error.response.data.status;
              toastr.error("Hubo un error en el proceso: "+this.errors);
              console.log(error.response.status);
              dialog.close();
            });
        	})
          .catch(() => {
              this.$store.dispatch('LOAD_USUARIOS_LIST')             
              console.log('Delete aborted');
          });
      }, 
      processDelete(id){
        this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este usuario ?</strong></span>", {
            html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
            loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
            reverse: false, // switch the button positions (left to right, and vise versa)
            okText: 'Aceptar',
            cancelText: 'Cancelar',
            animation: 'fade', // Available: "zoom", "bounce", "fade"
            type: 'basic',
          })
        	.then((dialog) => {
            var url = '/api/users/' + id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            axios.delete(url).then(response=> {
              this.$store.dispatch('LOAD_USERS_LIST') 
              toastr.success('Usuario Eliminado correctamente');
              dialog.close();
            });
        	})
          .catch(() => {
              console.log('Delete aborted');
          });
      },                         
    }           

  
}
</script>
<style scoped>

</style>



