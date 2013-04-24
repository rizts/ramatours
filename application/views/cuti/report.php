<?php get_header(); ?>
<?php echo load_js(array(
  "plugins/ckeditor/ckeditor.js"
));?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('cuti') . "?c=";
    //set column query string value
    switch ($key) {
        case "staff_id":
            $out .= "1";
            break;
        case "date_request":
            $out .= "2";
            break;
        case "date_start":
            $out .= "3";
            break;
        case "date_end":
            $out .= "4";
            break;
        default:
            $out .= "0";
    }

    $out .= "&d=";

    //reverse sort if the current column is clicked
    if ($key == $col) {
        switch ($dir) {
            case "ASC":
                $out .= "1";
                break;
            default:
                $out .= "0";
        }
    } else {
        //pass on current sort direction
        switch ($dir) {
            case "ASC":
                $out .= "0";
                break;
            default:
                $out .= "1";
        }
    }

    //complete link
    $out .= "\">$value</a>";

    return $out;
}
?>
<div class="modal hide fade" id="update_status_modal">
  <?php echo form_open("cuti/update_status"); ?>
	<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
    <h3 style="font-weight: bold">Update status cuti</h3>
	</div>
	<div class="modal-body">
      <input type="hidden" name="cuti_id" id="cuti_id" />
      <?php echo form_dropdown("status", $status); ?>
      <?php echo form_textarea($comment); ?>	
	</div>
	<div class="modal-footer">
	 <input type="submit" value="Update" class="btn btn-primary" />
	 <input type="button" value="Cancel" class="btn btn-danger" data-dismiss="modal" />
	</div>
  <?php echo form_close(); ?>
