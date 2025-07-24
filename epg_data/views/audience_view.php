 
  		
  <style> 
      .grandItemTit {
          color: #cc3300; 
          font-size: 22px;
      }
                
      .grandItemCon {
          color: #000000; 
          font-size: 26px;
      }
                
      .buttonExcel {
          float: right;
      }           
          
      .dt-buttons{
          height: 40px;
      }
      
      .dt-button{
        	position:relative;
        	left: 1%;
        	background-color: transparent;
        	color: #cb3827;
        	border-radius: 30px;
        	border: 1px solid #cb3827;
        	padding: 6px;
        	padding-left: 30px;
        	padding-right: 30px;
        	top: 13px;
      } 
      
      table.dataTable thead .sorting_desc::after {
          content: "";
      }
      table.dataTable thead .sorting_asc::after {
          content: "";
      }
      table.dataTable thead .sorting::after {
          content: "";
      }                
      
      .table > thead > tr > th > img {
        width: 16px;
        float: right;
      }
	</style>        
	
	<!-- Styles -->
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/layout.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/buttons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/stats.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/ionicons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/video-thumbnail.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/panel.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/box-profile.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tag.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/forms.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/modal.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/action-dropdown.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/checkbox.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/tree-list.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/alert.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/scrollbar.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $path;?>assets/css/helix-profiling.css">

  <!-- Multi Select Css -->
  <link href="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/themes/default/style.min.css" rel="stylesheet">	
	
  <!-- Multi Select Plugin Js -->
  <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/dist/jstree.min.js"></script>
  <script src="<?php echo base_url();?>assets/vakata-jstree-9770c67/src/jstree.search.js"></script>
	
  <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>assets/vendors/jstree/themes/default/style.min.css">   
  <!-- Viswitch -->
	<link rel="stylesheet" href="<?php echo $path ;?>assets/css/viswitch.css">
	<!-- Timepicker -->
	<link rel="stylesheet" href="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.css">
	
	<link href="<?php echo $path;?>assets/ext/select2.min.css" rel="stylesheet" />
<script src="<?php echo $path;?>assets/ext/select2.min.js"></script>
  
	<div class="content-wrapper">
      <div class="container-fluid">  
          <div class="row">
              <div class="col-md-6">
                
                  <h3 class="page-title-inner">EPG Data</h3>
              </div>     
					  
          </div>
         
		  
		   <div class="loader" id="loader" style="display:none">
                 <img alt="img" class="gambar" src="<?php echo $path; ?>assets/images/icon_loader.gif">
            </div>

		   <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">EPG Data</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('channel')" class="button_white" id="filter_channel"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
					</div>
				</div>

                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_channel" style="display:none">	
					
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						<div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Period</label>
									<input type="text"  class="form-control" name="start_date" id="start_date" placeholder="From ..." style="text-align:left" value="">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>End Date Period</label>
									<input type="text" class="form-control" name="end_date" id="end_date" placeholder="To ..." style="text-align:left" value="">
								</div>
							</div>
							
							<div class="col-lg-6" >
								<div class="form-group">
									<label>Channel</label>
									<div class="select-wrapper">
									  <select class="urate-select grid-menu" name="get_chnl" id="get_chnl" title="Please choose a Channel..." required>
										<option value="0" >All Channel</option>
										<?php $i = 0; foreach($channels as $key) { ?>
										<option value="<?php echo $key['CHANNEL_CDR']; ?>" ><?php echo $key['CHANNEL_CDR']; ?></option>
										<?php } ?>
									  </select>
								  </div>
								</div>
							</div>

							
					</div>
						
					</div>
					
					
					<div class="col-lg-12" style="margin-top:25px">	
					
					<div id="table_program2" style="margin-top:10px">
						<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">Channel </th>
									<th scope="row">Program </th>
									<th scope="row">Begin Program </th>
									<th scope="row">End Program </th>
									<th scope="row">Genre Program </th>
									<th scope="row">last Update </th>
								</tr>

							</thead>
						</table>
					</div>
					
					</div>
                 </div>
            </div>
          </div>
		  
		  <div class="grid-stack-item" data-gs-min-width="6" data-gs-min-height="1" data-gs-x="3" data-gs-y="0" data-gs-width="12" data-gs-height="2"
            data-gs-auto-position="1">
            <div class="panel urate-panel row" style="border:1px solid #efefef;padding:10px;margin:10px;border-radius: 25px;">
				<div class="col-lg-12">	
					<div class="navbar-left" style="padding-left:10px;">
					  <h4 class="title-periode1" style="font-weight: bold;">EPG Load History</h4>
					</div>
					 <div class="navbar-right" style="padding-right:40px;padding-top:10px;">
						<button onClick="filter_panel('load')" class="button_white" id="filter_load"><em class="fa fa-filter"></em> &nbsp Show Filter</button>
					</div>
				</div>

                <div class="widget-content">
					<div class="col-lg-12 filter_panel" id="filter_panel_load" style="display:none">	
					
						<div class="col-lg-12">	
							<div class="navbar-left">
								<h6 class="" style="font-weight: bold;">Filter</h6>
							</div>
							 <div class="navbar-right" style="padding:10px" >
								<button onClick="audiencebar_view_file()" class="button_red">Apply Filter</button>
							 </div>
						 </div>
						<div class="col-lg-12">	
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>Start Date Period</label>
									<input type="text"  class="form-control" name="start_date2" id="start_date2" placeholder="From ..." style="text-align:left" value="">
								</div>
							</div>
							<div class="col-lg-3">	
								<div class="form-group input-daterange">
									<label>End Date Period</label>
									<input type="text" class="form-control" name="end_date2" id="end_date2" placeholder="To ..." style="text-align:left" value="">
								</div>
							</div>
							
					</div>
						
					</div>
					
					
					<div class="col-lg-12" style="margin-top:25px">	
					
					<div id="table_program3" style="margin-top:10px">
						<table aria-describedby="table" id="example42" class="table table-striped example" style="width: 100%">
							<thead style="color:red">
								<tr>
									<th scope="row">File Name </th>
									<th scope="row">Channel </th>
									<th scope="row">Upload Date </th>
									<th scope="row">Process Date </th>
									<th scope="row">PIC </th>
								</tr>

							</thead>
						</table>
					</div>
					
					</div>
                 </div>
            </div>
          </div>
		  
      </div>
  </div>   



