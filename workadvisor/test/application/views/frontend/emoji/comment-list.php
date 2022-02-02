<?php
require_once ("db.php");
$record_set = array();
$sql = "SELECT * FROM tbl_comment ORDER BY parent_comment_id asc, comment_id asc";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($record_set, $row);
    }
}
echo json_encode($record_set);
?>