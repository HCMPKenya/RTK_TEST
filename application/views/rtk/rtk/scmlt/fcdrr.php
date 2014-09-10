<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/datatable/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/tablecloth/assets/css/tablecloth.css">
<script src="<?php echo base_url(); ?>assets/tablecloth/assets/js/jquery.tablesorter.js"></script>
<script src="<?php echo base_url(); ?>assets/tablecloth/assets/js/jquery.metadata.js"></script>
<script src="<?php echo base_url(); ?>assets/tablecloth/assets/js/jquery.tablecloth.js"></script>

<style>
@import "<?php echo base_url(); ?>assets/datatable/media2/css/jquery.dataTables.css";
</style>
<style>
.user{
    width:70px;
    background : none;
    border : none;
    text-align: center;
}
.user2{
    width:70px;

    text-align: center;
}
.col5{background:#D8D8D8;}
table{
    font-size: 11px;   
}    
table td{
    line-height: 11px;
}
</style>

<script type="text/javascript">
$(function() {

    $('#user_order input').addClass("form-control");
    //$('#user_order input').addClass("resize");
    var begining_bal = <?php echo json_encode($beginning_bal);?>;

    for (var a = 0; a < begining_bal.length; a++) {            
        var current_bal = begining_bal[a];
        $('#b_balance_'+a).attr("value",current_bal); 
    };             


    $('#tests_done_0').attr("readonly",'true');

    /*Calculating the Value of the Number of tests done for Colloidal*/
    $('#vct').keyup(function(){   
        validate_vct();
        compute_tests_done();           
    })
    $('#pitc').keyup(function(){
        validate_pitc();
        compute_tests_done();
    })
    $('#pmtct').keyup(function(){
        validate_pmtct();
        compute_tests_done();
    })
    $('#blood_screening').keyup(function(){
        validate_blood();
        compute_tests_done();           
    })
    $('#other2').keyup(function(){
        validate_other();
        compute_tests_done();           
    })    

function validate_vct(){            
        var input_value  = $('#vct').val();            
        if(isNaN(input_value)){
         $('#vct').attr("value",0);
     }else if(input_value<0){
        $('#vct').attr("value",0);
    }

}
function validate_pitc(){            
    var input_value  = $('#pitc').val();            
    if(isNaN(input_value)){
     $('#pitc').attr("value",0);
 }else if(input_value<0){
    $('#pitc').attr("value",0);
}

}
function validate_pmtct(){            
        var input_value  = $('#pmtct').val();            
        if(isNaN(input_value)){
         $('#pmtct').attr("value",0);
     }else if(input_value<0){
        $('#pmtct').attr("value",0);
    }

}
function validate_blood(){            
        var input_value  = $('#blood_screening').val();            
        if(isNaN(input_value)){
         $('#blood_screening').attr("value",0);
     }else if(input_value<0){
        $('#blood_screening').attr("value",0);
    }

}
function validate_other(){            
        var input_value  = $('#other2').val();            
        if(isNaN(input_value)){
         $('#other2').attr("value",0);
     }else if(input_value<0){
        $('#other2').attr("value",0);
    }

}

function validateEnd(row){
    var end_val = $('#physical_count_' + row).val();
    if(end_val<0){

    //$('#losses_' + row).attr("value",5);
    $('#pos_adj_' + row).attr("value",0);
    $('#neg_adj_' + row).attr("value",0);
    if($('#q_used_0').val()<end_val){
        //alert('The Quantity used canot be Less than the Number of Tests Done. Please check your calculations again');
        
        // $('#q_used_0').attr("value",0);
    }
    var end =  parseInt($('#b_balance_'+row).val()) + parseInt($('#q_received_'+row).val());
    $('#q_used_' + row).attr("value",end);
    }
}


function validate_quantity_used(){

    if($('#q_used_0').val()<$('#tests_done_0').val()){
        alert('The Quantity used cannot be Less than the Number of Tests Done. Please check your calculations again');
        var t0 = $('#tests_done_0').val();
        $('#q_used_0').attr("value",t0);
    }
    var q0 = $('#q_used_0').val();
    if(isNaN(q0)){
        $('#q_used_0').attr("value",0);
    }

}

function validate_quantity_used(row){

    if($('#q_used_'+row).val()<$('#tests_done_'+row).val()){
        alert('The Quantity used cannot be Less than the Number of Tests Done. Please check your calculations again');                
        $('#q_used_'+row).attr("value",0);
    }
    var q0 = $('#q_used_'+row).val();
    if(isNaN(q0)){
        $('#q_used_'+row).attr("value",0);
    }

}

var tests_done_q = 0;
var tests_done_no = parseInt(tests_done_q);

function compute_tests_done(){  
    var vct_no = parseInt($('#vct').val());
    var pitc_no = parseInt($('#pitc').val());
    var pmtct_no = parseInt($('#pmtct').val());
    var blood_screening_no = parseInt($('#blood_screening').val());
    var other = parseInt($('#other2').val());
    tests_done_no = vct_no + pitc_no + pmtct_no + blood_screening_no + other;

    $('#tests_done_0').attr("value",tests_done_no);
    $('#q_used_0').attr("value",tests_done_no);



}       

/* --- end of calculation for the no of tests done for Colloidal -- */


$(document).ready(function() {

$("#begin_date").datepicker({
    defaultDate: "",
    changeMontd: true,
    changeYear: true,
    numberOfMontds: 1,
});
$("#end_date").datepicker({
    defaultDate: "",
    changeMonth: true,
    changeYear: true,
    numberOfMonths: 1,
    
});

    var final = 0;
    var num_final = parseInt(final);


  function compute_losses(row){
    var tests_done = $('#tests_done_'+row).val();                
    var quantity_used = $('#q_used_'+row).val();
    var loss = quantity_used - tests_done;
    if(loss <0){
        alert('Please Enter a valid number for Quantity Used and Tests Done.');
        $('#losses_'+row).val('0');
        $('#tests_done_'+row).val('0');
        $('#q_used_'+row).val('0');
    }else{
        $('#losses_'+row).val(loss);
    }
}

 function compute_end(row) {
    var bal = $('#b_balance_' + row).val();
    var num_bal = parseInt(bal);
//  alert(num_bal);

    var qty_rcvd = $('#q_received_' + row).val();
    var num_qty_rcvd = parseInt(qty_rcvd);
    //  alert(num_qty_rcvd);

    var q_used = $('#q_used_' + row).val();
    var num_q_used = parseInt(q_used);
    //  alert(num_q_used);

    var tests_done = $('#tests_done_' + row).val();
    var num_tests_done = parseInt(tests_done);
                    //  alert(num_tests_done);

                    var loses = $('#losses_' + row).val();
                    var num_loses = parseInt(loses);
    //  alert(num_loses);

    var pos_adj = $('#pos_adj_' + row).val();
    var num_pos_adj = parseInt(pos_adj);
    //  alert(num_pos_adj);

    var neg_adj = $('#neg_adj_' + row).val();
    var num_neg_adj = parseInt(neg_adj);
    //  alert(num_neg_adj);

   

     num_final = num_bal + num_qty_rcvd - num_q_used + num_pos_adj - num_neg_adj;

    //Validate Quantity Used
    var sum_bbal_q_rec_pos_adj = num_bal + num_qty_rcvd + num_pos_adj - num_neg_adj;
    if((num_q_used>sum_bbal_q_rec_pos_adj)&&(row!=0)){
        $('#losses_' + row).attr("value",0);                    
        $('#tests_done_' + row).attr("value",0);                    
        $('#q_used_'+row).css("border-color","red");
        $('#physical_count_' + row).attr("value",sum_bbal_q_rec_pos_adj);

    }else if((num_final<0)&&(row!=0)){
        $('#losses_' + row).attr("value",6);                    
        $('#tests_done_' + row).attr("value",0);
        $('#q_used_' +row).attr("value",0);
        $('#physical_count_' + row).attr("value",sum_bbal_q_rec_pos_adj);
        $('#neg_adj_' +row).attr("value",0);
        $('#pos_adj_' + row).attr("value",0);
        //$('#physical_count_' + row).attr("color","red");

    }else{
                       $('#physical_count_' + row).attr("value", num_final);

    }
}

$('.bbal').keyup(function() {
    row_id = $(this).closest("tr");
    number = row_id.attr("commodity_id");
    num = parseInt(number);
    //compute_end(num);
    //validateEnd(num);
})
$('.qty_rcvd').keyup(function() {
    row_id = $(this).closest("tr");
    number = row_id.attr("commodity_id");
    num = parseInt(number);
    compute_end(num);
    validateEnd(num);
})
$('.qty_used').keyup(function() {
    row_id = $(this).closest("tr");
    number = row_id.attr("commodity_id");
    num = parseInt(number);
    validate_quantity_used(num);
    compute_end(num);
    //compute_losses(num);
    //validateEnd(num);
})
$('.tests_done').keyup(function() {
    row_id = $(this).closest("tr");
    number = row_id.attr("commodity_id");
    num = parseInt(number);
    validate_quantity_used(num);
    compute_end(num);
    //compute_losses(num);
    //validateEnd(num);
})

$('.pos_adj').keyup(function() {
    row_id = $(this).closest("tr");
    number = row_id.attr("commodity_id");
    num = parseInt(number);
    compute_end(num);
    //validateEnd(num);
})
$('.neg_adj').keyup(function() {
    row_id = $(this).closest("tr");
    number = row_id.attr("commodity_id");
    num = parseInt(number);
    compute_end(num);
   // validateEnd(num);
})           

function add(prev, value, row_id) {
    val = $('#physical_count_' + row_id).val();
    endbal = parseInt(val);

    val = parseInt(value);
    endbal += val;
    $('#physical_count_' + row_id).attr("value", endbal);
}
function sub(prev, value, row_id) {
    val = parseInt(value);
    endbal -= val;
    $('#physical_count_' + row_id).attr("value", endbal);
}

});     


$('#save1')
.button()
.click(function() {               
    $('#message').html('The Report is Being Saved. Please Wait');                                         
    $(this).hide();

});
$("#dialog").dialog({
    height: 140,
    modal: true
});

});


</script>
<style type="text/css">
input{
    width: 70px;
}
#fixed-alert{
    height: 24px;
    background-color: #EEE;
    color: rgb(255, 166, 166);
    text-shadow: 0.5px 0.51px #949292;
    margin-bottom: 10px;
    position: fixed;
    top: 104px;
    width: 100%;
    padding: 10px 0px 0px 13px;
    border-bottom: 1px solid #ccc;
    font-size: 15px;
    text-align: center;
}
#banner_text{
    margin-top: 30px;
}
#dialog-form{
    margin-top: 30px;
}
</style>

