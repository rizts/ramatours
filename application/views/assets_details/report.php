<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $asset_id, $col, $dir) {
    $out = "<a href=\"" . site_url('assets/' . $asset_id . '/details/index') . "?c=";
    //set column query string value
    switch ($key) {
        case "date":
            $out .= "1";
            break;
        case "staff_id":
            $out .= "2";
            break;
        case "descriptions":
            $out .= "3";
            break;
        case "assetd_status":
            $out .= "4";
            break;
        case "assetd_id":
            $out .= "5";
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
            <?php echo header_btn_group_report("assets_details/to_excel"); ?>
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
            	<td>Tgl. Beli</td>
            	<td><div class="span2"><?php echo $date_buy; ?></div></td>
            </tr>
            <tr>
            	<td>Tgl. jatuh tempo</td>
            	<td><div class="span2"><?php echo $date_terms; ?></div></td>
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
                    <th><?php echo HeaderLink("Date", "date", $asset_id, $col, $dir); ?></th>
                    <th><?php echo HeaderLink("Staff", "staff_id", $asset_id, $col, $dir); ?></th>
                    <th><?php echo HeaderLink("Descriptions", "descriptions", $asset_id, $col, $dir); ?></th>
                    <th><?php echo HeaderLink("Status", "assetd_status", $asset_id, $col, $dir); ?></th>
                </tr>
            </thead>
            <?php
            foreach ($assets_details as $row) {
                $row_staff = $staff->where('staff_id', $row->staff_id)->get();
            ?>
                <tr>
                    <td><?php $date = new DateTime($row->date); echo $date->format('d-m-Y'); ?></td>
                    <td><?php echo $row_staff->staff_name; ?></td>
                    <td><?php echo $row->descriptions; ?></td>
                    <td><?php echo $row->assetd_status == 1 ? 'Enable' : 'Disable'; ?></td>
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
</div>
<?php get_footer(); ?>