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

var  rawdatas = '';
var driverid = '';
var pullout = 'N';

var frm = 3263;

		$(document).ready(function(){

			$('#tran_type').val(0);

			$('#btnPrint').prop('disabled',true);
			$('#btnSave').prop('disabled',true);

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

				$('#rawdata').DataTable({
					"processing": true,
					"serverSide": true,
					"bFilter": false,
					"lengthChange": false,
					"pageLength": 20,
					"ajax": "{{route('displayEntry')}}",
					"columns":[
							{"data" : "action", orderable:false, searchable: false},
							{"data" : "outlet"},
							{"data" : "address"},
							{"data" : "brand"},
							{"data" : "dr_no"},
							{"data" : "si_no"},
							{"data" : "no_of_box"},
							{"data" : "category"},
							{"data" : "amount"},
							{"data" : "series"}
						]
				});

				
				getLastRecord();

				$('#selection').click(function(){

					

					if($(this).is(":checked")){
						//for SI
			                $('#txtSearch').prop('disabled',true);
			                $('#btnsearch').prop('disabled',true);
			                $('#txtcustomer').prop('readonly',false); 
			                $('#txtaddress').prop('readonly',false); 
			                $('#txtamount').prop('readonly',false); 
			                $('#dr').prop('readonly',false); 
			                $('#categ').prop('readonly',false); 
			                $('#tdate').prop('readonly',false); 
			                $('#tran_type').val(1);
			            }
			            else if($(this).is(":not(:checked)")){
			                $('#txtSearch').prop('disabled',false);
			                $('#btnsearch').prop('disabled',false);
			                $('#txtcustomer').prop('readonly',true);
			                $('#txtaddress').prop('readonly',true); 
			                $('#txtamount').prop('readonly',true); 
			                $('#dr').prop('readonly',true); 
			                $('#categ').prop('readonly',true); 
			                $('#tdate').prop('readonly',true); 
			                $('#tran_type').val(0);
							

			            }
				});

				$('#selection2').click(function(){
					//for pullout
					if($(this).is(":checked")){
			                $('#txtSearch').prop('disabled',true);
			                $('#btnsearch').prop('disabled',true);
			                $('#txtcustomer').prop('readonly',false); 
			                $('#txtaddress').prop('readonly',false); 
			                $('#txtamount').prop('readonly',false); 
			                $('#dr').prop('readonly',false); 
			                $('#categ').prop('readonly',false); 
			                $('#tdate').prop('readonly',false); 
			                pullout = 'Y';
			                $('#brand').val('PULL OUT');
			            }
			            else if($(this).is(":not(:checked)")){
			                $('#txtSearch').prop('disabled',false);
			                $('#btnsearch').prop('disabled',false);
			                $('#txtcustomer').prop('readonly',true);
			                $('#txtaddress').prop('readonly',true); 
			                $('#txtamount').prop('readonly',true); 
			                $('#dr').prop('readonly',true); 
			                $('#categ').prop('readonly',true); 
			                $('#tdate').prop('readonly',true); 
			                pullout = 'N';
			                $('#brand').val('');
							

			            }
				});

		});

function getTransactions(){

	var categ = '';
	var docno = $('#txtSearch').val();

		if(docno == ''){
			alert('Please enter document no. !');
			return false;
		}

		$.ajaxSetup({
		      headers: {
		          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		      }
		  });

		$.ajax({
		    type: "GET",
		    dataType : "json",
		   // url: '{URL::to('payment')}}'+'/'+docno,
		   url: "http://192.168.1.100:805/api_cod/index.php?doc_no="+ docno +"&type=trip" ,
		}).done(function( msg ) {
		    var data = jQuery.parseJSON(JSON.stringify(msg));
		    if(msg == null || msg == ''){
		    	alert('No record found');
		    }else{
		    	$('#trn_no').val(data[0].TRAN_NO);
			    $('#tdate').val(data[0].TRAN_DATE);
			    $('#txtcustomer').val(data[0].CONTACT_CODE);
			    $('#txtaddress').val(data[0].ADDRESS1);
			    $('#txtamount').val(data[0].AMOUNT_NET);
			    $('#dr').val(docno);
			    $('#brand').val(data[0].PROD_BRD_CODE);
			    if(data[0].TRAN_TYPE == 2 || data[0].TRAN_TYPE == 3 || data[0].TRAN_TYPE == 5 || data[0].TRAN_TYPE == 6){
			    	categ = 'C'
			    }else{
			    	categ = 'O'
			    }
			    $('#categ').val(categ);

			   
			}
		});
}

