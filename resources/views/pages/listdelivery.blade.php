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


#rawdata tr:hover td {background:#ccfff5}

.checkboxes label {
  display: block;
  float: left;
  padding-right: 10px;
  white-space: nowrap;
}
.checkboxes input {
  vertical-align: middle;
}
.checkboxes label span {
  vertical-align: middle;
}
</style>
<script src="{{asset("/dashboards/vendor/jquery/jquery.min.js")}}"></script>
<script type="text/javascript">
var pullout = 'N';
$(document).ready(function(){

	getAllTransactions();

	$('#btnSearch').click(function(){

		if($('#min-date').val() == '' || $('#max-date').val() == ''){
				alert('Please input two dates');
				return false;
			}
		$("#rawdata").dataTable().fnDestroy();
		getAllTransactions();
	});

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

	$('#optional').click(function(){

		if($(this).is(":checked")){
               $('#optional_filter').modal('toggle');
               //$('#optional').prop('checked',false);
              
            }
            else if($(this).is(":not(:checked)")){
            	$('#optional_filter').modal('hide');

            }
	})

});





function getAllTransactions(){

var min = $('#min-date').val();
var max = $('#max-date').val();
var date = min+'*'+max;


var url = '{{ route("tripList", ":date") }}';
var url1 = url.replace(':date', date);
$('#rawdata').DataTable({
		"processing": true,
		"serverSide": true,
		"bFilter": true,
		"lengthChange": false,
		"pageLength": 10,
		"ajax":url1,
		"columns":[
				{"data" : "action", orderable:false, searchable: false},
				{"data" : "form_series_no"},
				{"data" : "driver"},
				{"data" : "plate_no"},
				{"data" : "helper"},
				{"data" : "contact"},
				{"data" : "area"},
				{"data" : "time"},
				{"data" : "date_delivery"}
				
			],
			dom: 'Bfrtip',
			"buttons": [
            'copy', 'csv', 'excel', 'pdf', 'print'
       		 ]
	});


}

function getTransactions(){


//$("#rawdata tr").remove();
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
	    url: '{{URL::to('payment')}}'+'/'+docno,
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



function rePrint(id){
	var frm = id.split('!');

	 var url = ' {{route("printTripSchedule", ":frm") }}';
		url = url.replace(':frm', frm[1]);

	 window.open(url,'_blank');

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
 var frm = $('#formno').val();
 var mode = 'E';

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
				 _token: '{{csrf_token()}}',outlet:outlet,Address:Address,amount:amount,Brand:Brand,categ:categ,dr:dr,boxno:boxno,series:series,frmno:frm,mode:mode
				}

			$.ajax({
			    type: 'POST',
			    dataType : 'json',
			    data:datas,
			    url: '{{URL::to('savetoTemp')}}',
			}).done(function( msg ) {
				var data = jQuery.parseJSON(JSON.stringify(msg));
				if(data.msg == 'Record saved.'){
					alert(data.msg);
					$('#boxno').val('');
					$('#series').val('');
					//$('#rawdata').DataTable().ajax.reload();
					$('#txtSearch').val('');
					$('#txtSearch').focus();
				}else{
					alert(data.msg);
				}
			});	

}

function addDetails(formno){
	$('#formno').val(formno);
}

function viewDetails(formno){
	$('#formno1').val(formno);
	var formno = formno;




	$.ajax({
	    type: "GET",
	    dataType : "json",
	    url: '{{URL::to('redisplayEntry')}}'+'/'+formno,
	}).done(function( msg ) {

			var dets = '';
			$.each(msg, function(key, value){

				
				dets += '<tr>';
				dets += '<td>'+value.outlet+'</td>';
				dets += '<td>'+value.address+'</td>';
				dets += '<td>'+value.brand+'</td>';
				dets += '<td>'+value.dr_no+'</td>';
				dets += '<td>'+value.si_no+'</td>';
				dets += '<td>'+value.no_of_box+'</td>';
				dets += '<td>'+value.category+'</td>';
				dets += '<td>'+value.amount+'</td>';
				dets += '<td>'+value.series+'</td>';
				dets += '</tr>';

			});
			$('#rawdata1').append(dets);
	});

	
}


</script>
@section('content')

 <ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="#">List of delivery</a>&nbsp;&nbsp;|&nbsp;&nbsp;<label for="optional"><input type="checkbox" id="optional" /> <span>Optional Filter</span></label>
  </li>
</ol>

<input type="hidden" id="trn_no" />
<div id="body_content">
<div class="input-group" style="width:700px;">
	<span>From:&nbsp;</span>
	<div class="input-group-prepend">
	    <span class="input-group-text" ><i class="fas fa-fw fa-calendar"></i></span>
	  </div>
	  <input type="date" class="form-control" id="min-date">
	  <span>&nbsp;To:&nbsp;</span>
	<div class="input-group-prepend">
	    <span class="input-group-text" ><i class="fas fa-fw fa-calendar"></i></span>
	</div>
	  <input type="date" class="form-control" id="max-date">
	  &nbsp;<button class="btn btn-primary" id="btnSearch" >Search</button>
	  
	  
