<?php

$id=$_GET['id'];

  $sql = "DELETE FROM projects WHERE id_project = '$id';";
  $conn->query($sql);
  $sql = "DELETE FROM project_users WHERE id_project = '$id';";
  $conn->query($sql);

 header("Location: index.php?action=projects");
 ?>
