<?php get_header(); ?>
<div class="body">
    <div class="content">
        <script type="text/javascript">
        $(document).ready(function () {
            $("#trasset_date_time" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
    <h2 class="rama-title">Form Asset Handover</h2>
    <?php echo $this->session->flashdata('message'); ?>
    <?php echo form_open($form_action) . form_hidden('id', $id); ?>
    <table>
        <tr>
            <td>Date</td>
            <td><?php echo form_input($date); ?></td>
        </tr>
        <tr>
            <td>Yang menyerahkan</td>
            <td><?php echo $staff_id_from; ?></td>
        </tr>
        <tr>
            <td>Yang menerima</td>
            <td><?php echo $staff_id_to; ?></td>
        </tr>
        <tr>
            <td valign="top">Description</td>
            <td><?php echo form_textarea($trasset_note); ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo $trasset_status; ?></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo form_submit($btn_save).' '.$link_back; ?></td>
        </tr>
    </table>
    <?php echo form_close() ?>
    <div class="clearfix"></div>
    </div>
</div>
<?php get_footer(); ?>