</div>
<br>
<center>
		
			<table class="table table-striped" style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; "  id="rawdata">
			<thead>
				<tr>
					<th>ACTION</th>
					<th>FORM #</th>
					<th>DRIVER</th>
					<th>PLATE NO</th>
					<th>HELPER</th>
					<th>CONTACT #</th>
					<th>DATE DELIVERY</th>
					<th>AREA</th>
					<th>TIME</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
</center>

@endsection
</div>

<!--modify details-->
<div class="modal fade" id="modModal" tabindex="-1" role="dialog" aria-labelledby="modModal" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modModal">Form #: <input type="text" style="border:0px;" id="formno"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<center>
				 <input type="hidden" id="trn_no" />
				 <input type="hidden" id="maker" value="  @if(Session::has('user_id'))

		                   {{ Session::get('user_id')}}

		              @endif ">
				<table class="table table-responsive" style="width: 100%; margin: auto;">
						<tr>
							<td style="width:160px;">Document No  </td>
							<td>
								<div class="input-group" style="width:200px;">
								  <input type="text" class="form-control" id="txtSearch" placeholder="Enter Document #" >
								 
								  <div class="input-group-prepend">
								    <span class="input-group-text" style="background-color: #5bc0de; " id="btnsearch" title="Search" onclick="getTransactions()"><i class="fas fa-fw fa-search" style="cursor: pointer;"></i></span>
								  </div>
								</div>
							</td>
							<td style="width:400px;"></td><td style="width:400px;"></td>
							<td style="width:185px; " >Transaction Date </td>
							<td>
								<div class="input-group" style="width:200px;">
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
								    <input type="text" class="form-control" id="txtcustomer" placeholder="Customer name" style="width: 250px;" readonly></input>
							</div>
						</td>
						<td>&nbsp;&nbsp;&nbsp;Address :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<div class="form-group">
								<input class="form-control" id="txtaddress" placeholder="Address" style="width: 250px;" readonly></input>
							</div>
						</td>
		        	</tr>
		        	<tr>
		        		<td>Amount :&nbsp;</td>
		        		<td>
		        			<div class="form-group">
		        				 <input type="text" class="form-control" id="txtamount" placeholder="amount" style="width: 250px;" readonly>
		        			</div>
		        		</td>
		        		<td>&nbsp;&nbsp;&nbsp;Brand:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" id="brand" placeholder="Brand"  style="width: 250px;">
							</div>
						</td>
		        	</tr>
		        	<tr>
		        		<td>DR # :&nbsp;</td>
		        		<td>
		        			<div class="form-group">
								  <input type="text" class="form-control" id="dr" placeholder="DR No."  style="width: 250px;" readonly>
							</div>
						</td>
						<td>&nbsp;&nbsp;&nbsp;Category # :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" id="categ" placeholder="Category" style="width: 250px;" readonly>
							</div>
						</td>
		        	</tr>
		        	<tr>
		        		<td>No. Of Box :&nbsp;</td><td><input type="text" class="form-control" id="boxno" placeholder="No. of Box" style="width: 250px;"  onkeypress="return isNumber(event)">
		        		</td>
		        		<td>&nbsp;&nbsp;&nbsp;Series # :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td>
							<div class="form-group">
								<input type="text" class="form-control" id="series" placeholder="Series" style="width: 250px;">
							</div>
						</td>
		        	</tr>
		        	<tr>
		        		<td colspan="4" align="right"><button class="btn btn-primary" id="btnAdd" onclick="saveToTemp()"><i class="fa fa-plus"></i>&nbsp;Add</button></td>
		        	</tr>
		        </table>
		    </div>
		</fieldset>
      	
      </div>
    </div>
  </div>
</div>
<!--end modify-->

<!--view delivery item details-->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="modModal" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modModal">Form #: <input type="text" style="border:0px;" id="formno1"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
        	<ol class="breadcrumb">
			  <li class="breadcrumb-item">
			    <a href="#">List of items</a>
			  </li>
			</ol>
				<div style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; ">
					<table class="table table-striped" style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; "  id="rawdata2">
						<thead>
							<tr>
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
				</div>
   		</div>
    </div>
  </div>
</div>

<!--view delivery item details-->
<div class="modal fade" id="optional_filter" tabindex="-1" role="dialog" aria-labelledby="modModal" aria-hidden="true" >
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
        	<ol class="breadcrumb">
			  <li class="breadcrumb-item">
			    <a href="#">Optional Filter</a>
			  </li>
			</ol>
				<div style="width: 100%; overflow-x: scroll; font-size: 12px; text-align: center; ">
					<table  class="table table-responsive" id="rawdata3" style="border-radius: 8px;">
						<thead>
							<tr>
								<th>FORM #</th>
								<th>DR #</th>
								<th>SI #</th>
								<th>SERIES #</th>
								<th>DATE DELIVER</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
   		</div>
    </div>
  </div>
</div>

