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
<div class="body">
    <div class="content">
        <?php echo $this->session->flashdata('message'); ?>
        <div class="page-header">
            <div class="icon">
                <span class="ico-tag"></span>
            </div>
            <h1>Cuti
                <small>Manage cuti</small>
            </h1>
        </div>
        <br class="cl" />
        <div class="head blue">
            <?php echo header_btn_group("#", "cuti/add"); ?>
        </div>
        <div id="search_bar" class="widget-header">
            <?php search_form(array("" => "By", "asset_name" => "Name")); ?>
        </div>
        <table class="table fpTable table-hover">
            <thead>
                <tr>
                    <th width="25%"><?php echo HeaderLink("Applicant", "staff_id", $col, $dir); ?></th>
                    <th width="10%"><?php echo HeaderLink("Requested date", "date_request", $col, $dir); ?></th>
                    <th width="10%"><?php echo HeaderLink("Start from", "date_start", $col, $dir); ?>
                    <th width="10%"><?php echo HeaderLink("To", "date_end", $col, $dir); ?>
                    <th width="10%"><?php echo HeaderLink("Status", "status", $col, $dir); ?>
                    <th width="25%"><?php echo HeaderLink("Approve by", "approveby_staff_id", $col, $dir); ?>
                    <th width="5%">Action</th>
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
                    <td><?php echo $staff->staff_name; ?></td>
                    <td><?php echo $row->date_request; ?></td>
                    <td><?php echo $row->date_start; ?></td>
                    <td><?php echo $row->date_end; ?></td>
                    <td>
                      <div class="btn bootstrap-tooltip <?php echo $status_class; ?>" style="width:70px;" data-title="<?php echo $comment; ?>" data-placement="top">
                        <?php echo $row->status; ?>
                      </div>
                    </td>
                    <td><?php echo $approve_by ? $approve_by->username:"-"; ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                <i class="icon-cog"></i>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                  <a href="#update_status_modal" id="<?php echo $row->id; ?>" class="update_status" data-toggle="modal">
                                    <i class="icon-edit"></i> Update status cuti
                                  </a>                                
                                </li>
                                <li><?php echo anchor('cuti/edit/' . $row->id, '<i class="icon-pencil"></i> Edit'); ?></li>
                                <li><?php echo anchor('cuti/delete/' . $row->id, '<i class="icon-trash"></i> Delete', array('onclick' => "return confirm('Are you sure want to delete?')")); ?></li>
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
