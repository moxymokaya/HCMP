<script src="<?php echo base_url().'Scripts/accordion.js'?>" type="text/javascript"></script>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT> 
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
    <style type="text/css" title="currentStyle">
      
      @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
    </style>
<script type="text/javascript">
$(document).ready(function(){
	
	$(".ajax_call_1").click(function(){
							var id  = $(this).attr("id"); 
							
							if(id=="county_facility"){
								
  	                         var url= $(this).attr("name"); 
  	
  	                     ajax_request_special (url);
  	                  return;
                        }
	
	});
	
	$("#dialog" ).dialog({
		   autoOpen: false,
            title: "facility Reporting Details",
			height: 650,
			width:900,
			modal: false
		});
		function ajax_request_special (url){
	var url =url;
	 $.ajax({
          type: "POST",
          url: url,
          beforeSend: function() {
            $("#dialog").html("");
          },
          success: function(msg) {       	
        	$('#dialog').html(msg);
            $("#dialog").dialog("open");
          }
        }); 
}
	
	
 
  $("#from,#from_order,#fromcommodity").datepicker({
        defaultDate : "+1w",
        changeMonth : true,
        changeYear : true,
        numberOfMonths : 1,
        onClose : function(selectedDate) {
          $("#to,#to_order,#tocommodity").datepicker("option", "minDate", selectedDate);
        }
      });
      $("#to,#to_order,#tocommodity").datepicker({
        defaultDate : "+1w",
        changeMonth : true,
        changeYear : true,
        numberOfMonths : 1,
        onClose : function(selectedDate) {
          $("#from,#from_order,#fromcommodity").datepicker("option", "maxDate", selectedDate);
        }
      });

  $.fn.slideFadeToggle = function(speed, easing, callback) {
				return this.animate({
					opacity : 'toggle',
					height : 'toggle'
				}, speed, easing, callback);
			};

			$('.accordion').accordion({
				defaultOpen : 'section1',
				cookieName : 'nav',
				speed : 'medium',
				animateOpen : function(elem, opts) {//replace the standard slideUp with custom function
					elem.next().slideFadeToggle(opts.speed);
				},
				animateClose : function(elem, opts) {//replace the standard slideDown with custom function
					elem.next().slideFadeToggle(opts.speed);
				}
			});
       $('#example_main').dataTable( {
          "bJQueryUI": true,
          "bPaginate": false
        } );



    var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/MSColumn2D.swf"?>", "ChartId", "100%", "40%", "0", "0");
    var url = '<?php echo base_url()."rtk_management/generate_malaria_test_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart_1");


    var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Doughnut2D.swf"?>", "ChartId_flash", "100%", "40%", "0", "1");
    var url = '<?php echo base_url()."rtk_management/generate_hiv_test_kits_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart_2");
    
     var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Column2D.swf"?>", "ChartId_flash", "100%", "100%", "0", "1");
    var url = '<?php echo base_url()."rtk_management/generate_hiv_test_kits_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart_3");
           
 $("#input_form").click(function(){
 	
 var report_type=	$("#report").val();
 var facility_code=	$("#facilities").val();
 var url='';
 
 if(report_type== "fcdrr"){
 	url ="<?php echo base_url().'rtk_management/fcdrr_test' ?>";
 	
 	url=url+"/"+facility_code;
 }
 if(report_type== "lab" ){
 	url ="<?php echo base_url().'rtk_management/get_report' ?>";
 	url=url+"/"+facility_code;
 	
 	 }
 
 if(facility_code !=""){
 	window.open(url);
 }
 	
 	});     


    
$(".ajax-call").click(function(){
var id  = $(this).attr("id"); 

  if(id=="fcdrr"){
  	var url = "<?php echo base_url().'rtk_management/get_report/fcdrr' ?>";
  }
  if(id=="lab_commodities"){
  	var url = "<?php echo base_url().'rtk_management/get_report/lab_commodities' ?>";
  }
   
  
  

  ajax_request (url);
    
});
function ajax_request (url){
	var url =url;
	var loading_icon="<?php echo base_url().'Images/loader.gif' ?>";
	 $.ajax({
          type: "POST",
          url: url,
          beforeSend: function() {
            $("#test_a").html("");
            
             $("#test_a").html("<img style='margin-left:20%;' src="+loading_icon+">");
            
          },
          success: function(msg) {
          $("#test_a").html("");
           $("#test_a").html(msg);           
          }
        }); 
}


});
</script>
<style>
.leftpanel{
    	width: 17%;
    	height:auto;
    	float: left;
    }

