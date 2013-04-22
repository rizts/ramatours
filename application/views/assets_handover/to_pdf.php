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

		table.no_border {
			border-style: none;
		}
 
		td.no_border, th.no_border {
			margin: 0;
			padding: 4px;
			border-style: none;
		}
	</style>
	</head>
    <body>
    	<center>
    		<h3>Asset List</h3>
	    	<br />
	    	<table align="center" class="no_border">
	            <tr>
	                <td class="no_border" width="20%">Name</td>
	                <td class="no_border"><div class="span3"> : <?php echo $asset_name; ?></div></td>
	            </tr>
	            <tr>
	                <td class="no_border" width="20%">Code</td>
	                <td class="no_border"><div class="span2"> : <?php echo $asset_code; ?></div></td>
	            </tr>
	            <tr>
	                <td class="no_border">Status</td>
	                <td class="no_border"><div class="span2"> : <?php echo $asset_status; ?></div></td>
	            </tr>
	            <tr>
	            	<td class="no_border">Description</td>
	            	<td class="no_border"><div class="span6"> : <?php echo $description; ?></div></td>
	            </tr>
	        </table>
    	</center>
		<br />
		<table align="center">
            <thead>
                <tr>
                    <th rowspan="2" width="15%">Date</th>
                    <th colspan="2">Staff</th>
                    <th rowspan="2">Document Number</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2" width="30%">Note</th>
                </tr>
                <tr>
                    <th>Yang Menyerahkan</th>
                    <th>Yang Menerima</th>
                </tr>
            </thead>
            <tbody>
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
            <?php
			}
			?>
            </tbody>
		</table>
	</body>
</html>