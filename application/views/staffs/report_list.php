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
        case "staff_sex":
            $out .= "11";
            break;
        case "staff_birthdate":
            $out .= "12";
            break;
        case "mulai_kerja":
            $out .= "13";
            break;
        case "staff_status_nikah":
            $out .= "14";
            break;
        case "staff_status_karyawan":
            $out .= "15";
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
	width : 800px;
}
.modal-body{
  max-height: 800px!important;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#staff_birthdate" ).datepicker({
    	dateFormat: "yy-mm-dd"
  	});

  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo base_url('staffs/report_list').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('staffs/report_list').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
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
      <small>Report staff list</small>
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
      				<td><span class="search_by">Birth Date</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('staff_birthdate')) > 0){
								$requestUri = str_replace($this->input->get('staff_birthdate'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo form_input(array('id' => 'staff_birthdate', 'name' => 'staff_birthdate', 'value' => $this->input->get('staff_birthdate'), 'size' => '28'));?>
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
    <div class="row">
		<div class="span10" style="width: 970px; overflow: auto;">
		    <table class="table fpTable table-hover">
		      <thead>
		        <tr>
		          <th><?php echo HeaderLink("Name", "staff_name", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Branch", "staff_cabang", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Departement", "staff_departement", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Title", "staff_jabatan", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Sex", "staff_sex", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Birth Date", "staff_birthdate", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Address", "staff_address", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Email", "staff_email", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Home Phone", "staff_phone_home", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Cellular Phone", "staff_phone_hp", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Start", "mulai_kerja", $col, $dir); ?></th>
		          <?php
		          if ($this->input->get("staff_birthdate") != "") {
		          ?>
		          <th>Yang Ke</th>
		          <?php
		          }
		          ?>
		          <th><?php echo HeaderLink("Marital", "staff_status_nikah", $col, $dir); ?></th>
		          <th><?php echo HeaderLink("Status", "staff_status_karyawan", $col, $dir); ?></th>
		          <th>Active</th>
		        </tr>
		      </thead>
		      <tbody>
		      <?php
		      foreach ($staff_list as $row) {
		      ?>
		          <tr>
		            <td><?php echo $row->staff_name; ?></td>
		            <td><?php echo $row->staff_cabang; ?></td>
		            <td><?php echo $row->staff_departement; ?></td>
		            <td><?php echo $row->staff_jabatan; ?></td>
		            <td><?php echo $row->staff_sex; ?></td>
		            <td><?php echo $row->staff_birthplace.', '.date_format(new DateTime($row->staff_birthdate),'j M Y'); ?></td>
		            <td><?php echo $row->staff_address; ?></td>
		            <td><?php echo $row->staff_email; ?></td>
		            <td><?php echo $row->staff_phone_home; ?></td>
		            <td><?php echo $row->staff_phone_hp; ?></td>
		            <td><?php date_format(new DateTime($row->mulai_kerja),'j M Y'); ?></td>
		          	<?php
		          	if ($this->input->get("staff_birthdate") != "") {
		          	?>
		          	<td><?php $birthyear = date('Y', strtotime($row->staff_birthdate)); echo intval(date('Y')-intval($birthyear)); ?></td>
		          	<?php
		          	}
		          	?>
		            <td><?php echo $row->staff_status_nikah; ?></td>
		            <td><?php echo $row->staff_status_karyawan; ?></td>
		            <td><?php $date_out = date_format(new DateTime($row->date_out),'j M Y'); $contract_to = $row->contract_to; echo ($date_out != '' && $contract_to < date('Y-m-d')? 'Active':'Inactive'); ?></td>
		          </tr>
		      <?php } ?>
		      </tbody>
		    </table>
  		</div>
    </div>
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
			<div class="row">
				<div class="span10">
				    <table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
				      <thead>
				        <tr>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Name</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Branch</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Departement</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Title</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Sex</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Birth Date</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Address</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Email</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Home Phone</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Cellular Phone</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Start</th>
				          <?php
				          if ($this->input->get("staff_birthdate") != "") {
				          ?>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Yang Ke</th>
				          <?php
				          }
				          ?>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Marital</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Status</th>
				          <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Active</th>
				        </tr>
				      </thead>
				      <tbody>
				      <?php
				      foreach ($staff_list as $row) {
				      ?>
				          <tr>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_name; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_cabang; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_departement; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_jabatan; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_sex; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_birthplace.', '.date_format(new DateTime($row->staff_birthdate),'j M Y'); ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_address; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_email; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_phone_home; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_phone_hp; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php date_format(new DateTime($row->mulai_kerja),'j M Y'); ?></td>
				          	<?php
				          	if ($this->input->get("staff_birthdate") != "") {
				          	?>
				          	<td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $birthyear = date('Y', strtotime($row->staff_birthdate)); echo intval(date('Y')-intval($birthyear)); ?></td>
				          	<?php
				          	}
				          	?>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_status_nikah; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->staff_status_karyawan; ?></td>
				            <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $date_out = date_format(new DateTime($row->date_out),'j M Y'); $contract_to = $row->contract_to; echo ($date_out != '' && $contract_to < date('Y-m-d')? 'Active':'Inactive'); ?></td>
				          </tr>
				      <?php } ?>
				      </tbody>
				    </table>
		  		</div>
		    </div>
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
