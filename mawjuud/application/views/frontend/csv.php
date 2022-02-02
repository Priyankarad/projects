<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="<?php echo site_url();?>cron/fetchUsers" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
    <table>
        <tr>
            <td> Choose your file: </td>
            <td>
                <input type="file" class="form-control" name="userfile" id="userfile"  align="center"/>
            </td>
            <td>
                <div class="col-lg-offset-3 col-lg-9">
                    <button type="submit" name="submit" class="btn btn-info">Save</button>
                </div>
            </td>
        </tr>
    </table> 
</form>
</body>
</html>