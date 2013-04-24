<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('staffs') . "?c=";
    //set column query string value
    switch ($key) {
        case "staff_nik":
            $out .= "1";
            break;
        case "staff_name":
            $out .= "2";
            break;
        case "staff_address":
            $out .= "3";
            break;
        case "staff_email":
            $out .= "4";
            break;
        case "staff_phone_home":
            $out .= "5";
            break;
        case "staff_phone_hp":
            $out .= "6";
            break;
        case "staff_cabang":
            $out .= "7";
            break;
        case "staff_departement":
            $out .= "8";
            break;
        case "staff_jabatan":
            $out .= "9";
            break;
        case "staff_id":
            $out .= "10";
            break;
        case "saldo_cuti":
            $out .= "11";
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
<style type="text/css">
.modal {
	width : 500px;
}
.modal-body{
  max-height: 500px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo base_url('staffs/report_cuti').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('staffs/report_cuti').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
  	});
});
</script>
<div class="body">
  <div class="content">
    <?php echo $this->session->flashdata('message'); ?>
    <div class="page-header">
      <div class="icon">
        <span class="ico-coins"></span>
      </div>
      <h1>Staff
      <small>Report Sisa Cuti</small>
      </h1>
    </div>
    <br class="cl" />
    <div class="head blue">
      <?php echo header_btn_group_report();?>
    </div>
    <div id="search_bar" class="widget-header">
      <form action="" method="get">
      		<?php
	      	$myUrl = 'http://'.$_SERVER['HTTP_HOST'];
			$requestUri = $_SERVER['REQUEST_URI'];
      		?>
      		<table width="50%" align="center">
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
          <th><?php echo HeaderLink("Branch", "staff_cabang", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Departement", "staff_departement", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Name", "staff_name", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Title", "staff_jabatan", $col, $dir); ?></th>
          <th><?php echo HeaderLink("Sisa Cuti", "saldo_cuti", $col, $dir); ?></th>
        </tr>
      </thead>
      <?php
      foreach ($staff_list as $row) {
      ?>
          <tr>
            <td><?php echo $row->staff_cabang; ?></td>
            <td><?php echo $row->staff_departement; ?></td>
            <td><?php echo $row->staff_name; ?></td>
            <td><?php echo $row->staff_jabatan; ?></td>
            <td><?php echo $row->saldo_cuti; ?></td>
          </tr>
      <?php } ?>
    </table>
    <div class="clearfix"></div>
    <div class="pagination pagination-right">
      <ul>
        <?php echo $pagination; ?>
      </ul>
    </div>
    <!-- Modal -->
	<div id="printModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel">Staff List</h3>
		</div>
		<div class="modal-body">
			<table style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
			  <thead>
			    <tr>
			      <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Branch</th>
			      <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Departement</th>
			      <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Name</th>
			      <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Title</th>
			      <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Sisa Cuti</th>
			    </tr>
			  </thead>
			  <?php
			  foreach ($staff_list as $row) {
			  ?>
			      <tr>
			        <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_cabang; ?></td>
			        <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
			        <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
			        <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
			        <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->saldo_cuti; ?></td>
			      </tr>
			  <?php } ?>
			</table>
		</div>
		<div class="modal-footer">
			<button id="printPDF" class="btn btn-primary">Save as PDF</button>
			<button id="printXLS" class="btn btn-primary">Save as Excel</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
  </div>
</div>

<?php get_footer(); ?>