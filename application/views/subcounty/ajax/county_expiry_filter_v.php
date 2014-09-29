
<div class="alert alert-info">
  <b>Below are the expiries in the County </b> :Select filter Options
</div>
<!--<ul class='nav nav-tabs'>
      <li class="active"><a href="#county" data-toggle="tab">Expiries</a></li>
     <!-- <li class=""><a href="#subcounty" data-toggle="tab">Sub County View</a></li>
</ul>
    <div id="myTabContent" class="tab-content">
      <div  id="county" class="tab-pane fade active in">
      	<br>-->
<div class="filter row">
<form class="form-inline" role="form">
<select id="county_year_filter" class="form-control col-md-2">
	<option value="NULL" selected="selected">Select year</option>
	<option value="2014">2014</option>
	<option value="2013">2013</option>
</select>
<select id="county_district_filter" class="form-control col-md-2">
<option selected="selected" value="NULL">Select Sub-county</option>
<?php
	foreach($district_data as $district_):
			$district_id=$district_->id;
			$district_name=$district_->district;	
			echo "<option value='$district_id'>$district_name</option>";
	endforeach;
?>
</select>
<select id="facility_filter" class="form-control col-md-2">
	<option value="NULL">Select facility</option>
</select>
<select id="county_plot_value_filter" class="form-control col-md-2">
<option selected="selected" value="NULL">Select Plot value</option>
<option value="packs">Packs</option>
<option value="units">Units</option>
<!--<option value="ksh">KSH</option>-->
</select>
<div class="col-md-1">
<button class="btn btn-sm btn-small btn-success county-filter"><span class="glyphicon glyphicon-filter"></span>Filter</button>
</div> 
<!--<div class="col-md-1">
<button class="btn btn-sm btn-success county-table-data"><span class="glyphicon glyphicon-th-list"></span>Table Data</button> 
</div>
<div class="col-md-1">
<button class="btn btn-sm btn-success county-download"><span class="glyphicon glyphicon-save"></span>Download</button> 
</div>-->
</form>
</div>
 <!--</div>
<div  id="subcounty" class="tab-pane fade">
 <br>
<div class="filter row">
<form class="form-inline" role="form">
<select id="year_filter" class="form-control col-md-2">
	<option value="NULL" selected="selected">Select year</option>
	<option value="2014">2014</option>
	<option value="2013">2013</option>
</select>	
<select name="month" id="month_filter" class="form-control col-md-2" >
<option value="NULL" selected="selected">Select month</option>
<option value="01">Jan</option>
<option value="02">Feb</option>
<option value="03">Mar</option>
<option value="04">Apr</option>
<option value="05">May</option>
<option value="06">Jun</option>
<option value="07">Jul</option>
<option value="08">Aug</option>
<option value="09">Sep</option>
<option value="10">Oct</option>
<option value="11">Nov</option>
<option value="12">Dec</option>
</select>
<select id="district_filter" class="form-control col-md-2">
<option selected="selected" value="NULL">Select Sub-county</option>
<?php
foreach($district_data as $district_):
		$district_id=$district_->id;
		$district_name=$district_->district;	
		echo "<option value='$district_id'>$district_name</option>";
endforeach;
?>
</select> 
<select id="facility_filter" class="form-control col-md-2">
<option value="NULL">Select facility</option>
</select>	
<select id="plot_value_filter" class="form-control col-md-2">
<option selected="selected" value="NULL">Select Plot value</option>
<option value="packs">Packs</option>
<option value="units">Units</option>
<option value="ksh">KSH</option>
</select>
<div class="col-md-1">
<button class="btn btn-sm btn-small btn-success subcounty-filter"><span class="glyphicon glyphicon-filter"></span>Filter</button> 
</div> 
<div class="col-md-1">
<button class="btn btn-sm btn-success subcounty-download"><span class="glyphicon glyphicon-save"></span>Download</button> 
</div>
</form>
</div>
</div>
</div>-->
<div class="graph_content" id="dem_graph_">	
</div>
<script>
	 $(function () { 
<?php echo $default_expiries; ?>
});

	$(document).ready(function() {
		    window.onload = function(){
    var url_ = 'reports/get_county_cost_of_expiries_new/NULL/NULL/NULL/NULL/NULL';  
		ajax_request_replace_div_content(url_,'.graph_content');	
  }
		// reports/get_county_cost_of_expiries_new/NULL/NULL/NULL/NULL/NULL
        //setting up the report
		$("#facility_filter").hide();
		$("#county_district_filter").change(function() {
		var option_value=$(this).val();	
		if(option_value=='NULL'){ $("#facility_filter").hide('slow');	}
		else{			
	     var drop_down='';
 		 var hcmp_facility_api = "<?php echo base_url(); ?>reports/get_facility_json_data/"+$("#county_district_filter").val();
 		 $.getJSON( hcmp_facility_api ,function( json ) {
    	 $("#facility_filter").html('<option value="NULL" selected="selected">--select facility--</option>');
     	 $.each(json, function( key, val ) {
      		drop_down +="<option value='"+json[key]["facility_code"]+"'>"+json[key]["facility_name"]+"</option>";	
     	 });
    	 $("#facility_filter").append(drop_down);
   		});
		$("#facility_filter").show('slow');		
		}
		});
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          $('.graph_content').html('');
          })
		
	    $(".county-filter").on('click',function(e) {
		e.preventDefault();	
		//$year = null, $month = null, $district_id = null, $option = null, $facility_code = null,$report_type=null)
        var url_ = 'reports/get_county_cost_of_expiries_dashboard/'+$("#county_year_filter").val()+"/"+$("#county_district_filter").val()+"/"+$("#county_plot_value_filter").val()+"/"+$("#facility_filter").val()+"/graph";  
		
		ajax_request_replace_div_content(url_,'.graph_content');		
          });
		//For displaying the table data
		$(".county-table-data").on('click',function(e) {
		e.preventDefault();	
		//$year = null, $month = null, $district_id = null, $option = null, $facility_code = null,$report_type=null)
        var url_ = 'reports/get_county_cost_of_expiries_dashboard/'+$("#county_year_filter").val()+"/"+$("#county_district_filter").val()+"/"+$("#county_plot_value_filter").val()+"/"+$("#facility_filter").val()+"/table";  
		
		ajax_request_replace_div_content(url_,'.graph_content');		
          });
        $(".county-download").on('click',function(e) {
		e.preventDefault();			  
        var url_ = 'reports/get_county_cost_of_expiries_new/'+
        $("#county_year_filter").val()+"/"+$("#county_month_filter").val()+ "/NULL"+"/"+$("#county_plot_value_filter").val()+"/NULL"+"/csv_data";	
		 window.open(url+url_ ,'_blank');
         });	
         
        $(".subcounty-filter").on('click',function(e) {
		e.preventDefault();	
        var url_ = 'reports/get_county_cost_of_expiries_new/'+
        $("#year_filter").val()+"/"+$("#month_filter").val()+ "/"+$("#district_filter").val()+"/"+$("#plot_value_filter").val()+"/"+$("#facility_filter").val();  
		ajax_request_replace_div_content(url_,'.graph_content');		
          });
          
         $(".subcounty-download").on('click',function(e) {
		e.preventDefault();	
        var url_ = 'reports/get_county_cost_of_expiries_new/'+
        $("#year_filter").val()+"/"+$("#month_filter").val()+ "/"+$("#district_filter").val()+"/"+$("#plot_value_filter").val()+"/"+$("#facility_filter").val()+"/csv_data";	 
		 window.open(url+url_ ,'_blank');		
          }); 

		});

</script>