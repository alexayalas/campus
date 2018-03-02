<template>
    <div>
        <!-- PAGE TITLE -->
        <div class="page-title">  
            <i class="material-icons md-36 bootstro-prev-btn">people</i>                  
            <h2 class="mb-0 mt-5 ml-10">Lista de Afiliados</h2>
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
                            title="Lista General de Afiliados"
                            :columns="columns"
                            :rows="rows"
                            :paginate="true"
                            :lineNumbers="true"
                            :onClick="onClickFn"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped"/>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->


                </div>
            </div>                                
            
        </div>
        <!-- PAGE CONTENT WRAPPER -->  

    </div>
</template>
<script>
export default {
    name: 'afiliados',
    mounted() {
        this.$store.dispatch('LOAD_AFILIADOS_LIST').then(() => {
            //this.pagination = this.patients_paginate
            //this.show = false
        })  
    },
    data() {
        return {
            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Credencial',
                field: 'credencial',
                filterable: true,
                width:'10%',
                },
                {
                label: 'Afiliado',
                field: 'nombre_completo',
                filterable: true,
                width:'30%',                
                },
                {
                label: 'DNI',
                field: 'dni',
                width:'10%',                
                },
                {
                label: 'Telefono',
                field: 'telefono',
                width:'10%',                
                },
                {
                label: 'Celular',
                field: 'celular',
                width:'10%',                
                }, 
                {
                label: 'Email',
                field: 'email',
                width:'30%',                
                },                               
            ],
            rows: [
                {id:1, name:"John",age:20,createdAt: '201-10-31:9:35 am',score: 0.03343},
                {id:2, name:"Jane",age:24,createdAt: '2011-10-31',score: 0.03343},
                {id:3, name:"Susan",age:16,createdAt: '2011-10-30',score: 0.03343},
                {id:4, name:"Chris",age:55,createdAt: '2011-10-11',score: 0.03343},
                {id:5, name:"Dan",age:40,createdAt: '2011-10-21',score: 0.03343},
                {id:6, name:"John",age:20,createdAt: '2011-10-31',score: 0.03343},
                {id:7, name:"Jane",age:24,createdAt: '20111031'},
                {id:8, name:"Susan",age:16,createdAt: '2013-10-31',score: 0.03343},
                {id:9, name:"Chris",age:55,createdAt: '2012-10-31',score: 0.03343},
                {id:10, name:"Dan",age:40,createdAt: '2011-10-31',score: 0.03343},
                {id:11, name:"John",age:20,createdAt: '2011-10-31',score: 0.03343},
                {id:12, name:"Jane",age:24,createdAt: '2011-07-31',score: 0.03343},
                {id:13, name:"Susan",age:16,createdAt: '2017-02-28',score: 0.03343},
                {id:14, name:"Chris",age:55,createdAt: '',score: 0.03343},
                {id:15, name:"Dan",age:40,createdAt: '2011-10-31',score: 0.03343},
                {id:19, name:"Chris",age:55,createdAt: '2011-10-31',score: 0.03343},
                {id:20, name:"Dan mr.bot",age:40,createdAt: '2011-10-31',score: 0.03343},
            ],
           
        }
    },
    methods: {
            onClickFn: function(row, index){
                console.log(row); //the object for the row that was clicked on
                console.log(index); // index of the row that was clicked on
            }, 
    }
  
}
</script>

