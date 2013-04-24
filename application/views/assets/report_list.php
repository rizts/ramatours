<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('assets') . "?c=";
    //set column query string value
    switch ($key) {
        case "asset_name":
            $out .= "1";
            break;
        case "asset_status":
            $out .= "2";
            break;
        case "staff_id":
            $out .= "3";
            break;
        case "date":
            $out .= "4";
            break;
        case "staff_id":
            $out .= "5";
            break;
        case "branch":
            $out .= "6";
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
  	$("#printPDF").click(function() {
  		document.location.href = '<?php echo base_url('assets/report_list').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('assets/report_list').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
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
            <h1>Assets
                <small>Report Asset List</small>
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
						      if(strlen($this->input->get('branch')) > 0){
								$requestUri = str_replace($this->input->get('branch'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo $branch; ?>
					 	</div>
					 </td>
   				</tr>
      			<tr>
      				<td><span class="search_by">Name</span></td>
     				<td>
     					<div id="search">
		      				<?php
						      if(strlen($this->input->get('asset_name')) > 0){
								$requestUri = str_replace($this->input->get('asset_name'),"",$requestUri);
						        echo anchor("$myUrl$requestUri", '<span class="ico-remove"></span>', array(
						          "class"=>"clear-search-report",
						          "data-placement"=>"top",
						          "data-title"=>"Clear search"
						        ));
						      }
						    ?>
					 		<?php echo form_input(array('name' => 'asset_name', 'value' => $this->input->get('asset_name'), 'size' => '28'));?>
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

        <table class="table fpTable table-hover" style="border-collapse: collapse; border-spacing: 0;">
            <thead>
                <tr>
                    <th rowspan="2"><?php echo HeaderLink("Name", "asset_name", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Name", "asset_name", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Branch", "branch", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Status", "asset_status", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Tgl. Beli", "date_buy", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Tgl. Tempo", "date_terms", $col, $dir); ?></th>
                    <th colspan="2">Terakhir digunakan</th>
                    <th width="10%" rowspan="2">Action</th>
                </tr>
                <tr>
                    <th><?php echo HeaderLink("Staff", "staff_id", $col, $dir); ?></th>
                    <th><?php echo HeaderLink("Date", "date", $col, $dir); ?></th>
                </tr>
            </thead>
            <?php
            foreach ($asset_list as $row) {
                $row_staff = $staff->where('staff_id', $row->staff_id)->get();
            ?>
                <tr>
                    <td><?php echo $row->asset_name; ?></td>
                    <td><?php echo $row->asset_code; ?></td>
                    <td><?php echo $row->branch; ?></td>
                    <td><?php echo $row->asset_status == '1'? 'Enable':'Disable'; ?></td>
                    <td><?php echo $row->date_buy; ?></td>
                    <td><?php echo $row->date_tempo; ?></td>
                    <td><?php echo $row_staff->staff_name; ?></td>
                    <td><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor('assets/' . $row->asset_id . '/handover/report', '<i class="icon-list"></i>Detail'); ?></li>
                            </ul>
                        </div>
                    </td>
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
			<h3 id="myModalLabel">Asset List Report</h3>
		</div>
		<div class="modal-body">
			<table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
		      <thead>
                <tr>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Name</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Code</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Branch</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Status</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Tgl. Beli</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" rowspan="2">Tgl. Tempo</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Terakhir digunakan</th>
                </tr>
                <tr>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Staff</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;">Date</th>
                </tr>
            </thead>
      		<tbody>
		    <?php
	          foreach ($asset_list as $row) {
	              $row_staff = $staff->where('staff_id', $row->staff_id)->get();
	        ?>
	              <tr>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->asset_name; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->asset_code; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->branch; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->asset_status == '1'? 'Enable':'Disable'; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->date_buy; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->date_tempo; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row_staff->staff_name; ?></td>
	                  <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
                  </tr>
	            <?php } ?>
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
<?php get_footer(); ?>