function saveToTemp(){
	
 $('#btnSave').prop('disabled',false);

	 var outlet = $('#txtcustomer').val();
	 var Address = $('#txtaddress').val();
	 var amount = $('#txtamount').val();
	 var Brand = $('#brand').val();
	 var categ = $('#categ').val();
	 var dr = $('#dr').val();
	 var boxno = $('#boxno').val();
	 var series = $('#series').val();
	 var mode = 'N';

		 if(pullout == 'N'){
			 if(outlet == ''){
			 	alert('Outlet is mandatory !')
			 	return false;
			 }

			 if(boxno == '' || boxno == 0){
			 	alert('No. of box is mandatory !');
			 	return false;
			 }

			 if(series == ''){
			 	alert('Series is mandatory !');
			 	return false;
			 }
		}


			var datas = {
						 _token: '{{csrf_token()}}',outlet:outlet,Address:Address,amount:amount,Brand:Brand,categ:categ,dr:dr,boxno:boxno,series:series,frmno:frm,mode:mode,trantype:$('#tran_type').val()
						}

					$.ajax({
					    type: 'POST',
					    dataType : 'json',
					    data:datas,
					    url: '{{URL::to('savetoTemp')}}',
					}).done(function( msg ) {
						var data = jQuery.parseJSON(JSON.stringify(msg));
						if(data.msg == 'Record saved.'){
							//alert(data.msg);
							$('#boxno').val('');
							$('#series').val('');
							$('#rawdata').DataTable().ajax.reload();
							$('#txtSearch').val('');
							$('#txtSearch').focus();
						}else{
							alert(data.msg);
						}
					});	

}

function saveTomain(){
	
	 var driver = driverid;
	 var plateno = $('#plateno').val();
	 var deliverydate = $('#datedelivery').val();
	 var helper = $('#helper').val();
	 var area = $('#area').val();
	 var contact = $('#contact').val();
	 var time = $('#time').val();
	 
			if(driver == ''){
				alert('Driver is mandatory !');
				return false;
			}

			if(plateno != '' ){
				if(helper == ''){
					alert('Helper is mandatory !');
					return false;
				}
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
							 _token: '{{csrf_token()}}',frmno:frm,driver:driver,plateno:plateno,deliverydate:deliverydate,preparedby:{{ Session::get('user_id')}},helper:helper,area:area,contact:contact,time:time
							}

						$.ajax({
						    type: 'POST',
						    dataType : 'json',
						    data:datas,
						    url: '{{URL::to('savetoMain')}}',
						}).done(function( msg ) {
							//console.log(msg);
							//return false;
							var data = jQuery.parseJSON(JSON.stringify(msg));
							if(data.msg == 'Record saved.'){
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

						dets += '<option value='+value.id+'!'+value.Plate_no+'!'+value.Contact+'>'+value.name+'</option>';

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
						dets += '<option value='+value.id+'!'+value.Contact+'>'+value.name+'</option>';
						
					});
					$('#helper').append(dets);
			})
}

function getPlatenumber(info){
	var data = info.split('!');
	$('#plateno').val(data[1]);
	$('#contact').val(data[2]);
	driverid = data[0];
}

function getContact(info){
	var data = info.split('!');
	var contact = $('#contact').val();
	var contact1 = contact + ' / ' +data[1];

	$('#contact').val(contact1);
	
}
function getLastRecord(){

	$.ajax({
			    type: "GET",
			    dataType : "json",
			    url: '{{URL::to('getLastSeq')}}',
			}).done(function( msg ) {
				var data = jQuery.parseJSON(JSON.stringify(msg));
				
				if(data.form_series_no == null)
				{
					frm = frm;
					$('#frmno').html(frm);
					$('#formno').val(frm);
				}else{
					
					frm = data.form_series_no + 1;
					//alert(frm)
					$('#frmno').html(data.form_series_no + 1);
					$('#formno').val(frm);
				}
			})

	//frm = frm + 1;

	
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
 $('#txtcustomer').val('');
 $('#txtaddress').val('');
 $('#txtamount').val('');
 $('#brand').val('');
 $('#categ').val('');
 $('#dr').val('');
 $('#boxno').val('');
 $('#series').val('');
 $('#tdate').val('');
 
}

function delDetails(id){

			$.ajax({
			    type: 'GET',
			    url: '{{URL::to('cancelList')}}'+'/'+id,
			}).done(function( msg ) {
				$('#rawdata').DataTable().ajax.reload();
			});
		
}