<!-- Modal New Profile -->

  
  <!-- Forms (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/forms_sig.js"></script>
  <!-- Tables (in general) -->
  <script type="text/javascript" src="<?php echo $path; ?>assets/js/table.js"></script>
  <!-- Bootstrap Datepicker -->
  <script language="javascript" src="<?php echo $path;?>assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Timepicker -->
  <script language="javascript" src="<?php echo $path; ?>assets/vendors/timepicker-master/jquery.timepicker.js"></script>
  <!-- Cookie -->
    
  <!-- Highcharts -->
	<script src="<?php echo $path5;?>plugins/highcharts/highcharts.js"></script>
  
  <script language="javascript">
  
  function filter_panel(part){
	
	if ($('#filter_panel_'+part).is(':visible')) {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Show Filter');
	} else {
		 $('#filter_'+part).html('<em class="fa fa-filter"></em> &nbsp Hide Filter');
	}

	$('#filter_panel_'+part).slideToggle(500);
	
}
  
      function create_daypart(){       
        $(".modal .modal-footer button").hide();           
        $('#loaderdp').show();
                
        var from = $('#from').val();
        var to = $('#to').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token");
        
        var dpart_list = ""; 
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'tvcc/setdaypart/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&f=" + from +"&t=" + to,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
 				dpart_list += '<li data-for="daypart"><a href="#" data-real="ALL" data-id="daypart">ALL DAYS</a></li>';
                for(i=0; i < response.length; i++){
                    dpart_list += '<li data-for="daypart"><a href="#" data-real="'+response[i].DPART+'" data-id="daypart">'+response[i].DPART+'</a></li>';
                }
                
                $("#custom_daypart").next().html(dpart_list);
                
                $("#modalNewTime").modal('toggle');                      
          
                $('[data-for="daypart"]').on('click',function(){
                     $('#custom_daypart').html($(this).children().data('real'));
                    $(this).closest('.urate-select-dropdown').find('.hidden-element-for-dropdown').attr('value', $(this).children().data('real'));
                });
				
				 $('#loaderdp').hide();
				 $(".modal .modal-footer button").show();
				 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        });
    }   
  
  
         var optVal1 = [];
        var tempVal1 = [];
        var optVal = [];
        var tempVal = [];
		var crcroptVal1 = [];
		var crcrtempVal1 = [];
		var croptVal = [];
		var crtempVal = [];
		var crfavdata = [];
		var crstar = 0;
	    var crnewdata = [];
		

	

	

			  
		
							
							function arraypush(datas){
	crnewdata = [];
	 crnewdata = datas;
}
  
      $(document).ready(function(){ 

	
	var table345 = $('#example4').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
	});		
	
	var table345 = $('#example42').DataTable({
		"bFilter": false,
		"aaSorting": [],
		"bLengthChange": false,
		'iDisplayLength': 10,
		"sPaginationType": "simple_numbers",
		"Info" : false,
	});	
 	
							
							
							
			  
	  
          $('.input-daterange input').each(function() {
              $(this).datepicker({
                  format: 'dd/mm/yyyy',
                  defaultDate: new Date()
              });                     
              
              $(this).val("<?php echo date('d/m/Y') ?>");
          });
 
          var table = $("#myTable").DataTable({ 
      				"ordering": false,		
      				"bFilter" : false,
      				"bInfo" : false,	
      				"bLengthChange": false,
      				"responsive": true
        	});		 
          
               
          
          $('#custom_channel').click(function() {   
              $(".search-channel-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeyup='search_channel()' paceholder='Search Channel'></div>"; 
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();
                  $("#custom_channel").after(searchElement);   
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
          }); 

		  
      });
      
      $(document).ready(function(){
		  
		  audiencebar_view_file();
		  audiencebar_view();
		  
		   $('.urate-custom-menu > li > a').on('click',function(){
              if($(this).data('real') == "0" || $(this).data('real') == "1" ){
                  $('[data-for = "'+$(this).data('id')+'"]').each(function(){
                      $(this).removeClass('checked');
                  });
              }
              
              if($(this).data('real') != "0"){
                  $('[data-real = "0"]').parent().removeClass('checked');
              }
              if($(this).data('real') != "1"){
                  $('[data-real = "1"]').parent().removeClass('checked');
              }
          });
 
	  
	        $('#from').timepicker({
              timeFormat: 'HH:mm',
              interval: 30,
              minTime: '00:00',
              maxTime: '23:59',
               startTime: '00:00',
              dynamic: false,
              dropdown: true,
              scrollbar: true,
              zindex: 9999               
			  ,change: function(time){
                  if($('#from').val() == ""){
                      $('#from').val("00:00");
                  }
                  
                  $.ajax({
                      type	: "POST",
                      url		: "<?php echo base_url().'msbc/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
                       dataType: 'json',
                      contentType: 'application/json; charset=utf-8',
                      success	: function(response) {
                          if(response['data'].hasil == "1"){
                              $(".dayPartMsg").html("Day part is already exist, choose another Day part.");
                              $(".daypart_create").attr("disabled","disabled");
                          } else {
                              if($('#to').val() <= $('#from').val()){ 
                                  $(".dayPartMsg").html("The end time must be greater than the start time!");
                                  $(".daypart_create").attr("disabled","disabled");
                              } else {
                                  $(".dayPartMsg").html("");
                                  $(".daypart_create").removeAttr("disabled");
                              }
                          }                                                      
                      }, error: function(obj, response) {
                          console.log('ajax list detail error:' + response);	
                      } 
                  });  
              }

          });    
		  
		  
		  $('#to').timepicker({
              timeFormat: 'HH:mm',
              interval: 30,
              minTime: '00:29',
              maxTime: '23:59',
               startTime: '00:29',
              dynamic: false,
              dropdown: true,
              scrollbar: true,
              zindex: 9999               
			  ,change: function(time){
                  if($('#from').val() == ""){
                      $('#from').val("00:00");
                  }
                  
                  $.ajax({
                      type	: "POST",
                      url		: "<?php echo base_url().'msbc/checkdaypart/'; ?>"+"?f="+$('#from').val()+"&t="+$('#to').val(),
                       dataType: 'json',
                      contentType: 'application/json; charset=utf-8',
                      success	: function(response) {
                          if(response['data'].hasil == "1"){
                              $(".dayPartMsg").html("Day part is already exist, choose another Day part.");
                              $(".daypart_create").attr("disabled","disabled");
                          } else {
                              if($('#to').val() <= $('#from').val()){ 
                                  $(".dayPartMsg").html("The end time must be greater than the start time!");
                                  $(".daypart_create").attr("disabled","disabled");
                              } else {
                                  $(".dayPartMsg").html("");
                                  $(".daypart_create").removeAttr("disabled");
                              }
                          }                                                      
                      }, error: function(obj, response) {
                          console.log('ajax list detail error:' + response);	
                      } 
                  });  
              }

          });
		  
		  
          $("#custom_programsss").on("click",function(){  
              $(".search-channel-con").remove();
              $("#custom_channel").parent().removeClass('active');
          });
          
          $('#custom_channel').click(function() {   
              $("#custom_programsss").parent().removeClass('active');
              $(".search-con").remove();
              
              var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid;' class='search-channel-con'><input type='text' name='search_channel' id='search_channel' class='form-control urate-form-input' value='' onkeypress='search_channel()' paceholder='Search Channel'></div>";
              
              if($(this).parent().hasClass('active')){
                  $(".search-channel-con").remove();     
                  $("#custom_channel").after(searchElement);     
                  $("#search_channel").focus();
              } else {
                  $(".search-channel-con").remove();
              }
                  
               $("[data-id='channel']").click(function(){    	     
 
                  $('#programsss').next().text('Please Choose Program ...');
                  $('#programsss').next().next().html(' ');
                  
                  var chnl = $(this).data("real");
                  var datesel = $("#start_date").val();
				  var dateend = $("#end_date").val(); 
                  var profile = $("#profile").val();
                  
                  $(".search-channel-con").remove();
                  $(".search-con").remove(); 
                  
                  generate_program(chnl,datesel,dateend,profile);
              });
          });
          
          $("#custom_programsss").on("click",function(){
              $("#custom_channel").parent().removeClass('active');
          }); 
      });   
	  
	  
	    
	  function audiencebar_view_file(){
		  
		  var form_data = new FormData();  
			var start_date = $('#start_date2').val();
			var end_date = $('#end_date2').val();
			
			form_data.append('start_date', start_date);
			form_data.append('end_date', end_date);
			
			$.ajax({
				url: "<?php echo base_url().'epg_data/audiencebar_by_channel_file'; ?>", 
				dataType: 'text',   
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(data){
			
			
				$('#table_program3').html('<table aria-describedby="table" id="example42" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th scope="row">File Name </th><th scope="row">Channel </th><th scope="row">Upload Date </th><th scope="row">Process Date </th><th scope="row">PIC </th></tr></thead></table>');
			
				obj = jQuery.parseJSON(data);
			
				$('#example42').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 10,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					
					"searching": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: obj,
					columns: [
						{ data: 'FILENAME' },
						{ data: 'CHN' },
						{ data: 'UPLOAD_DATE' },
						{ data: 'PROCESS_DATE' },
						{ data: 'PIC' }
					]
				});	
				
				}
			});	
			
	  }
	  
	  function audiencebar_view(){
		  
			var form_data = new FormData();  
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			var get_chnl = $('#get_chnl').val();
		  
			form_data.append('start_date', start_date);
			form_data.append('end_date', end_date);
			form_data.append('get_chnl', get_chnl);
			
			$("#example4_wrapper").append('<div class="datatable-loading" style="position: absolute; background-color: rgb(255, 255, 255); opacity: 0.75; text-align: center; z-index: 10; left: 0px; top: 0px; width: 100%; height: 520px;"><span class="datatable-loading-inner" style="font-weight: bold; position: relative; top: 45%;"><img alt="image" id="loading" src="<?php echo base_url();?>assets/urate-frontend-master/assets/images/icon_loader.gif"></span></div>');
			
			
			$.ajax({
				url: "<?php echo base_url().'epg_data/audiencebar_by_channel'; ?>", 
				dataType: 'text',   
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(data){
			
			
				$('#table_program2').html('<table aria-describedby="table" id="example4" class="table table-striped example" style="width: 100%"><thead style="color:red"><tr><th scope="row">Channel </th><th scope="row">Program </th><th scope="row">Begin Program </th><th scope="row">End Program </th><th scope="row">Genre Program </th><th scope="row">last Update </th></tr></thead></table>');
			
				obj = jQuery.parseJSON(data);
			
				$('#example4').DataTable({
					"bFilter": false,
					"aaSorting": [],
					"bLengthChange": false,
					'iDisplayLength': 10,
					"sPaginationType": "simple_numbers",
					"Info" : false,
					
					"searching": true,
					"language": {
						"decimal": ",",
						"thousands": "."
					},
					data: obj,
					columns: [
						{ data: 'CHANNEL' },
						{ data: 'PROGRAM' },
						{ data: 'BEGIN_PROGRAM' },
						{ data: 'END_PROGRAM' },
						{ data: 'GENRE_PROGRAM' },
						{ data: 'DATES' }
					]
				});	
				
				}
			});	
			
	  }
	  
	  
	  function select_profile(){
		  
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
		  var id_profile = $('#profile').val();
 		  
		  var form_data = {			
              id_profile : id_profile
          };    
		  
		  if(id_profile == 0){
			  
			$('#listcr').empty();
			$('#list_1').empty();
			$("#box_tree").css({'pointer-events':'auto'}); 

			  
		  }else{
			  
			   $.ajax({
				  type	: "POST",
				  url		: "<?php echo base_url().'epg_data/list_tree_profile/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
				  data	: JSON.stringify(form_data),			
				  dataType: 'json',
				  contentType: 'application/json; charset=utf-8',
				  success	: function(response) { 
				  
						
						  $('#listcr').empty();
						  $('#list_1').empty();
						 
 						$("#box_tree").css({'pointer-events':'none'}); 
						
						
						obj = response['data'];
 						
						 var dd = [];
							  var ddf = [];
							  var ddsh = [];
							  var text = '';
							 
							 var crnewdata = obj;
							for(var i = 0; i < crnewdata.length; i++){
								 var ss = crnewdata[i].split("_");
                                  
                                  if(ss[0].length > 2 ){
                                      var ssa = crnewdata[i].split("=");
                                      dd.push(ssa);
                                      ddf.push(ssa);
                                  }else{
                                      
                                  }
																	
							  };
							  
							   dd.forEach(function(entry, index) {
                                   
                                   ddsh.push(entry[1]);
                                  
                                  
                                        $("#profile_"+index).change(function() {
                                            $("#profile_"+index+" option").each(function() {
                                                var val = $(this).val();
                                                var crcrtempVal1 = $("#profile_"+index).val();

                                                if(crcrtempVal1.indexOf(val) >= 0 && crcroptVal1.indexOf(val) < 0) {
                                                    crcroptVal1.push(val);
                                                } else if(crcrtempVal1.indexOf(val) < 0 && crcroptVal1.indexOf(val) >= 0) {
                                                    crcroptVal1.splice(crcroptVal1.indexOf(val) , 1);
                                                }

                                            })
 
                                        });
                              }); 

							var uniqueNames = [];
                            $.each(ddsh, function(i, el){
                                if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
                            });
 
                                var texta;
                                
							  uniqueNames.forEach(function(datas, index) {
                                  var ix = index;
                                  if(datas != "undefined"){
                                     text ='<h3 id="crstar_'+datas+'">'+datas+'</h3><span id="anak_'+index+'"></span>';
                                      $('#listcr').append(text);
                                      $('#list_1').append(text);
                                      ddf.forEach(function(entry, index) {

                                          if(datas == entry[1]){
                                             texta = "<span  id='"+entry[1]+"'>"+entry[0]+"</span>, ";
                                              $('#anak_'+ix).append(texta);
                                          }


                                      });
                                     }
                                  
                                  
							  });		

								arraypush(crnewdata);
						
 
				  
				  }, error: function(obj, response) {
					  console.log('ajax list detail error:' + response);	
				  } 
			  });    
		  
		  }
				  
 
	  }
          
      function generate_program (channel, sdate,dateend, sprofile){
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
                  
          $('#programsss').empty('');
          
          var form_data = {			
              valselect : channel,
              dateselect : sdate,
              dateend : dateend
          };                                                                                                    
          var strVar = "";  
          
          $.ajax({
              type	: "POST",
              url		: "<?php echo base_url().'epg_data/list_program/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token,
              data	: JSON.stringify(form_data),			
              dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                  //console.log(response.data.success);
                  if(response.data != undefined){    
                      $('#custom_programsss').hide();
                      $('#loader2').fadeIn(500).delay(1500).fadeOut(500);
                      $('#custom_programsss').delay(3000).fadeIn(500);
              
                      var searchElement = "<div style='padding: 10px; border-left: 1px solid; border-right: 1px solid;' class='search-con'><input type='text' name='search_program' id='search_program' class='form-control urate-form-input' value='' onkeypress='search_program()' paceholder='Search Program'></div>";
                      
                      $("#custom_programsss").on("click",function(){
                          $("#custom_channel").parent().removeClass('active');
                          
                          if($(this).parent().hasClass('active')){  
                              $(".search-channel-con").remove();
                              $(".search-con").remove();
                              $("#custom_programsss").after(searchElement);         
                              $("#search_program").focus();
                          } else {
                              $(".search-con").remove();
                          }
                      }); 
                       
    				   strVar += "<li><a href='javascript:void(0)' data-real='ALL,ALL' class='urate-select-form-two' data-for='programsss'>ALL</a></li>"
    				   
					   if(sdate == dateend){
						  for(i=0; i < response.data.length; i++){

							  strVar += "<li><a href='javascript:void(0)' data-real='"+response.data[i].PROGRAM+"' class='urate-select-form-two' data-for='programsss'>"+response.data[i].PROGRAM+"</a></li>";                          
						  } 
					   }else{
						     for(i=0; i < response.data.length; i++){

								strVar += "<li><a href='javascript:void(0)' data-real='"+response.data[i].PROGRAM+"' class='urate-select-form-two' data-for='programsss'>"+response.data[i].PROGRAM+"</a></li>";                             
							} 
					   }
                                             
                      $("#programsss").next().next().html(strVar);
                                        
                      $('[data-for = "programsss"]').click(function() { 
                          $('#programsss').next().text($(this).data("real"));
                          $('#programsss').attr('value',$(this).data("real"));
                          
                          $(this).closest('.default').removeClass('active');
                      
                          $(".search-con").remove();      
                                                            
                          if($(this).closest('.urate-select-dropdown').hasClass('active')){
                              $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                          } else {
                              $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                          }                         
                      });                 
                  } else {
					  strVar += "<li><a href='javascript:void(0)' data-real='ALL,ALL' class='urate-select-form-two' data-for='programsss'>ALL</a></li>"
                      $("#programsss").next().next().html(strVar);
					  
					  
					     $('[data-for = "programsss"]').click(function() { 
                          $('#programsss').next().text($(this).data("real"));
                          $('#programsss').attr('value',$(this).data("real"));
                          
                          $(this).closest('.default').removeClass('active');
                      
                          $(".search-con").remove();      
                                                            
                          if($(this).closest('.urate-select-dropdown').hasClass('active')){
                              $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                          } else {
                              $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                          }                         
                      });                 
                  }                             
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          });     
      }
      
      function search(){                                    
          $('[data-for="channel"]').parent().parent().removeClass("active");
          $('[data-for="profile"]').parent().parent().removeClass("active");
          $('[data-for="programsss"]').parent().parent().removeClass("active");  
          $(".search-channel-con").remove();
          
          var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          var profile = $('#profile').val();
           var channel = $('#get_chnl').val(); 
          var program = "ALL,ALL";
          var daypart = $('#daypart').val();
          var dataf = $('#dataf').val();
          var dataf2 = $('#dataf2').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");     
		  
          
          var colgroup = "tvr"; 
          
          var orderingnya = '0';	
          var by = '';	
          
          $('input.toggle-vis').attr('disabled','disabled');
          
          if(start_date === ''){  
              alert('Please, Select Start Date');
              return false;
          }	           
          
          if(profile === null || profile === ''){  
        			alert('Please, Select Profile');
        			return false;
        	} 	
        	
        	if(dataf === null || dataf === ''){  
        			alert('Please, Select Data');
        			return false;
        	} 	
			
			myArray = channel.split(",");
			
        	if(dataf2 === 'one' && (channel === '0' || channel === '1' || myArray.length > 5 )){  
        			alert('For Single Data, Maximum 5 Channels Selected !');
        			return false;
        	} 	
			
 
			$('.urate-panel-results').show();
			$('#panel-blank').hide();
						  $('#profileButton').hide();
 						  $('#loader').show();
          
 			
			
                    var form_data = {
                        list		 : crnewdata,
                        end_date		 : end_date,
                        start_date		 : start_date,
                        profile		 : profile,
                        channel		 : channel,
                        program		 : program,
                        user_id		 : user_id,
                        token		 : token,
                        dataf		 : dataf,
                        dataf2		 : dataf2,
                        daypart		 : daypart
                      
                    }
					
					var urls = "<?php echo base_url();?>epg_data/cr_pp" + "?sess_user_id=" + user_id + "&sess_token=" + token;
					
					 $.ajax({ 
                        type: "POST",
                        url: urls,
                        data: JSON.stringify(form_data),
                         dataType: 'json',
                        contentType: 'application/json; charset=utf-8'
                    }).done(function(response) {
						  
						  $('.urate-panel-results').show();
							$('#panel-blank').hide();
			
							const myJSON = JSON.stringify(response.data['data']);
							const myJSON_sp = JSON.stringify(response.data['data_split']);

						  $('#body_tbl').html(response.data['table']);
						 
						
						
						
						 $('#example_data').DataTable({
							"bLengthChange": false,
							searching: false,
		 
						});
						 
						 obj =response.data['data'];
						 obj_2 =response.data['dataW'];
						 obj_3 =response.data['data_split'];
						 obj_4 =response.data['data_weekend'];
						 
	 
						 
						 if(dataf = 'days'){
							 
							  if(dataf2 == 'summary'){
							 
								//create_chart_day(obj,obj_2);
								 $('#value_data').val(myJSON);
							 
							 }else{
								// create_chart_split_day(obj_4,channel);
								  $('#value_data').val(myJSON_sp);
							 }
							 
						 }else{
						 
							 if(dataf2 == 'summary'){
							 
								//create_chart(obj,obj_2);
								 $('#value_data').val(myJSON);
							 
							 }else{
								 //create_chart_split(obj_3,channel);
								  $('#value_data').val(myJSON_sp);
							 }
						 
						 }
						
						 $('#processButton').delay(1000).fadeIn();
						 $('#profileButton').delay(1000).fadeIn();
						  $("#loader").hide();
						 $('.loader').css('display','none');
						 $('#button_filters').show();
						 $('#profileButton').show();
 
					
					 }).fail(function(xhr, status, message) {
                        $("#laod").empty();
                        $('#savecr').show();
                    });
           

      }             

		function tab_filter(tabs){
	
			if(tabs == 'chart'){
			
				$('#tab_table').css('background-color','#F2F2F2');
				$('#tabs_table').css('background-color','#F2F2F2');
				$('#tab_chart').css('background-color','#fff');
				$('#tabs_chart').css('background-color','#fff');
			
			}else{
				
				$('#tab_table').css('background-color','#fff');
				$('#tabs_table').css('background-color','#fff');
				$('#tab_chart').css('background-color','#F2F2F2');
				$('#tabs_chart').css('background-color','#F2F2F2');
				
			
			}
			
		 }

	function export_aud(ads){
		
		var form_data = new FormData();  
		form_data.append('ads', ads);
		
		
		$.ajax({
			url: "<?php echo base_url().'epg_data/audience_export'; ?>", 
			dataType: 'text',   
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Audience_export.xls','Audience_export.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
		
 		
	}
	
	
	function exports(){
		
		var form_data = new FormData();  
		form_data.append('data', $('#value_data').val());
		form_data.append('dataf', $('#dataf').val());
		form_data.append('dataf2', $('#dataf2').val());
		form_data.append('channel', $('#get_chnl').val());
		
		$.ajax({
			url: "<?php echo base_url().'epg_data/audience_export'; ?>", 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(data){
				
				download_file('<?php echo $donwload_base; ?>tmp_doc/Daypart_export.xls','Daypart_export.xls');
									
			}, error: function(obj, response) {
				console.log('ajax list detail error:' + response);	
			} 
		});	
		
 		
	}
	
		function download_file(fileURL, fileName) {
    // for non-IE
    if (!window.ActiveXObject) {
        var save = document.createElement('a');
        save.href = fileURL;
        save.target = '_target';
        var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
        save.download = fileName || filename;
	       if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
				document.location = save.href; 
// window event not working here
			}else{
		        var evt = new MouseEvent('click', {
		            'view': window,
		            'bubbles': true,
		            'cancelable': false
		        });
		        save.dispatchEvent(evt);
		        (window.URL || window.webkitURL).revokeObjectURL(save.href);
			}	
    }

    // for IE < 11
    else if ( !! window.ActiveXObject && document.execCommand)     {
        var _window = window.open(fileURL, '_blank');
        _window.document.close();
        _window.document.execCommand('SaveAs', true, fileName || fileURL)
        _window.close();
    }
}


	function create_chart_split_day(data,channel){
			
			myArray = channel.split(",");

		console.log(data);
		 
 			 
		$('#chart').html('');


			$('#chart').append('<div class="col-md-12" style="margin-bottom:10px;"> <div id="container" style="width: 1200px; margin: 0 auto"></div></div>');
			
			 var ssss = data[1]['label'];
 
			  var tv1tgl = [];
			  var tv1data = [];    
			  var tv1data1 = [];    
			  var tv1data2 = [];    
			  var tv1data3 = [];    
			  var tol = [];
			  var array_color = ['#4565b2','#b197aa','#accea1','#d6aa7f','#d99b9b','#d794aa','#cca4a8','#91a3b0','#738a9b','#cdd2ff'];

				  
				  for(var si=0; si < ssss.length; si++){					 
					 tv1tgl.push(ssss[si]);
				  }

 				
          tgl = tv1tgl;
          
		  var textToDisplay = ['First', 'Second', 'some text', 'fourth', 'last column'];
		  
          Highcharts.chart('container', {
              chart: {
                  type: 'line'
              },
              title: {
                   text: "<strong>Channel</strong>",
				   align: 'left'
              },
              subtitle: {
                  text: ''
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: '' 
              }
              },
              plotOptions: {
                  column: {
                      dataLabels: {
                          enabled: true,  
							formatter: function() {
								
	 
							  return tol[this.point.index];
							}
                      },
					  
                      enableMouseTracking: true
                  }
              },
              series: data
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	

      }
		
	function create_chart_split(data,channel){
			
		
		myArray = channel.split(",");

 
			 
		$('#chart').html('');

		for(var rt=1;rt <= myArray.length; rt++){

			var rto = rt-1;
			$('#chart').append('<div class="col-md-12" style="margin-bottom:10px;"> <div id="container'+rt+'" style="width: 1200px; margin: 0 auto"></div></div>');
			
			 var ssss = data;
			 
 
			  var tv1tgl = [];
			  var tv1data = [];    
			  var tv1data1 = [];    
			  var tv1data2 = [];    
			  var tv1data3 = [];    
			  var tol = [];
			  
			  for(var si=0; si < ssss.length; si++){
				 var tv1datad = [];   
				 
				 if(ssss[si]['AUD_'+rt] == null){
					 col_data = 0; 
				 }else{
					 col_data = ssss[si]['AUD_'+rt]; 
				 }
				 
				 if(ssss[si]['AUD_WEEKDAY_'+rt] == null){
					 col_data2 = 0; 
				 }else{
					 col_data2 = ssss[si]['AUD_WEEKDAY_'+rt]; 
				 }
				 
				 if(ssss[si]['AUD_WEEKEND_'+rt] == null){
					 col_data3 = 0; 
				 }else{
					 col_data3 = ssss[si]['AUD_WEEKEND_'+rt]; 
				 }
				 
				 
 
				  tv1tgl.push(ssss[si]['TEXT_0']);
				  tv1data.push(parseFloat(parseFloat(col_data2).toFixed(0)));
				  tv1data2.push(parseFloat(parseFloat(col_data3).toFixed(0)));
				  tv1data3.push(parseFloat(parseFloat(col_data).toFixed(0)));
				  

				  
			  }
			  
			  	


 			
          tgl = tv1tgl;
          
		  var textToDisplay = ['First', 'Second', 'some text', 'fourth', 'last column'];
		  
          Highcharts.chart('container'+rt, {
              chart: {
                  type: 'line'
              },
              title: {
                   text: "<strong>"+myArray[rto]+"</strong>",
				   align: 'left'
              },
              subtitle: {
                  text: ''
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: '' 
              }
              },
              plotOptions: {
                  column: {
                      dataLabels: {
                          enabled: true,  
							formatter: function() {
								
 
							  return tol[this.point.index];
							}
                      },
					  
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: "Week End", 
                  data: tv1data,
				  color: "#FF0000"
              },{
                  name: "Week Day", 
                  data: tv1data2,
				  color: "#6A88C2"
              },{
                  name: "All Week", 
                  data: tv1data3,
				  color: "#50AA57"
              }]
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	
		 
		}
		 
	

         
      }

		 function create_chart_day(data,data2){
			
		
		$('#chart').html('');
		 
 
		 $('#chart').append('<div class="col-md-12" style="margin-bottom:10px;"> <div id="container" style="width: 1200px; margin: 0 auto"></div></div>');
		 
		 
		 var ssss = data2['DATA'];
 
          var tv1tgl = [];
          var tv1data = [];    
          var tv1data1 = [];    
          var tv1data2 = [];    
          var tv1data3 = [];    
		  var tol = [];
          
          for(var si=0; si < ssss.length; si++){
			 var tv1datad = [];   
             col_data = ssss[si]['AUD']; 
			 
 
              tv1tgl.push(ssss[si]['TEXT']);
              tv1data.push(parseFloat(parseFloat(col_data).toFixed(0)));
			  

			  
          }


 			
          tgl = tv1tgl;
          
		  var textToDisplay = ['First', 'Second', 'some text', 'fourth', 'last column'];
		  
          Highcharts.chart('container', {
              chart: {
                  type: 'line'
              },
              title: {
                   text: "<strong>Chart</strong>",
				   align: 'left'
              },
              subtitle: {
                  text: ''
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: '' 
              }
              },
              plotOptions: {
                  column: {
                      dataLabels: {
                          enabled: true, // true,
							formatter: function() {
 
							  return tol[this.point.index];
							}
                      },
					  
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: "All Day", 
                  data: tv1data,
				  color: "#FF0000"
              }]
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	

         
      }

  	    function create_chart(data,data2){
			
		
		$('#chart').html('');
		 
 
		 $('#chart').append('<div class="col-md-12" style="margin-bottom:10px;"> <div id="container" style="width: 1200px; margin: 0 auto"></div></div>');
		 
		 
		 var ssss = data['DATA'];
		 var ssss2 = data['DATA_WEEKEND'];
		 var ssss3 = data['DATA_WEEKDAY'];
		 
 
          var tv1tgl = [];
          var tv1data = [];    
          var tv1data1 = [];    
          var tv1data2 = [];    
          var tv1data3 = [];    
		  var tol = [];
          
          for(var si=0; si < ssss.length; si++){
			 var tv1datad = [];   
             col_data = ssss[si]['AUD']; 
             col_data2 = ssss2[si]['AUD']; 
			 col_data3 = ssss3[si]['AUD']; 
			 
 
              tv1tgl.push(ssss[si]['TEXT']);
              tv1data.push(parseFloat(parseFloat(col_data2).toFixed(0)));
              tv1data2.push(parseFloat(parseFloat(col_data3).toFixed(0)));
              tv1data3.push(parseFloat(parseFloat(col_data).toFixed(0)));
			  

			  
          }


 			
          tgl = tv1tgl;
          
		  var textToDisplay = ['First', 'Second', 'some text', 'fourth', 'last column'];
		  
          Highcharts.chart('container', {
              chart: {
                  type: 'line'
              },
              title: {
                   text: "<strong>Chart</strong>",
				   align: 'left'
              },
              subtitle: {
                  text: ''
              },
              xAxis: {
                  categories: tgl
              },
              yAxis: {
              title: {
                  text: '' 
              }
              },
              plotOptions: {
                  column: {
                      dataLabels: {
                          enabled: true,  
							formatter: function() {
								
		 
							  return tol[this.point.index];
							}
                      },
					  
                      enableMouseTracking: true
                  }
              },
              series: [{
                  name: "Week End", 
                  data: tv1data,
				  color: "#FF0000"
              },{
                  name: "Week Day", 
                  data: tv1data2,
				  color: "#6A88C2"
              },{
                  name: "All Week", 
                  data: tv1data3,
				  color: "#50AA57"
              }]
          });	
          
          $('input.toggle-vis').removeAttr('disabled');  	

         
      }
      
      function search_program(){
           var start_date = $('#start_date').val();
          var end_date = $('#end_date').val();
          var channel = $('#channel').val();
          var query = $('#search_program').val();
          
          var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token"); 
          
          $('#programsss').empty('');
          
		  
		  
          var strVar = "";
          
          $.ajax({
              type	: "POST",
            url		: "<?php echo base_url().'epg_data/listsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date+ "&dend=" + end_date + "&c=" + channel,
               dataType: 'json',
              contentType: 'application/json; charset=utf-8',
              success	: function(response) {
                   $("#programsss").next().next().next().empty('');
                  
				  
				  
                  for(i=0; i < response.length; i++){                   
                      if(response[0] == "Value not found!"){
                          strResult = response[0]; 
                      } else {
						  
							    strResult = response[i].PROGRAM;
								strResult2 = '';
								
                         
                      }
                      
					  if(start_date == end_date){
						   
						   strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='programsss'>"+strResult+"</a></li>";  
						   
					  }else{
						   strVar += "<li><a href='javascript:void(0)' data-real='"+strResult+"' class='urate-select-form-two' data-for='programsss'>"+strResult+"</a></li>";  
					  }
					  
                                             
                  } 
                                        
                  $("#programsss").next().next().next().append(strVar);   
                                    
                  $('[data-for = "programsss"]').click(function() { 
                      $('#programsss').next().text($(this).data("real"));
                      $('#programsss').attr('value',$(this).data("real"));
                      
                      $(this).closest('.default').removeClass('active');  
                      
                      $(".search-con").remove();      
                                                        
                      if($(this).closest('.urate-select-dropdown').hasClass('active')){
                          $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropup_arrow.png")');        
                      } else {
                          $('#custom_programsss').css('background-image','url("assets/urate-frontend-master/assets/images/form_icon_dropdown_arrow.png")');
                      }                       
                  });                                         
              }, error: function(obj, response) {
                  console.log('ajax list detail error:' + response);	
              } 
          }); 
      }
      
	  function refreshtable(){
		  var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          
          var table = $("#example").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}} };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtable();
									}).draw();
								  }
								}
						  ],
        				"ordering": false,		
        				"bFilter" : false,
        				"bInfo" : false,	
        				"bLengthChange": false,
        				"responsive": true
        	});
        
	  }
	  
	  function refreshtablefilter1(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
         
          var table = $("#example").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}} , filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Province' 
									    };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter1(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table.ajax.reload();
	  }
	  function refreshtablefilter2(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
             var table2 = $("#example1").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - City'
									     };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter2(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_city'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table2.ajax.reload();
		  
          
	  }
	  function refreshtablefilter3(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		  
		    var table3 = $("#example2").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Helix Comm' 
									    };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter3(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_comm'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table3.ajax.reload();
		  
		  
          
	  }
	  function refreshtablefilter4(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
         
		    var table4 = $("#example3").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Personas'
									  	 };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter4(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_persona'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table4.ajax.reload();
		  
          
	  }
	  function refreshtablefilter5(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		      var table5 = $("#example4").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Gender'
										  };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter5(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_gender'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table5.ajax.reload();
		  
          
	  }
	  function refreshtablefilter6(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
		      var table6 = $("#example5").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Age Group'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter6(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_age'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table6.ajax.reload();
		  
          
	  }
	  function refreshtablefilter7(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
    var table7 = $("#example6").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Digital Segment'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter7(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_digi'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table7.ajax.reload();
		  
          
	  }
	  function refreshtablefilter8(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
		      var table8 = $("#example8").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Household Profile'
										 };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter8(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_house'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table8.ajax.reload();
		  
          
	  }
	  function refreshtablefilter9(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
          
		  var table9 = $("#example9").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Household Comm Expense'
										   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter9(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_arpu'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table9.ajax.reload();
		  
          
	  }
	  function refreshtablefilter10(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		   var table10 = $("#example10").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Ses Segment'
									   };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter10(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_ses'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table10.ajax.reload();
		  
          
	  }
	  function refreshtablefilter11(start_date,channel, program, profile){
		   var user_id = $.cookie(window.cookie_prefix + "user_id");
          var token = $.cookie(window.cookie_prefix + "token");
         
          var orderingnya = '0';	
          var by = '';	
           
		  	var table11 = $("#example11").DataTable({
			   dom: 'Bfrtip',
						  'buttons': [
							  {
								  text: 'Export Excel',
								  action: function (e, dt, button, config)
								  {
									dt.one('preXhr', function (e, s, data)
									{
									  data.length = 18446744073709551610 ;
									}).one('draw', function (e, settings, json, xhr)
									{
									  var excelButtonConfig = $.fn.DataTable.ext.buttons.excelHtml5;
									  var addOptions = { exportOptions: { 'columns': ':visible',  format: {
																			body: function(data, row, column, node) {              
 																					return data.replace('.', '');
																			}
																		}}, filename: 'Audience Analytics '+start_date+' '+channel+'-'+program+' - Web Interest' };
								 
									  $.extend(true, excelButtonConfig, addOptions);
									  excelButtonConfig.action(e, dt, button, excelButtonConfig);
									   refreshtablefilter11(start_date,channel, program, profile);
									}).draw();
								  }
								}
						  ],
              "processing": true,
              "serverSide": true,
              "destroy": true,			
              "ajax": "<?php echo base_url().'epg_data/list_audience_web'?>" + "/?sess_user_id=" + user_id + "&sess_token=" + token + "&start_date=" + start_date + "&channel=" + channel+ "&program=" + program+ "&profile=" + profile,
              "searchDelay": 700,
              "bFilter" : false,
              'dom': 'lBfrtip',
              "order": [[ orderingnya, by]],
              "orderable": true,
              "bInfo" : false,
              "bLengthChange": false,
              "drawCallback": function() {
                  $('input.toggle-vis').removeAttr('disabled');
              }
          });
          
          table11.ajax.reload();
		  
          
	  }
    
    
    function search_channel(){
        //console.log("SINI!");         
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var profile = $('#profile').val();
        var query = $('#search_channel').val();
        
        var user_id = $.cookie(window.cookie_prefix + "user_id");
        var token = $.cookie(window.cookie_prefix + "token"); 
        
        $('#channel').empty('');
        
        var strVar = "";
        
        $.ajax({
            type	: "POST",
            url		: "<?php echo base_url().'channelmigration3/channelsearch/';?>"+ "?sess_user_id=" + user_id + "&sess_token=" + token +"&q=" + query + "&d=" + start_date+ "&ed=" + end_date + "&p=" + profile,
             dataType: 'json',
            contentType: 'application/json; charset=utf-8',
            success	: function(response) {
                 $("#channel").next().next().next().empty('');
                
                for(i=0; i < response.length; i++){                       
                    if(response[0] == "Value not found!"){
                        strResult = response[0]; 
                    } else {
                        strResult = response[i].CHANNEL_CIM;
                    }
                    
                     strVar += "<li data-for='channel'><a href='#' data-real='"+strResult+"' class='urate-select-form-two' data-for='channel'>"+strResult+"</a></li>";                          
                } 
                                      
                $("#channel").next().next().next().append(strVar);   
                                
                $('[data-for = "channel"]').click(function() { 
                    $('#channel').next().text($(this).data("real"));
                    $('#channel').attr('value',$(this).data("real"));
                    
                    $(this).closest('.default').removeClass('active'); 
                  
                    var chnl = $("#channel").val(); 
                    var datesel = $("#start_date").val(); 
                    var dateend = $("#end_date").val(); 
                    var profile = $("#profile").val();
                    
                    $(".search-channel-con").remove();   
                    $(".search-con").remove();
                  
                    generate_program(chnl,datesel,dateend,profile);                     
                });                                 
            }, error: function(obj, response) {
                console.log('ajax list detail error:' + response);	
            } 
        }); 
    }
  </script>