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
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                            </ul>                                
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Demo Table"
                            :columns="columns"
                            :rows="rows"
                            :paginate="true"
                            :lineNumbers="true"/>
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
    data() {
        return {
            columns: [
                {
                label: 'Name',
                field: 'name',
                filterable: true,
                },
                {
                label: 'Age',
                field: 'age',
                type: 'number',
                html: false,
                filterable: true,
                },
                {
                label: 'Created On',
                field: 'createdAt',
                type: 'date',
                inputFormat: 'YYYYMMDD',
                outputFormat: 'MMM Do YY',
                },
                {
                label: 'Percent',
                field: 'score',
                type: 'percentage',
                html: false,
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
                {id:20, name:"Dan mr",age:40,createdAt: '2011-10-31',score: 0.03343},
            ],
        }
    }
  
}
</script>

