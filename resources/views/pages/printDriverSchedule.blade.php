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
    <style type="text/css">
    	tr.noBorder td {
		  border: 0;
		}
    </style>
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
   
  </head>

 <body id="tripsched">
	 <div id="content" style="font-size: 10px;">
		<table>
			<th>DELIVERY ON <?php echo date("F j, Y, D"); ?></th>
			<th>DRIVERS SIGN</th>
			<th>HELPER SIGN</th>
		</table>	
	</div>
 </body>
</html>






