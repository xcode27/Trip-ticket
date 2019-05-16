@extends('layout.app')
<style type="text/css">
	th, td {
  white-space: nowrap;
}

 fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;

}

    legend.scheduler-border {
        font-size: 1.2em !important;
        font-weight: bold !important;
        text-align: left !important;
        width:auto;
        padding:0 10px;
        border-bottom:none;
    }
</style>
<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">


$(document).ready(function(){

	$('#tran_type').val(0);

	//$('#btnPrint').prop('disabled',true);
	//$('#btnSave').prop('disabled',true);

	$('#txtSearch').keypress(function(e){
		var key = e.which;
		 if(key == 13)  // the enter key code
		  {
		    getTransactions();
			$('#btnSave').focus();
		  }
		
	});


	getDrivers();
	getHelpers();
	getRoutes();

	$('#rawdata').DataTable({
		"processing": true,
		"serverSide": true,
		"bFilter": false,
		"lengthChange": false,
		"pageLength": 20,
		"ajax": "{{route('displaySchedule')}}",
		"columns":[
				{"data" : "action", orderable:false, searchable: false},
				{"data" : "Plate_no"},
				{"data" : "driver"},
				{"data" : "helper"},
				{"data" : "route"},
				{"data" : "time"},
				{"data" : "date_deliver"},
				{"data" : "date_created"}
			]
	});

	

});





function saveTomain(){
	
	//saving of payment


 var driver = driverid;
 var plateno = $('#plateno').val();
 var deliverydate = $('#datedelivery').val();
 var helper = $('#helper').val();
 var area = $('#area').val();
 var time = $('#time').val();
 
	if(driver == ''){
		alert('Driver is mandatory !');
		return false;
	}

	if(helper == ''){
		alert('Helper is mandatory !');
		return false;
	}

	if(deliverydate == ''){
		alert('Date delivery is mandatory !');
		return false;
	}

	if(area == ''){
		alert('Area is mandatory !');
		return false;
	}

	if(time == ''){
		alert('Time is mandatory !');
		return false;
	}

	var datas = {
				 _token: '{{csrf_token()}}',driver:driver,plateno:plateno,deliverydate:deliverydate,helper:helper,area:area,time:time
				}

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('saveTrip')}}',
			}).done(function( msg ) {
				//console.log(msg);
				//return false;
				var data = jQuery.parseJSON(JSON.stringify(msg));
				if(data.msg == 'Route Destination saved.'){
					alert(data.msg);
					$('#rawdata').DataTable().ajax.reload();

					$('#btnPrint').prop('disabled',false);
					
				}else{
					alert(data.msg);
				}
			});


}

function getDrivers(){

	 $.ajax({
			    type: "GET",
			    dataType : "json",
			    url: '{{URL::to('getDriver')}}',
			}).done(function( msg ) {
					var dets = '';
					dets +='<option></option>';
					$.each(msg, function(key, value){

						dets += '<option value='+value.id+'!'+value.Plate_no+'>'+value.name+'</option>';

					});
					$('#driver').append(dets);
			})
}

function getHelpers(){

	 $.ajax({
			    type: "GET",
			    dataType : "json",
			    url: '{{URL::to('getHelper')}}',
			}).done(function( msg ) {
					var dets = '';
					dets +='<option></option>';
					$.each(msg, function(key, value){
						dets += '<option value='+value.id+'>'+value.name+'</option>';
						
					});
					$('#helper').append(dets);
			})
}

function getPlatenumber(info){
	var data = info.split('!');
	$('#plateno').val(data[1]);
	driverid = data[0];
}

function getRoutes(){

	 $.ajax({
			    type: "GET",
			    dataType : "json",
			    url: '{{URL::to('getroute')}}',
			}).done(function( msg ) {
					var dets = '';
					dets +='<option></option>';
					$.each(msg, function(key, value){
						dets += '<option value='+value.id+'>'+value.route+'</option>';
						
					});
					$('#area').append(dets);
			})
}

function printinfo(){

	 var url = ' {{route("printTripSchedule", ":frm") }}';
		url = url.replace(':frm', frm);

	 window.open(url,'_blank');
	 $('#rawdata').DataTable().ajax.reload();
	 getLastRecord();
	 clearFields();
	 getDrivers();
	 getHelpers();
	 $('#rawdata').DataTable().ajax.reload();

}

function clearFields(){

 $('#plateno').val('');
 $('#datedelivery').val('');
 $('#driver').empty();
 $('#helper').empty();
 $('#area').val('');
 $('#contact').val('');
 $('#time').val('');
 
}

function removeDetails(id){

	$.ajax({
	    type: 'GET',
	    url: '{{URL::to('removeTrip')}}'+'/'+id,
	}).done(function( msg ) {
		$('#rawdata').DataTable().ajax.reload();
	});
		
}

</script>
@section('content')
 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">Create Schedule for Driver's</a>
  </li>
</ol>
<fieldset class="scheduler-border">
    <legend class="scheduler-border">Driver And Helper Details</legend>
    <div class="control-group">
        <table class="table-responsive">
        	<tr>
        		<td>Driver :&nbsp;</td>
        		<td>
        			<div class="form-group">
						    <select class="form-control" id="driver" style="width:650px;" onchange="getPlatenumber(this.value)">
						    </select>
					</div>
				</td>
				<td>&nbsp;&nbsp;&nbsp;Date :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="date" class="form-control" id="datedelivery" placeholder="Enter Plate No." style="width: 650px;">
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>Vehicle / Plate No :&nbsp;</td>
        		<td>
        			<div class="form-group">
        				<input type="text" class="form-control" id="plateno" placeholder="Enter Plate No." style="width: 650px;" readonly>
        			</div>
        		</td>
        		<td>&nbsp;&nbsp;&nbsp;Helper :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
        			<div class="form-group">
						    <select class="form-control" id="helper" style="width: 650px;">
						    </select>
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>Area :&nbsp;</td>
        		<td>
        			<div class="form-group">
						<select class="form-control" id="area" style="width: 650px;"></select>
					</div>
        		</td>
        		<td>&nbsp;&nbsp;&nbsp;Time :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" id="time" placeholder="Time" style="width: 650px;">
					</div>
				</td>
        	</tr>
        </table>
    </div>
</fieldset>




<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">List of schedules</a>
  </li>
</ol>
<table class="table table-striped" style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; "  id="rawdata">
	<thead>
		<tr>
			<th>ACTION</th>
			<th>PLATE NO</th>
			<th>DRIVER</th>
			<th>HELPER</th>
			<th>ROUTE</th>
			<th>TIME</th>
			<th>DATE DELIVERY</th>
			<th>DATE CREATED</th>
			
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>
<br><br>
<div id="buttons" align="right">
	<button class="btn btn-primary" id="btnSave" onclick="saveTomain()"><i class="fa fa-save"></i>&nbsp;Save</button>
	<button class="btn btn-primary" id="btnPrint" onclick="printinfo()"> <i class="fa fa-print"></i>&nbsp;Print</button>
</div>
<br>

@endsection