</div>
<style type="text/css">
.modal {
	width : 600px;
}
.modal-body{
  max-height: 600px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo base_url('cuti/report').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('cuti/report').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
  	});
});
</script>
<div class="body">
    <div class="content">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Cuti
                <small>Report Cuti</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group_report(); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <form action="" method="get">
      		<?php
	      	$myUrl = 'http://'.$_SERVER['HTTP_HOST'];
			$requestUri = $_SERVER['REQUEST_URI'];
      		?>
      		<table width="30%" align="center">
      			<tr>
      				<td><span class="search_by">Branch</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('staff_cabang')) > 0){
								$requestUri = str_replace($this->input->get('staff_cabang'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo $staff_cabang; ?>
					 	</div>
					 </td>
   				</tr>
      			<tr>
      				<td><span class="search_by">Department</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('staff_departement')) > 0){
								$requestUri = str_replace($this->input->get('staff_departement'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo $staff_departement; ?>
					 	</div>
					 </td>
   				</tr>
      			<tr>
      				<td><span class="search_by">Title</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('staff_jabatan')) > 0){
								$requestUri = str_replace($this->input->get('staff_jabatan'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo $staff_jabatan; ?>
					 	</div>
					 </td>
   				</tr>
      			<tr>
      				<td><span class="search_by">Name</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('staff_name')) > 0){
								$requestUri = str_replace($this->input->get('staff_name'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo form_input(array('name' => 'staff_name', 'value' => $this->input->get('staff_name'), 'size' => '28'));?>
					 	</div>
					 </td>
   				</tr>
   				<tr>
   					<td>&nbsp;</td>
	      			<td><input type="submit" name="search" value="Search" class="btn btn-primary" /></td>
     			</tr>
	      	</table>
    	</form>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
		          	<th rowspan="2"><?php echo HeaderLink("Name", "staff_name", $col, $dir); ?></th>
		          	<th rowspan="2"><?php echo HeaderLink("Branch", "staff_cabang", $col, $dir); ?></th>
		          	<th rowspan="2"><?php echo HeaderLink("Departement", "staff_departement", $col, $dir); ?></th>
		          	<th rowspan="2"><?php echo HeaderLink("Title", "staff_jabatan", $col, $dir); ?></th>
                    <th rowspan="2" width="10%"><?php echo HeaderLink("Requested date", "date_request", $col, $dir); ?></th>
                    <th colspan="2">Date</th>
                    <th rowspan="2" width="10%"><?php echo HeaderLink("Status", "status", $col, $dir); ?></th>
                    <th rowspan="2" width="10%"><?php echo HeaderLink("Approve by", "approveby_staff_id", $col, $dir); ?></th>
                </tr>
                <tr>
                    <th width="10%"><?php echo HeaderLink("From", "date_start", $col, $dir); ?></th>
                    <th width="10%"><?php echo HeaderLink("To", "date_end", $col, $dir); ?></th>
                </tr>
            </thead>
            <?php
            foreach ($cuti->result() as $row) {
            $staff = get_staff_detail($row->staff_id);
            $approve_by = get_user_detail($row->approveby_staff_id);
            $detail = getDetail($row->id);
            $comment = "No Comment";
            if(count($detail)){
              $comment = strip_tags($detail->comment);;  
            }
            switch($row->status){
              case "pending":
                $status_class = "btn-info";
                break;
              case "approve":
                $status_class = "btn-primary";
                break;
              case "decline":
                $status_class = "btn-danger";
                break;
              default:
                $status_class = "btn-info";
                break;
            }
            ?>
                <tr>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->date_request),'j M Y'); ?></td>
                    <td><?php echo date_format(new DateTime($row->date_start),'j M Y'); ?></td>
                    <td><?php echo date_format(new DateTime($row->date_end),'j M Y'); ?></td>
                    <td>
                      <div class="btn bootstrap-tooltip <?php echo $status_class; ?>" style="width:70px;" data-title="<?php echo $comment; ?>" data-placement="top">
                        <?php echo $row->status; ?>
                      </div>
                    </td>
                    <td><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
                </tr>
            <?php } ?>
        </table>
        <div class="clearfix"></div>
        <br>
        <div class="pagination pagination-right">
            <ul>
                <?php echo $pagination; ?>
            </ul>
        </div>
    </div>
    <!-- Modal -->
	<div id="printModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Report Cuti</h3>
		</div>
		<div class="modal-body">
		    <table style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
		      <thead>
                <tr>
		          	<th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Name</th>
		          	<th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Branch</th>
		          	<th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Departement</th>
		          	<th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Title</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2" width="10%">Requested date</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Date</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="3">Approval</th>
                </tr>
                <tr>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">From</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">To</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">Status</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">Reason</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">By</th>
                </tr>
            </thead>
            <tbody>
	            <?php
	            foreach ($cuti->result() as $row) {
		            $staff = get_staff_detail($row->staff_id);
		            $approve_by = get_user_detail($row->approveby_staff_id);
		            $detail = getDetail($row->id);
		            $comment = "No Comment";
		            if(count($detail)){
		              $comment = $detail->comment;  
		            }
	            ?>
	                <tr>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_cabang; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
			            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
	                    <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo date_format(new DateTime($row->date_request),'j M Y'); ?></td>
	                    <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo date_format(new DateTime($row->date_start),'j M Y'); ?></td>
	                    <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo date_format(new DateTime($row->date_end),'j M Y'); ?></td>
	                    <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->status; ?></td>
	                    <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $comment; ?></td>
	                    <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
	                </tr>
	            <?php
				}
				?>
		      </tbody>
		    </table>
		</div>
		<div class="modal-footer">
			<button id="printPDF" class="btn btn-primary">Save as PDF</button>
			<button id="printXLS" class="btn btn-primary">Save as Excel</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
</div>
<script type="text/javascript">
  var CKInstance;
  $("#update_status_modal").on("shown", function(){
    CKInstance = CKEDITOR.replace("comment");
  });
  $("#update_status_modal").on("hidden", function(){
    CKEDITOR.instances["comment"].destroy();  
  })
  $(".update_status").on("click", function(){
    var id = $(this).attr("id");
    $("#cuti_id").val(id);
  });
</script>
<?php get_footer(); ?>
