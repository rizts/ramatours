<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $asset_id, $col, $dir) {
    $out = "<a href=\"" . site_url('assets/' . $asset_id . '/handover/index') . "?c=";
    //set column query string value
    switch ($key) {
        case "trasset_date_time":
            $out .= "1";
            break;
        case "trasset_staff_id_from":
            $out .= "2";
            break;
        case "trasset_staff_id_to":
            $out .= "3";
            break;
        case "trasset_doc_no":
            $out .= "4";
            break;
        case "trasset_status":
            $out .= "5";
            break;
        case "trasset_id":
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
<div class="body">
    <div class="content">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Assets
                <small>Manage assets handover</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "assets/" . $asset_id . "/handover/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "asset_name" => "Name")); ?>
        </div>

        <table class="table boo-table table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <th rowspan="2"><?php echo HeaderLink("Date", "trasset_date_time", $asset_id, $col, $dir); ?></th>
                    <th colspan="2">Staff</th>
                    <th rowspan="2"><?php echo HeaderLink("No Dokumen", "trasset_doc_no", $asset_id, $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Status", "trasset_status", $asset_id, $col, $dir); ?></th>
                    <th rowspan="2">Note</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th><?php echo HeaderLink("Yang Menyerahkan", "trasset_staff_id_from", $asset_id, $col, $dir); ?></th>
                    <th><?php echo HeaderLink("Yang Menerima", "trasset_staff_id_to", $asset_id, $col, $dir); ?></th>
                </tr>
            </thead>
            <?php
            foreach ($assets_handover as $row) {
            ?>
                <tr>
                    <td><?php echo $row->trasset_date_time; ?></td>
                    <td><?php $row_staff_from = $staff->where('staff_id', $row->trasset_staff_id_from)->get();echo $row_staff_from->staff_name; ?></td>
                    <td><?php $row_staff_to = $staff->where('staff_id', $row->trasset_staff_id_to)->get();
echo $row_staff_to->staff_name; ?></td>
                    <td><?php echo $row->trasset_doc_no; ?></td>
                    <td><?php echo $row->trasset_status; ?></td>
                    <td><?php echo $row->trasset_note; ?></td>
                    <td>
                    <?php echo anchor('assets/' . $row->trasset_asset_id . '/handover/edit/' . $row->trasset_id, 'Edit'); ?> |
                    <?php echo anchor('assets/' . $row->trasset_asset_id . '/handover/delete/' . $row->trasset_id, 'Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?>
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
</div>
<?php get_footer(); ?>