<!DOCTYPE html>
<html lang="en">
	<head>
	<style type="text/css">
		table {
			border-width: 0 0 1px 1px;
			border-spacing: 0;
			border-collapse: collapse;
			border-style: solid;
		}
 
		td, th {
			margin: 0;
			padding: 4px;
			border-width: 1px 1px 0 0;
			border-style: solid;
		}
	</style>
	</head>
    <body>
    	<center>
    		<h3>Asset List</h3>
    	</center>
      	<table width="50%" align="center">
      		<?php
      		if ($this->input->get('branch') != "") {
      		?>
  			<tr>
  				<td>Branch</td>
 				<td><?php echo $this->input->get('branch'); ?></td>
			</tr>
      		<?php
      		}
      		if ($this->input->get('asset_name') != "") {
      		?>
  			<tr>
  				<td>Name</td>
 				<td><?php echo $this->input->get('asset_name'); ?></td>
			</tr>
      		<?php
      		}
      		?>
      	</table>
    	<br />
		<table align="center">
		    <thead>
                <tr>
                    <th rowspan="2">Name</th>
                    <th rowspan="2">Code</th>
                    <th rowspan="2">Branch</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Tgl. Beli</th>
                    <th rowspan="2">Tgl. Tempo</th>
                    <th colspan="2">Terakhir digunakan</th>
                </tr>
                <tr>
                    <th>Staff</th>
                    <th>Date</th>
                </tr>
            </thead>
		    <tbody>
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
                  </tr>
         	   	<?php
				}
				?>
      		</tbody>
		</table>
	</body>
</html>