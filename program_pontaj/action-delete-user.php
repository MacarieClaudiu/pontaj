<?php
$id = $_GET['id'];

$sql= "SELECT manager_id FROM `projects` where manager_id = '$id';";
$result = $conn->query($sql);
$record = $result->fetch_assoc();

if($record['manager_id'] == false ){
  $sql = "DELETE FROM users WHERE id_user = '$id';";
  $conn->query($sql);
}

 header("Location: index.php?action=welcome");
 ?>
