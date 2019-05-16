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
		
			<table  style="width: 100%; font-color:red;">
				<tr>
					<td style="width: 100px; color:red;">SERIES # -
						@php
							$holder = '';
						@endphp

						@foreach($details as $detail)
						  	@if($holder != $detail->form_series_no)
						  		@php $holder = $detail->form_series_no @endphp
						  		{{ $holder }}
						  	@endif
						@endforeach
					 </td><td align="left" style="color:red;"><center>EXXEL INTERNATIONAL TRADING</center></td>
				</tr>
			</table>
			<table  style="width: 100%;">
				<tr><td align="right" style="width: 750px; ">Vehicle Pass & Delivery  Schedule</td><td><center>PERFORMANCE DATA</center></td></tr>
			</table>
			
			<div style="height: 300px; width:100%;">
				<div style="height: 300px; width:100%; float:left;">
					<div style="height: 330px; width:100%; overflow: auto;">
						<table  border="1" style="width: 100%;">
							<tr>
								<td style="width: 200px;">&nbsp;Vehicle/Plate no. :</td><td style="width: 360px;">&nbsp;
									@php
										$holder = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder != $detail->plate_no)
									  		@php $holder = $detail->plate_no @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach
								</td>
								<td style="width: 25px; border-color: white;"></td>
								<td style="width: 200px;">&nbsp;Odometer Reading :</td>
								<td style="width: 160px;">&nbsp;Total Outlet:</td>
							</tr>
							<tr>
								<td style="width: 200px;">&nbsp;Driver :</td><td style="width: 360px;">&nbsp;
									@php
										$holder = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder != $detail->driver)
									  		@php $holder = $detail->driver @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach</td>
									<td style="width: 25px; border-color: white;"></td>
									<td style="width: 200px;">&nbsp;Before Delivery  :</td>
									<td style="width: 160px;">&nbsp;Miscellaneous Reason:</td>
							</tr>
							<tr>
								<td style="width: 200px;">&nbsp;Helper :</td><td style="width: 360px;">&nbsp;
									@php
										$holder = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder != $detail->helper)
									  		@php $holder = $detail->helper @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach</td>
									<td style="width: 25px; border-color: white;"></td>
									<td style="width: 200px;">&nbsp;After Delivery  :</td>
									<td style="width: 160px;">&nbsp;Declared Quantity :</td>
							</tr>
							<tr>
								<td style="width: 200px;">&nbsp;Contact No. :</td><td style="width: 360px;">&nbsp;
									@php
										$holder = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder != $detail->contact)
									  		@php $holder = $detail->contact @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach</td>
									<td style="width: 25px; border-color: white;"></td>
									<td style="width: 200px;">&nbsp;Date :</td>
									<td style="width: 160px;">&nbsp;Total Backload :</td>
							</tr>
							<tr>
								<td style="width: 200px;">&nbsp;Date :</td><td style="width: 360px;">&nbsp;
									@php
										$holder = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder != $detail->date_delivery)
									  		@php $holder = $detail->date_delivery @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach</td>
									<td style="width: 25px; border-color: white;"></td>
									<td style="width: 200px;">&nbsp;Time left :</td>
									<td style="width: 160px;">&nbsp;Total Undelivered :</td>
							</tr>
							<tr>
								<td style="width: 200px;">&nbsp;Prepared By :</td><td style="width: 360px;">&nbsp;
									@php
										$holder = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder != $detail->plate_no)
									  		@php $holder = $detail->plate_no @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach</td>
									<td style="width: 25px; border-color: white;"></td>
									<td style="width: 200px;">&nbsp;Time arrived :</td>
									<td style="width: 160px;"></td>
							<tr>
								<td style="width: 200px;">&nbsp;Area / Time :</td><td style="width: 360px;">&nbsp;
									@php
										$holder1 = '';
										$holder2 = '';
									@endphp

									@foreach($details as $detail)
									  	@if($holder1 != $detail->area && $holder2 != $detail->time)
									  		@php 
									  			$holder1 = $detail->area;
									  			$holder2 = $detail->time;
									  		@endphp
									  		{{ $holder1 }} &nbsp; {{ $holder2 }}
									  	@endif
									@endforeach</td>
									<td style="width: 25px; border-color: white;"></td>
									<td style="width: 200px;">&nbsp;Guard on duty :</td>
									<td style="width: 160px;"></td>
							</tr>
							<tr>
								<td></td><td colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style="color:#574595;">FINANCE CONTACT# '0932-4855-400'</font></td>
							</tr>
						</table>

						<table border="1" style="width: 100%; margin: auto;">
							<tr style="text-align: center;">
								<th> &nbsp;OUTLET NAME</th>
								<th>&nbsp;ADDRESS</th>
								<th>&nbsp;BRAND</th>
								<th>&nbsp;DR#</th>
								<th>&nbsp;S.I #</th>
								<th>&nbsp;#OF BOX</th>
								<th style="width: 10px;">&nbsp;# OF PLASTIC</th>
								<th>&nbsp;Arrive Time</th>
								<th>&nbsp;Departure Time</th>
								<th>&nbsp;Customer Signature</th>
								<th style="width: 10px;">&nbsp;CONC / OUT</th>
								<th>&nbsp;Amount</th>
								<th style="width: 200px;">&nbsp;Remarks</th>
								<th>&nbsp;Series #</th>
							</tr>
								@foreach($details as $detail)
									<tr>
										<td>{{$detail->outlet}}</td><td>{{$detail->address}}</td><td style="text-align: center;">
											@if($detail->brand == 'PULL OUT')
													<font style="color:red;">{{$detail->brand}}</font>
											@else
													{{$detail->brand}}
											@endif
										</td>
										<td style="text-align: center;">{{$detail->dr_no}}</td>
										<td>{{$detail->si_no}}</td>
										<td style="text-align: center;"><font style="color:red;">{{$detail->no_of_box}}</font></td>
										<td></td><td></td><td></td><td></td>
										<td style="text-align: center;">{{$detail->category}}</td>
										<td style="text-align: center;"><font style="color:red;">{{$detail->amount}}</font></td>
										<td></td>
										<td style="text-align: center;">{{$detail->series}}</td>
									</tr>
							@endforeach
							<tr class="noBorder">
								<td></td><td></td><td></td><td></td><td></td><td style="text-align: center;"><font style="color:red;">
									@php
										$holder = '';
									@endphp
									@foreach($details as $detail)
									  	@if($holder != $detail->tot_box)
									  		@php $holder = $detail->tot_box @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach
								</font></td><td></td><td></td><td></td><td></td><td></td>
								<td style="text-align: center;"><font style="color:red;">
									@php
										$holder = '';
									@endphp
									@foreach($details as $detail)
									  	@if($holder != $detail->tot_amnt)
									  		@php $holder = $detail->tot_amnt @endphp
									  		{{ $holder }}
									  	@endif
									@endforeach
								</font></td><td></td><td></td>
							</tr>
						</table>
						
						NOTE: Inform Sales Admin or Immediate supervisor for expired sticker, Invoice & DR need to return after receiving
						<table border="1" style="width: 100%; margin: auto;">
							<tr>
								<td><center><font style="color:red;">STEP 1 ( Loading )</font></center></td>
								<td><center><font style="color:red;">STEP 2 ARRIVAL ( Unloading )</font></center></td>
								<td><center><font style="color:red;">STEP 3 Completion</font></center></td>
								<td style="width: 200px;"></td>
							</tr>
							<tr>
								<td>&nbsp;Prepared by:</td>
								<td>&nbsp;Box returned #:</td>
								<td>&nbsp;Checked/Received by:( <font style="color:red;"> Dispatcher </font>)</td>
								<td style="width: 200px;"></td>
							</tr>
							<tr>
								<td>&nbsp;Dispatched by:</td>
								<td>&nbsp;Box Missing #:</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>&nbsp;Checked by ( Guard On Duty ):</td>
								<td>&nbsp;Arrived Time Stocks/Docs:</td>
								<td>&nbsp;Complete Docs :</td>
								<td style="width: 200px;"></td>
							</tr>

							<tr>
								<td rowspan="2">&nbsp;Acknowledge by: (Deliver/Helper)<br><font style="color:red;">&nbsp;INCLUDING TOTAL BOXES AND DOCS. RECEIVED</font></td>
									<td></td>
									<td>&nbsp;Documents Missing (DR #)</td>
									<td>&nbsp;Verified by (Finance) :</td>
								<tr>
									<td>&nbsp;Guard On Duty/Checked:</td>
									<td></td>
									<td style="width: 200px;"></td>
								</tr>
							</tr>
							<tr>
								<td colspan="4"><center><font style="color:red;">NOTE</font> : Please Fill up all <font style="color:red;">DATA</font> needed</center></td>
							</tr>
							
						</table>
					</div>
				</div>


				
			</div>	
		
	</div>
 </body>
</html>






