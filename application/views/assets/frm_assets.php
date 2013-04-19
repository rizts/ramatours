<?php get_header(); ?>
<?php echo load_js(array(
  "plugins/ckeditor/ckeditor.js"
));?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#status').iphoneStyle({
      checkedLabel: "Enable",
      uncheckedLabel: "Disable",
      onChange: function(e, checked){
        if(checked){
          $(e).attr('checked', 'checked');
        }else{
          $(e).removeAttr('checked');       
        }      
      }  
    });      
  });
</script>
<div class="body">
    <div class="content">
        <?php echo validation_errors(); ?>
        <h2 class="rama-title">Form Asset</h2>
        <?php echo $this->session->flashdata('message'); ?>
        <?php echo form_open($form_action) . form_hidden('id', $id); ?>
        <table width="100%">
            <tr>
                <td width="20%">Name</td>
                <td><div class="span3"><?php echo form_input($asset_name); ?></div></td>
            </tr>
            <tr>
                <td width="20%">Code</td>
                <td><div class="span2"><?php echo form_input($code); ?></div></td>
            </tr>
            <tr>
                <td>Status</td>
                <td><input type="checkbox" id="status" /></td>
            </tr>
            <tr>
            	<td>Tgl. Beli</td>
            	<td><div class="span2"><?php echo form_input($date_buy); ?></div></td>
            </tr>
            <tr>
            	<td>Tgl. jatuh tempo</td>
            	<td><div class="span2"><?php echo form_input($date_terms); ?></div></td>
            </tr>
            <tr>
            	<td>Description</td>
            	<td><div class="span6"><?php echo form_textarea($description); ?></div></td>
            </tr>
        </table>
        <?php echo form_submit($btn_save) . ' ' . $link_back; ?>
        <?php echo form_close() ?>
    </div>
</div>
<script type="text/javascript">
  CKEDITOR.replace("description");
</script>
<?php get_footer(); ?>