.alerts{
	width:95%;
	height:auto;
	background: #E3E4FA;	
	padding-bottom: 2px;
	padding-left: 2px;
	margin-left:0.5em;
	-webkit-box-shadow: 0 8px 6px -6px black;
	   -moz-box-shadow: 0 8px 6px -6px black;
	        box-shadow: 0 8px 6px -6px black;
	
}
    
    .dash_menu{
    width: 100%;
    float: left;
    height:auto; 
    -webkit-box-shadow: 2px 3px 5px#888;
	box-shadow: 2px 3px 5px #888; 
	margin-bottom:3.2em; 
    }
    
    .dash_main{
    width: 80%;
   min-height:100%;
height:600px;
    float: left;
    -webkit-box-shadow: 2px 2px 6px #888;
	box-shadow: 2px 2px 6px #888; 
    margin-left:0.75em;
    margin-bottom:0em;
    
    }
    .dash_notify{
    width: 15.85%;
    float: left;
    padding-left: 2px;
    height:450px;
    margin-left:8px;
    -webkit-box-shadow: 2px 2px 6px #888;
	box-shadow: 2px 2px 6px #888;
    
    }
    
#accordion {
    width: 300px;
    margin: 50px auto;
    float:left;
    margin-left:0.45em;
}
.collapsible,
.page_collapsible,
.accordion {
    margin: 0;
    padding:5%;
    height:15px;
    border-top:#f0f0f0 1px solid;
    background: #cccccc;
    font:normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;
    text-decoration:none;
    text-transform:uppercase;
	  background: #29527b; /* Old browsers */
     border-radius: 0.5em;
     color: #fff; }
.accordion-open,
.collapse-open {
	background: #289909; /* Old browsers */    
    color: #fff; }
.accordion-open span,
.collapse-open span {
    display:block;
    float:right;
    padding:10px; }
.accordion-open span,
.collapse-open span {
    background:url('<?php echo base_url()?>Images/minus.jpg') center center no-repeat; }
.accordion-close span,
.collapse-close span {
    display:block;
    float:right;
    background:url('<?php echo base_url()?>Images/plus.jpg') center center no-repeat;
    padding:10px; }
div.container {
    width:auto;
    height:auto;
    padding:0;
    margin:0; }
div.content {
    background:#f0f0f0;
    margin: 0;
    padding:10px;
    font-size:.9em;
    line-height:1.5em;
    font-family:"Helvetica Neue", Arial, Helvetica, Geneva, sans-serif; }
div.content ul, div.content p {
    padding:0;
    margin:0;
    padding:3px; }
div.content ul li {
    list-style-position:inside;
    line-height:25px; }
div.content ul li a {
    color:#555555; }
code {
    overflow:auto; }
.accordion h3.collapse-open {}
.accordion h3.collapse-close {}
.accordion h3.collapse-open span {}
.accordion h3.collapse-close span {}   
</style>



<div class="leftpanel">
<div id="dialog"></div> 
<div class="dash_menu">
 
  <h3 class="accordion" >Reports <span></span><h3>
<div class="container">
	
   <div class="content">
    <select id="facilities" class="dropdownsize">
    <option>--Select Facility--</option>
        <?php 
        foreach ($facilities as $counties) {
            $facility_code=$counties['facility_code'];
            $facility_name=$counties['facility_name'];
            
            ?>
            <option value="<?php echo $facility_code;?>">   <?php echo $facility_name;?></option>
        <?php }
        ?>
    </select>   
  <input  type="hidden"  name="facilities" id="facilities" value="<?php echo $facility_name;?>" />

<select id="report" class="dropdownsize">
    <option>--Select Report--</option>
    <option value="fcdrr">FCDRR</option>
  <option value="lab">LAB COMMODITIES</option>
        
    </select>   
  <input  type="hidden"  type="submit" value="Submit" />

  
  <h2>Select Month</h2>
  <input type="text" size="10"  value="" id="from" placeholder="Month" />
  <input type="hidden"  value="" id="facilitycode" name="facilitycode" />
  	
    	
    <button class="awesome blue" id="input_form"  align="left">Generate Report</button>
  </div>
</div>

</div>

	
</div>

<div class="dash_main" id = "dash_main">



<div id="test_a" style="overflow: scroll; height: 51em; min-height:100%; margin: 0; width: 100%">
  <div>
      <div id="chart_1"   style="float:left;width: 50%; height: 100%"></div>
      <div id="chart_2" style="float:left; width: 50%; height: 100%" ></div>

 </div>
  <div id="chart_3" style="float:left; width: 100%; height: 50%" ></div>
<?php $district=$this->session->userdata('district1');
      $district_name=Districts::get_district_name($district);
      $d_name=$district_name[0]['district']; ?>
      <?php if(isset($popout)){ ?><div id="dialog" title="System Message"><p><?php echo $popout;?></p></div><?php }?>

   <p id="notification" >RTK Facilities in <?php echo $d_name ?> District</p>
       <div style="float:left;"><img src="<?php echo base_url().'/Images/check_mark_resize.png'?>"></img>
        <p id="notification">A check mark indicates that that report has been submitted for that facility within the past month</p>
      </div>
            <table  style="margin-left: 0;" id="example_main" width="100%" >
          <thead>
          <tr>
            <th><b>MFL Code</b></th>
            <th><b>Facility Name</b></th>
            <th><b>Owner</b></th>
            <th ><b>Actions&nbsp;on&nbsp;RTK&nbsp;Reports&nbsp;</b></th> 
                        
          </tr>
          </thead>
          <tbody>
    <?php echo $table_body; ?>
              
        </tbody>            
        </table>

    </div>
    </div>

</div>



