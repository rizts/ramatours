<?php get_header(); ?>
<?php

function HeaderLink($value, $key, $col, $dir) {
    $out = "<a href=\"" . site_url('assets') . "?c=";
    //set column query string value
    switch ($key) {
        case "staff_id":
            $out .= "1";
            break;
        case "date":
            $out .= "2";
            break;
        case "hari_masuk":
            $out .= "3";
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
            <h1>Absensi
                <small>Report Absensi</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group_report("absensi/to_pdf"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "staff_name" => "Name", "branch_name" => "Branch")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="10%">Kode Absen</th>
                    <th width="30%"><?php echo HeaderLink("Staff", "staff_id", $col, $dir); ?></th>
                    <th>Branch</th>
                    <th>Title</th>
                    <th width="20%"><?php echo HeaderLink("Date", "date", $col, $dir); ?></th>
                    <th width="10%"><?php echo HeaderLink("Jumlah masuk", "hari_masuk", $col, $dir); ?></th>
                </tr>
            </thead>
            <?php
            foreach ($absensi->result() as $row) {
            ?>
                <tr>
                    <td><?php echo $row->staff_kode_absen; ?></td>
                    <td><?php echo $row->staff_name; ?></td>
                    <td><?php echo $row->staff_cabang; ?></td>
                    <td><?php echo $row->staff_jabatan; ?></td>
                    <td><?php echo date_format(new DateTime($row->date),'j M Y'); ?></td>
                    <td><span class="float-right"><?php echo $row->hari_masuk; ?></span></td>
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
