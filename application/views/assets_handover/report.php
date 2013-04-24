<?php get_header(); ?>
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
  		document.location.href = '<?php echo base_url('assets_handover/report').'?'.$_SERVER['QUERY_STRING'].'&to=pdf'; ?>';
  	});

  	$("#printXLS").click(function() {
  		document.location.href = '<?php echo base_url('assets_handover/report').'?'.$_SERVER['QUERY_STRING'].'&to=xls'; ?>';
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
                <small>Report Serah Terima Asset</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group_report(); ?>
        </div>
        <div class="clearfix"></div>
        <br />
        <h2 class="rama-title">Asset Detail</h2>
	    <table width="100%">
            <tr>
                <td width="20%">Name</td>
                <td><div class="span3"><?php echo $asset_name; ?></div></td>
            </tr>
            <tr>
                <td width="20%">Code</td>
                <td><div class="span2"><?php echo $asset_code; ?></div></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><div class="span2"><?php echo $asset_status; ?></div></td>
            </tr>
            <tr>
            	<td>Description</td>
            	<td><div class="span6"><?php echo $description; ?></div></td>
            </tr>
        </table>
		<br />
        <table class="table boo-table table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th width="10%" rowspan="2">Date</th>
                    <th colspan="2">Staff</th>
                    <th width="10%" rowspan="2">No Dokumen</th>
                    <th width="10%" rowspan="2">Status</th>
                    <th width="25%" rowspan="2">Note</th>
                </tr>
                <tr>
                    <th width="10%">Yang Menyerahkan</th>
                    <th width="10%">Yang Menerima</th>
                </tr>
            </thead>
            <?php
            foreach ($assets_handover as $row) {
            ?>
                <tr>
                    <td><?php echo date_format(new DateTime($row->trasset_date_time),'j M Y'); ?></td>
                    <td><?php $row_staff_from = $staff->where('staff_id', $row->trasset_staff_id_from)->get();echo $row_staff_from->staff_name; ?></td>
                    <td><?php $row_staff_to = $staff->where('staff_id', $row->trasset_staff_id_to)->get();
echo $row_staff_to->staff_name; ?></td>
                    <td><?php echo $row->trasset_doc_no; ?></td>
                    <td><?php echo $row->trasset_status; ?></td>
                    <td><?php echo $row->trasset_note; ?></td>
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
			<h3 id="myModalLabel">Report Serah Terima Asset</h3>
		</div>
		<div class="modal-body">
			<table width="1500px;" style="border-width: 0 0 1px 1px; border-spacing: 0; border-collapse: collapse; border-style: solid;">
		      <thead>
                <tr>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%" rowspan="2">Date</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" colspan="2">Staff</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%" rowspan="2">No Dokumen</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%" rowspan="2">Status</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="25%" rowspan="2">Note</th>
                </tr>
                <tr>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">Yang Menyerahkan</th>
                    <th style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;" width="10%">Yang Menerima</th>
                </tr>
            </thead>
      		<tbody>
			    <?php
	            foreach ($assets_handover as $row) {
	            ?>
            	<tr>
	            	<td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo date_format(new DateTime($row->trasset_date_time),'j M Y'); ?></td>
	                <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $row_staff_from = $staff->where('staff_id', $row->trasset_staff_id_from)->get();echo $row_staff_from->staff_name; ?></td>
	                <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php $row_staff_to = $staff->where('staff_id', $row->trasset_staff_id_to)->get();
	echo $row_staff_to->staff_name; ?></td>
	                <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->trasset_doc_no; ?></td>
	                <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->trasset_status; ?></td>
	                <td style="margin: 0; padding: 4px; border-width: 1px 1px 0 0; border-style: solid;"><?php echo $row->trasset_note; ?></td>
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
<?php get_footer(); ?>