</script>
@section('content')
 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">Vehicle Pass & Delivery  Schedule</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="#">Form #: <span id="frmno">0</span></a>
    <input type="hidden" id="formno"></input>
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
        				<input type="text" class="form-control" id="plateno" placeholder="Enter Plate No." style="width: 650px;">
        			</div>
        		</td>
        		<td>&nbsp;&nbsp;&nbsp;Prepared by :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" id="preparedby" placeholder="Enter Plate No." value="{{ Session::get('Firstname')}}" style="width: 650px;" readonly>
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>Helper :&nbsp;</td>
        		<td>
        			<div class="form-group">
						    <select class="form-control" id="helper" style="width: 650px;" onchange="getContact(this.value)">
						    </select>
					</div>
				</td>
				<td>&nbsp;&nbsp;&nbsp;Area :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" id="area" placeholder="Area" style="width: 650px;">
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>Contact No :&nbsp;</td><td><input type="text" class="form-control" id="contact" placeholder="Enter Contact No." style="width: 650px;"  readonly>
        		</td>
        		<td>&nbsp;&nbsp;&nbsp;Time :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="time" class="form-control" id="time" placeholder="Time" style="width: 650px;">
					</div>
				</td>
        	</tr>
        </table>
    </div>
</fieldset>


<center>
		 <input type="hidden" id="trn_no" />
		 <input type="hidden" id="maker" value="  @if(Session::has('user_id'))

                   {{ Session::get('user_id')}}

              @endif ">
		<table class="table" style="width: 100%; margin: auto;">
				<tr>
					<td style="width:160px; font-size: 24px;" >Document No  </td>
					<td>
						<div class="input-group" style="width:250px;">
						  <input type="text" class="form-control" id="txtSearch" placeholder="Enter Document No." >
						 
						  <div class="input-group-prepend">
						    <span class="input-group-text" style="background-color: #5bc0de; " id="btnsearch" title="Search" onclick="getTransactions()"><i class="fas fa-fw fa-search" style="cursor: pointer;"></i></span>
						  </div>
						</div>
					</td>
					<td style="width:400px;"></td><td style="width:400px;"></td>
					<td style="width:185px; font-size: 24px;" >Transaction Date </td>
					<td>
						<div class="input-group" style="width:250px;">
							  <input type="text" class="form-control" id="tdate" readonly>
							  <div class="input-group-prepend">
							    <span class="input-group-text" ><i class="fas fa-fw fa-calendar"></i></span>
							  </div>
						</div>
					</td>
					
				</tr>
		<tr><td colspan="6"></td></tr>
		</table>	
		
</center>


<fieldset class="scheduler-border">
    <legend class="scheduler-border">Other Details</legend>
    <div class="control-group">
        <table class="table-responsive">
        	<tr>
        		<td colspan="4"><input type="checkbox" id="selection"> Is Sales Invoice ? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" id="selection2"> Is Pullout ?</td></td>
        	<input type="hidden" id="tran_type"></input>
        	</tr>
        	<tr>
        		<td>Outlet :&nbsp;</td>
        		<td>
        			<div class="form-group">
						    <input type="text" class="form-control" id="txtcustomer" placeholder="Customer name" style="width: 650px;" readonly></input>
					</div>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input class="form-control" id="txtaddress" placeholder="Address" style="width: 650px;" readonly></input>
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>Amount :&nbsp;</td>
        		<td>
        			<div class="form-group">
        				 <input type="text" class="form-control" id="txtamount" placeholder="amount" style="width: 650px;" readonly>
        			</div>
        		</td>
        		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Brand :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" id="brand" placeholder="Brand"  style="width: 650px;">
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>DR / SI # :&nbsp;</td>
        		<td>
        			<div class="form-group">
						  <input type="text" class="form-control" id="dr" placeholder="DR / SI No."  style="width: 650px;" readonly>
					</div>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Category # :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" id="categ" placeholder="Category" style="width: 650px;">
					</div>
				</td>
        	</tr>
        	<tr>
        		<td>No. Of Box :&nbsp;</td><td><input type="text" class="form-control" id="boxno" placeholder="No. of Box" style="width: 650px;"  onkeypress="return isNumber(event)">
        		</td>
        		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Series # :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<div class="form-group">
						<input type="text" class="form-control" id="series" placeholder="Series" style="width: 650px;">
					</div>
				</td>
        	</tr>
        	<tr>
        		<td colspan="4" align="right"><button class="btn btn-primary" id="btnAdd" onclick="saveToTemp()"><i class="fa fa-plus"></i>&nbsp;Add</button></td>
        	</tr>
        </table>
    </div>
</fieldset>

<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">List of items</a>
  </li>
</ol>
<table class="table table-striped" style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; "  id="rawdata">
	<thead>
		<tr>
			<th>ACTION</th>
			<th>OUTLET</th>
			<th>ADDRESS</th>
			<th>BRAND</th>
			<th>DR #</th>
			<th>SI #</th>
			<th>NO. OF BOX</th>
			<th>CATEGORY</th>
			<th>AMOUNT</th>
			<th>SERIES</th>
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