<?php

$attributes = array('name' => 'myform', 'id' => 'myform');
echo form_open('rtk_management/save_lab_report_data', $attributes);

foreach ($facilities as $facility) {
    $id = $facility['id'];
    $facility_name = $facility['facility_name'];
    $facility_code = $facility['facility_code'];
    $district_id = $facility['district'];
    $district = $facility['district_name'];
    $county = $facility['county'];
    $owner = $facility['owner'];
}
$month = date("m", strtotime("Month "));
$year = date("Y", strtotime(" Month "));
$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$lastdate = $year . '-' . $month . '-' . $num_days;
$firstdate = $year . '-' . $month . '-01';

$sql = "select * from lab_commodity_orders where facility_code =$facility_code and order_date between $firstdate and $lastdate";
$res = $this->db->query($sql)->result_array();
$count = count($res);
?>

<div id="dialog-form" title="Enter the lab commodity details here">
    <form>
        <table id="user_order" width="10%" class="data-table">
            <input  type="hidden" name="facility_name" colspan = "3" style = "color:#000; border:none" value="<?php echo $facility_name ?>"></td>
            <input type="hidden" name="facility_code" colspan = "2" style = "color:#000; border:none" value="<?php echo $facility_code ?>"></td>
            <input type="hidden" name="district_name" colspan = "2" style = "color:#000; border:none" value="<?php echo $district ?>"></td>
            <input type="hidden" name="county" colspan = "3" style = "color:#000; border:none" value="<?php echo $county ?>"></td>

            <tr><td style = "text-align:left"><b>Name of Facility:</b></td>
                <td colspan = "2"><?php echo $facility_name ?></td>
                <td rowspan = "8" style="background: #fff;"></td>
                <td colspan = "3"><b>Applicable to HIV Test Kits Only</b></td>
                <td colspan = "2"></td>
                <td colspan = "4" style="text-align:center"><b>Applicable to Malaria Testing Only</b></td>
                <td colspan = "1" rowspan = "8" style="background: #fff;"></td>
            </tr>
            <tr ><td colspan = "2" style = "text-align:left"><b>MFL Code:</b></td>
                <td><?php echo $facility_code ?></td>
                <td colspan = "2" style="text-align:center"><b>Type of Service</b></td>
                <td colspan = "1" style="text-align:center"><b>No. of Tests Done</b></td>
                <td colspan = "2"></td>
                <td colspan = "1"><b>Test</b></td>
                <td colspan = "1"><b>Category</b></td>
                <td colspan = "1"><b>No. of Tests Performed</b></td>
                <td colspan = "1"><b>No. Positive</b></td>                          
            </tr>
            <tr><td colspan = "2" style = "text-align:left"><b>District:</b></td>
                <td><?php echo $district ?></td>
                <td colspan = "2"><b>VCT</b></td>
                <td><input class='user2'class='user2' id="vct" name="vct" colspan = "2" style = "color:#000" value=0></td>
                <td colspan = "2"></td>
                <td rowspan = "3">RDT</td>
                <td style = "text-align:left">Patients&nbsp;<u>under</u> 5&nbsp;years</td>
                <td><input class='user2'id="rdt_under_tests" name="rdt_under_tests" size="10" type="text"/></td>
                <td><input class='user2'id="rdt_under_positive" name="rdt_under_positive" size="10" type="text"/></td>                          

            </tr>
            <tr><td colspan = "2" style = "text-align:left"><b>County:</b></td>                     
                <td><?php echo $county ?></td>
                <td colspan = "2"><b>PITC</b></td>
                <td><input class='user2'class='user2' id="pitc" name="pitc" colspan = "2" style = "color:#000" value=0></td>
                <td colspan = "2"></td>
                <td style = "text-align:left">Patients&nbsp;aged 5-14&nbsp;yrs</td>
                <td><input class='user2'id="rdt_to_tests" name="rdt_to_tests" size="10" type="text"/></td>
                <td><input class='user2'id="rdt_to_positive" name="rdt_to_positive" size="10" type="text"/></td>                        </tr>
                <tr><td colspan = "2" style = "text-align:right"><b>Beginning:</b></td> 
                    <td><input class='my_date'id="begin_date" name="begin_date" colspan = "2" size="10" type="text"/></td>
                    <td colspan = "2"><b>PMTCT</b></td>
                    <td><input class='user2'class='user2' id="pmtct" name="pmtct" colspan = "2" style = "color:#000" value=0></td>
                    <td colspan = "2"></td>
                    <td style = "text-align:left">Patients&nbsp;<u>over</u> 14&nbsp;years</td>
                    <td><input class='user2'id="rdt_over_tests" name="rdt_over_tests" size="10" type="text"/></td>
                    <td><input class='user2'id="rdt_over_positive" name="rdt_over_positive" size="10" type="text"/></td>

                </tr>
                <tr><td colspan = "2" style = "text-align:right"><b>Ending:</b></td>
                    <td><input class='my_date'id="end_date" name="end_date" colspan = "2" size="10" type="text"/></td>
                    <td colspan = "2"><b>Blood&nbsp;Screening</b></td>
                    <td><input class='user2'class='user2' id="blood_screening" name="blood_screening" colspan = "2" style = "color:#000" value=0></td>
                    <td colspan = "2"></td>
                    <td rowspan = "3">Microscopy</td>
                    <td style = "text-align:left">Patients&nbsp;<u>under</u> 5&nbsp;years</td>
                    <td><input class='user2'id="micro_under_tests" name="micro_under_tests" size="10" type="text"/></td>
                    <td><input class='user2'id="micro_under_positive" name="micro_under_positive" size="10" type="text"/></td>                          
                </tr>
                <tr ><td colspan = "3"></td>
                    <td colspan = "2"><b>Other&nbsp;(Please&nbsp;Specify)</b></td>
                    <td><input class='user2'class='user2' id="other2" name="other2" colspan = "2" style = "color:#000" value=0></td>    
                    <td colspan = "2"></td>
                    <td style = "text-align:left">Patients&nbsp;aged 5-14&nbsp;yrs</td>
                    <td><input class='user2'id="micro_to_tests" name="micro_to_tests" size="10" type="text"/></td>
                    <td><input class='user2'id="micro_to_positive" name="micro_to_positive" size="10" type="text"/></td>
                </tr>
                <tr><td colspan = "3"></td>
                    <td colspan = "2"><b>Specify&nbsp;Here:</b></td>
                    <td><input class='user2'class='user2' id="specification" name="specification" colspan = "2" style = "color:#000"></td>  
                    <td colspan = "2"></td>
                    <td style = "text-align:left">Patients&nbsp;<u>over</u> 14&nbsp;years</td>
                    <td><input class='user2'id="micro_over_tests" name="micro_over_tests" size="10" type="text"/></td>
                    <td><input class='user2'id="micro_over_positive" name="micro_over_positive" size="10" type="text"/></td>
                </tr>

                <tr><td colspan = "14"></td></tr>
                <tr >       
                    <td rowspan = "2" colspan = "2"><b>Commodity Name</b></td>
                    <td rowspan = "2"><b>Unit of Issue (e.g. Test)</b></td>
                    <td rowspan = "2"><b>Beginning Balance</b></td>
                    <td rowspan = "2"><b>Quantity Received</b></td>
                    <td rowspan = "2"><b>Quantity Used</b></td>
                    <td rowspan = "2"><b>Number of Tests Done</b></td>
                    <td rowspan = "2"><b>Losses</b></td>
                    <td colspan = "2"><b>Adjustments [indicate if (+) or (-)]</b></td>  
                    <td rowspan = "2"><b>End of Month Physical Count</b></td>
                    <td rowspan = "2"><b>Quantity Expriing in <u>less than</u> 6 Months</b></td>
                    <td rowspan = "2"><b>Days out of Stock</b></td> 
                    <td rowspan = "2"><b>Quantity Requested for&nbsp;Re-Supply</b></td>
                </tr>
                <tr>
                    <td>Positive</td>
                    <td>Negative</td>
                </tr>
                <?php
                $checker = 0;
                foreach ($lab_categories as $lab_category) {
                    ?>
                    <tr>
                        <td colspan = "14" style = "text-align:left"><b><?php echo $lab_category->category_name; ?></b></td>            
                    </tr>
                    <?php foreach ($lab_category->category_lab_commodities as $lab_commodities) { ?>
                    <tr commodity_id="<?php echo $checker ?>"><input type="hidden" id="commodity_id_<?php echo $checker ?>" name="commodity_id[<?php echo $checker ?>]" value="<?php echo $lab_commodities['id']; ?>" >
                        <input type="hidden" id="facilityCode" name="facilityCode">
                        <input type="hidden" id="district" name="district" value="<?php echo $district_id; ?>">
                        <input type="hidden" id="unit_of_issue_<?php echo $checker ?>" name = "unit_of_issue[<?php echo $checker ?>]" value="<?php echo $lab_commodities['unit_of_issue']; ?>">
                        <td colspan = "2" style = "text-align:left"></b><?php echo $lab_commodities['commodity_name']; ?></td>
                        <td style = "color:#000; border:none; text; text-align:center"><?php //echo $lab_commodities['unit_of_issue'];  ?>TESTS</td>
                        <td><input id="b_balance_<?php echo $checker ?>" name = "b_balance[<?php echo $checker ?>]" class='bbal' size="10" type="text" value="0" style = "text-align:center"/></td>
                        <td><input id="q_received_<?php echo $checker ?>" name = "q_received[<?php echo $checker ?>]" class='qty_rcvd' size="10" type="text" value="0" style = "text-align:center"/></td>
                        <td><input id="q_used_<?php echo $checker ?>" name = "q_used[<?php echo $checker ?>]" class='qty_used' size="10" type="text" value="0" style = "text-align:center"/></td>
                        <td><input id="tests_done_<?php echo $checker ?>" name = "tests_done[<?php echo $checker ?>]" class='tests_done' size="10" value="0" type="text" style = "text-align:center"/></td>
                        <td><input id="losses_<?php echo $checker ?>" name = "losses[<?php echo $checker ?>]" class='loses' size="10" type="text" value="0" style = "text-align:center" readonly/></td>
                        <td><input id="pos_adj_<?php echo $checker ?>" name = "pos_adj[<?php echo $checker ?>]" class='pos_adj' size="10" type="text" value="0" style = "text-align:center"/></td>  
                        <td><input id="neg_adj_<?php echo $checker ?>" name = "neg_adj[<?php echo $checker ?>]" class='neg_adj' size="10" type="text" value="0" style = "text-align:center"/></td>
                        <td><input id="physical_count_<?php echo $checker ?>"  name = "physical_count[<?php echo $checker ?>]" class='phys_count' value="0" size="10" type="text" style = "text-align:center"/></td>
                        <td><input id="q_expiring_<?php echo $checker ?>" name = "q_expiring[<?php echo $checker ?>]" class='user2' size="10" type="text" style = "text-align:center"/></td>
                        <td><input id="days_out_of_stock_<?php echo $checker ?>" name = "days_out_of_stock[<?php echo $checker ?>]" class='user2' size="10" type="text" style = "text-align:center"/></td>  
                        <td><input id="q_requested_<?php echo $checker ?>" name = "q_requested[<?php echo $checker ?>]" class='user2' size="10" type="text" style = "text-align:center"/></td>                  
                    </tr>
                    <?php $checker++;
                }
            }
            ?>
            <tr>
                <td colspan = "14"><br/></td>
            </tr>
            <tr>                    
                <td colspan = "14" style = "text-align:left;background: #EEE;">Explain Losses and Adjustments</td>
            </tr>
            <tr>                    
                <td colspan ="14"><input class='user2'id="explanation" name="explanation" size="10" type="text" style="width: 100%"/></td>

            </tr>
            <tr></tr>


            <tr>

                <td colspan = "3" style = "text-align:left"><b>Order for Extra LMIS tools:<br/> To be requested only when your data collection or reporting tools are nearly full. Indicate quantity required for each tool type.</b></td>
                <td><input class='user2'id="order_extra" name="order_extra" size="10" type="text"/></td>
                <td colspan = "4"><b>(1) Daily Activity Register for Laboratory Reagents and Consumables (MOH 642):</b></td>
                <td><input class='user2'id="moh_642" name="moh_642" size="10" type="text"/></td>
                <td colspan = "3"><b>(2) F-CDRR for Laboratory Commodities (MOH 643):</b></td>
                <td colspan = "2"><input class='user2'id="moh_643" name="moh_643" size="10" type="text"/></td>
            </tr>   


            <tr>                    <td colspan = "3" style = "text-align:left">Compiled by:</td>
                <td colspan = "2" style = "text-align:left">Tel:</td>
                <td colspan = "1"></td>
                <td colspan = "2" style = "text-align:left">Designation:</td>
                <td colspan = "1"></td>
                <td colspan = "2" style = "text-align:left">Sign:</td>
                <td colspan = "1"></td>
                <td colspan = "2" style = "text-align:left">Date:</td>
            </tr>
            <tr><td ><input class='user2'id="compiled_by" name="compiled_by" size="10" type="text" colspan = "3"/>
                <span style="color: #f33;font-size: 10px;">* Required Field</span></td>
                <td colspan = "2"><br/></td>
                <td><input class='user2'id="compiled_tel" name="compiled_tel" size="10" type="text" colspan = "2"/></td>
                <td colspan = "1"><br/></td>
                <td colspan = "1"><br/></td>
                <td><input class='user2'id="compiled_des" name="compiled_des" size="10" type="text" colspan = "2"/></td>
                <td colspan = "1"><br/></td>
                <td colspan = "1"><br/></td>
                <td><input class='user2'id="compiled_sign" name="compiled_sign" size="10" type="text" colspan = "2"/></td>
                <td colspan = "1"><br/></td>
                <td colspan = "1"><br/></td>
                <td colspan = "2"><input class='user2'id="compiled_date" name="compiled_date" size="10" type="text" colspan = "2"/></td>
            </tr>

            <tr></tr>

            <tr>                    <td colspan = "3" style = "text-align:left">Approved by:</td>
                <td colspan = "2" style = "text-align:left">Tel:</td>
                <td colspan = "1"><br/></td>
                <td colspan = "2" style = "text-align:left">Designation:</td>
                <td colspan = "1"></td>
                <td colspan = "2" style = "text-align:left">Sign:</td>
                <td colspan = "1"></td>
                <td colspan = "2" style ="text-align:left">Date:</td>
            </tr>
            <tr>                    <td><input class='user2'id="approved_by" name="approved_by" size="10" type="text" colspan = "2"/>
                <span style="color:#f33;font-size: 10px;">* Required Field</span></td>            
                <td colspan = "2"><br/></td>
                <td><input class='user2'id="approved_tel" name="approved_tel" size="10" type="text" colspan = "2"/></td>
                <td colspan = "1"><br/></td>
                <td colspan = "1"><br/></td>
                <td><input class='user2'id="approved_des" name="approved_des" size="10" type="text" colspan = "2"/></td>
                <td colspan = "1"><br/></td>
                <td colspan = "2"><br/></td>
                <td><input class='user2'id="approved_sign" name="approved_sign" size="10" type="text" colspan = "2"/></td>
                <td colspan = "1"><br/></td>                
                <td colspan = "2"><input class='user2'id="approved_date" name="approved_date" size="10" type="text" colspan = "2"/></td>
            </tr>

        </table>
        <div id="message" type="text" style="margin-left: 0%; width:200px;color:blue;font-size:120%"></div>
        <input class="btn btn-primary" type="submit"   id="save1"  value="Save" style="margin-left: 0%; width:100px" >
    </form>
</div>
<br />
<br />
<br />
<br />
<br />


<?php form_close(); ?>

<script type="text/javascript">
$(function(){
    var count = <?php echo $count; ?>;
    if(count==1){
        alert('The Report has already been SUbmitted.');
        window.location('home_controller');
    }
});
$("table").tablecloth({
    bordered: true,
    condensed: true,
    striped: true,            
    clean: true,                
});
</script>

