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
                <small>Manage history assets</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "assets/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "asset_name" => "Name")); ?>
        </div>

        <table class="table fpTable table-hover" style="border-collapse: collapse; border-spacing: 0;">
            <thead>
                <tr>
                    <th rowspan="2"><?php echo HeaderLink("Name", "asset_name", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Code", "asset_code", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Status", "asset_status", $col, $dir); ?></th>
                    <!--<th rowspan="2"><?php echo HeaderLink("Tgl. Beli", "date_buy", $col, $dir); ?></th>
                    <th rowspan="2"><?php echo HeaderLink("Tgl. Tempo", "date_terms", $col, $dir); ?></th>-->
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
                    <td><?php echo $row->asset_status == '1'? 'Enable':'Disable'; ?></td>
                    <!--<td><?php echo $row->date_buy; ?></td>
                    <td><?php echo $row->date_tempo; ?></td>-->
                    <td><?php echo $row_staff->staff_name; ?></td>
                    <td><?php echo $row->date; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><?php echo anchor('assets/' . $row->asset_id . '/handover/detail', '<i class="icon-list"></i> Detail Serah Terima'); ?></li>
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
</div>
<?php get_footer(); ?>
