<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Payroll</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/application.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fullcalendar.css"/>

        <?php
        echo load_css(array(
            "stylesheets.css",
            "dashboard.css",
            "bootstrapSwitch.css",
            "jquery.alerts.css",
            "iphone-style.css",
            "mcustomscrollbar/mCustomScrollbar.css",
            "jquery.handsontable.full.css"
        ));
        echo load_js(array(
            "plugins/jquery/jquery-1.9.1.min.js",
            "plugins/jquery/jquery-ui-1.10.1.custom.min.js",
            "plugins/jquery/jquery-migrate-1.1.1.min.js",
            "plugins/jquery/globalize.js",
            "plugins/other/excanvas.js",
            "plugins/other/jquery.mousewheel.min.js",
            "plugins/bootstrap/bootstrap.min.js",
            "bootstrap-modal.js",
            "bootstrap-modalmanager.js",
            "bootstrapSwitch.js",
            "plugins/cookies/jquery.cookies.2.2.0.min.js", // used by navigation menu
            "plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js",
            "plugins/validationEngine/languages/jquery.validationEngine-en.js",
            "plugins/validationEngine/jquery.validationEngine.js",
            "plugins/uniform/jquery.uniform.min.js",
            "plugins/select/select2.min.js",
            "plugins/maskedinput/jquery.maskedinput-1.3.min.js",
            "colResizable-1.3.med.js",
            "jquery.alerts.js",
            "iphone-style-checkboxes.js",
            "jquery.editable-1.3.3.js",
            "jquery.number.min.js",
            "jquery.handsontable.full.js",
            "plugins/jquery.jstree.js",
            "accounting.js",
            "plugins.js",
//            "charts.js",
            "actions.js",
            "custom.js"
        ));
        ?>

        <script src="<?php echo base_url(); ?>assets/js/fullcalendar/fullcalendar.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/js/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>                
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/docs.css"/>
    </head>
    <body>
        <div class="wrapper">
            <div class="sidebar">
                <div class="nContainer">
                    <div style="padding: 5px;">
                        <?php
                            $setting = new Setting();                            
                        ?>
                        <div><img src="<?php echo assets_url('upload/' . $setting->get_val('logo')) ?>" style="width: 216px; height: 100px;" /></div>
                        <div style="font-size: 20px; padding: 5px; color: #fff; font-weight: bold;">
                            <?php echo $setting->get_val('company_name'); ?>
                        </div>
                        <form action="<?php echo site_url('searches')?> " method="get">
                            <input autofocus="autofocus" type="text" name="q" placeholder="Search Advance" style="width: 215px;">
                        </form>
                    </div>
                    <ul class="navigation">
                      <li><?php echo anchor("/", "Dashboard"); ?></li>
                      <li>
                        <a href="#" class="blblue">Master</a>
                        <div class="open"></div>
                        <ul>
                        	<li><?php echo anchor('assets', 'Assets'); ?></li>
                        	<li><?php echo anchor('branches', 'Branch'); ?></li>
                        	<li><?php echo anchor('departments', 'Departements'); ?></li>
                        	<li><?php echo anchor('taxes_employees', 'Taxes Employees'); ?></li>
                        	<li><?php echo anchor('employees_status', 'Employees Status'); ?></li>
                        	<li><?php echo anchor('maritals_status', 'Marital Status'); ?></li>
                          <li><?php echo anchor('titles', 'Title');?></li>
                          <li><?php echo anchor('components', 'Component(Gaji)'); ?></li>
                          <li><?php echo anchor('staffs', 'Staff'); ?></li>
                          <li></li>
                        </ul>
                      </li>
                      <li>
                        <a href="#" class="blyellow">Transaction</a>
                        <div class="open"></div>
                        <ul>
                        	<li><?php echo anchor('absensi', 'Absensi')?></li>
                        	<li><?php echo anchor('izin', 'Izin')?></li>
                        	<li><?php echo anchor('cuti', 'Cuti')?></li>
                        </ul>
                      </li>
                      <li><a href="#" class="blorange">Reporting</a></li>
                      <li>
                      	<a href="#" class="blgreen">Config</a>
                      	<div class="open"></div>
                      	<ul>
                        	<li><?php echo anchor('settings', 'Settings'); ?></li>
                        	<li><?php echo anchor('users/index', 'Users'); ?></li>
                        	<li><?php echo anchor('users/roles', 'Roles'); ?></li>
                        </ul>
                      </li>
                      <li><a href="<?php echo site_url('users/logout'); ?>" class="blred">Logout</a></li>
                    </ul>
                </div><!-- // nContainer -->
                <div class="widget">
                    <div class="datepicker"></div>
                </div>
            </div>

