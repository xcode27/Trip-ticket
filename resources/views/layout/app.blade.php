<!DOCTYPE html>
<html lang="{{config('app.locale')}}">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{config('app.name', 'TripTicket')}}</title>
    <link rel="shortcut icon" href="{{ asset('images/exxel_logo.jpg') }}">
    <link  href="{{asset("/dashboards/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet"><!-- Bootstrap core CSS-->
    <link href="{{asset("/dashboards/vendor/fontawesome-free/css/all.min.css")}}" rel="stylesheet" type="text/css">   <!-- Custom fonts for this template-->
    <link href="{{asset("/dashboards/vendor/datatables/dataTables.bootstrap4.css")}}" rel="stylesheet"> <!-- Page level plugin CSS-->
    <link href="{{asset("/dashboards/css/sb-admin.css")}}" rel="stylesheet"> <!-- Custom styles for this template-->
     <!-- Bootstrap core JavaScript-->
    <script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
    <script src="{{asset("/dashboards/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{asset("/dashboards/vendor/jquery-easing/jquery.easing.min.js")}}"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{asset("/dashboards/vendor/chart.js/Chart.min.js")}}"></script>
    <script src="{{asset("/dashboards/vendor/datatables/jquery.dataTables.js")}}"></script>
    <script src="{{asset("/dashboards/vendor/datatables/dataTables.bootstrap4.js")}}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{asset("/dashboards/js/sb-admin.min.js")}}"></script>
    <!-- Demo scripts for this page-->
    <style type="text/css">

      #page-top{
          width:100%;
          min-width:1000px;
          height:auto;
      } 

    </style>
    <script type="text/javascript">
      $(document).ready(function(){
        startTime();
      });

      function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      var mode = '';

      if(h > 12 ){
        h = h - 12;
        mode = 'PM';
      }else{
        h = h;
        mode = 'AM';
      }
      document.getElementById('systime').innerHTML =
      h + ":" + m + ":" + s + " "+mode;
      var t = setTimeout(startTime, 500);
    }
    
    function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }

  

      function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
              return false;
          }
          return true;
      }

         function logout(){

          var datas = {
             _token: '{{csrf_token()}}',id:{{ Session::get('user_id')}}
            }

          $.ajax({
            type: 'POST',
            dataType : 'json',
            data:datas,
            url: '{{URL::to('logout')}}',
        }).done(function( msg ) {
         
            var data = jQuery.parseJSON(JSON.stringify(msg));
            alert(data.msg);
            window.location.href='{{ action("PagesController@index") }}';
        }); 

      
      }
     
    </script>

  </head>

  <body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark navbar-fixed-top">
      <a class="navbar-brand mr-1" href="#"><img src="{{url('/images/deliverytime.png')}}" style="height: 35px;" alt="cod logo"></img></a>
      <a class="navbar-brand mr-1" href="#">Trip Ticketing System</a>
      <a class="navbar-brand mr-1" href="#" style="width:100%; text-align: right;"><i class="fas fa-fw fa-clock"></i>
            <span id="systime"></span> | <i class="fas fa-fw fa-calendar"></i>
            <span id="sysdate"><?php echo date("m-d-Y"); ?></span></a>
      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-12">
        
         <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw" style="width:350px; text-align: right;">&nbsp;<span id="user"><span>Current User&nbsp;:</span>
              @if(Session::has('user_id'))
                   {{ Session::get('Firstname')}}
                   @if(Session::get('usertype') == '0')
                        {{'/ Admin'}}
                    @else
                        {{'/ Guest'}}
                  @endif
              @endif</span>
            </i>
          </a>
        
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{ action("PagesController@home") }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Menus</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown" style="width: 280px;">
            <a class="dropdown-item" href="{{ action("PagesController@vehiclepass") }}">Vehicle Pass & Delivery Schedule</a>
            <a class="dropdown-item" href="{{ action("PagesController@tripList") }}">Trip List</a>
            <a class="dropdown-item" href="{{ action("PagesController@create_schedule") }}">Create Schedule for driver</a>
          </div>
        </li>
       
         <li class="nav-item dropdown ">
          <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <i class="fas fa-fw fa-cogs"></i>
            <span>Settings</span></a>
          </a>
          <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="#">Change login details</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-fw fa-arrow-left"></i>
            <span id="logout" onclick="logout();">Logout</span></a>
        </li>
      </ul>

      <div id="content-wrapper">
          <div class="container-fluid" style="height:400px; font-size: 14px;">
            <!-- Breadcrumbs-->

            @yield('content')

          </div>
        <!-- /.container-fluid -->
        <!-- Sticky Footer -->
       <!-- <footer class="sticky-footer" style="height:50px;">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Exxel Prime Trading</span>
            </div>
          </div>
        </footer>-->

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
  </body>

</html>

