<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Terrain Admin</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
        <!-- END META SECTION -->
       
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="{{ asset('css/theme-default.css') }}"/>
        <!-- EOF CSS INCLUDE -->   
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" >        
        <!-- Custom App Vue Style incluye bootstrap y toastr -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" >                                          
    </head>
    <body>

        <div id="app">
        
            <router-view></router-view>

        </div>

        <!-- START PRELOADS -->
        <audio id="audio-alert" src="{{ asset('audio/alert.mp3') }}" preload="auto"></audio>
        <audio id="audio-fail" src="{{ asset('audio/fail.mp3') }}" preload="auto"></audio>
        <!-- END PRELOADS -->                  
        
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/jquery/jquery-ui.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap.min.js') }}"></script>        
        <!-- END PLUGINS -->

        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src="{{ asset('js/plugins/icheck/icheck.min.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/scrolltotop/scrolltopcontrol.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script> 
        
<!--         <script type="text/javascript" src="{{ asset('js/plugins/morris/raphael-min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/morris/morris.min.js') }}"></script>   -->     
        <script type="text/javascript" src="{{ asset('js/plugins/rickshaw/d3.v3.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/rickshaw/rickshaw.min.js') }}"></script>
        <script type='text/javascript' src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script type='text/javascript' src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>                
        <script type='text/javascript' src="{{ asset('js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>                
        <script type="text/javascript" src="{{ asset('js/plugins/owl/owl.carousel.min.js') }}"></script>                 
        
        <script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
        <!-- END THIS PAGE PLUGINS-->        

        <!-- START TEMPLATE -->
        <!--<script type="text/javascript" src="{{ asset('js/settings.js') }}"></script>-->
        
        <script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>        
        <script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>
        
<!--         <script type="text/javascript" src="{{ asset('js/demo_dashboard.js') }}"></script> -->
        <!-- toastr -->
        <script src="{{ asset('js/plugins/toastr/toastr.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
    </body>
</html>






