<?php

if(!isset($_SESSION['id'])){
     header("Location: index.php?action=login");
}
if($_SESSION['type'] == 2){
  header("Location: index.php?action=user");
}

$id= $_SESSION['id'];

$sql= "SELECT * FROM `users` WHERE id_user= '$id';";

   $result = $conn->query($sql);
   $record = $result->fetch_assoc();

   if (isset($_GET['page'])){
     $page = $_GET['page'];
   }else{
     $page = 1;
   }

   $limit = 10;
   $start = ($page-1) * $limit;

?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link" href="index.php?action=welcome">Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php?action=projects">Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php?action=hours">Hours</a>
            </li>

          </ul>
        </div>
        <div id ="logout" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle"  href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $record['firstname']; ?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="index.php?action=logout">Log out</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="">
      <a class="btn btn-success" href="index.php?action=add-project" role="button">Add project</a>
    </div>
    <table class="table table-success table-striped">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Project Name</th>
          <th scope="col ">Manager</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>

<?php

  $sql1 = "SELECT * FROM `projects`";
  $res = $conn->query($sql1);
  $total = $res->num_rows;
  $totalpages= ceil($total/$limit);

$sql = "SELECT projects.id_project, projects.project_name, projects.manager_id, users.lastname, users.firstname
        FROM `projects`
        LEFT JOIN users ON
        projects.manager_id = users.id_user ORDER BY projects.id_project
        limit $start, $limit;";

        $result = $conn->query($sql);

         if ($result->num_rows > 0) {

              $x = 1;

             while (
                     $record = $result->fetch_assoc()
                 ) {

  ?>
            <tr>
              <td> <?php echo $x; $x++ ; ?></td>
              <td> <?php echo $record['project_name'];?></td>
              <td> <?php
              if (isset($record['manager_id']) AND $record['manager_id'] > 0) {
                echo $record['lastname'].' '.$record['firstname'];
              }else{
                echo "-";
              }

              ?></td>

              <td>
                <button id="btnGroupDrop1" type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  Edit/Delete
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <li><a class="dropdown-item" href="index.php?action=edit-project&id=<?php echo $record['id_project']; ?>">Edit</a></li>
                  <li><a class="dropdown-item" href="index.php?action=delete-project&id=<?php echo $record['id_project']; ?>">Delete</a></li>
                </ul>

              </td>
            </tr>

<?php }
}else{
  echo "There is no project";
}
 ?>

      </tbody>
    </table>

    <nav aria-label="Page navigation example">
      <ul class="pagination">

        <li class="page-item">

        <?php for($page = 1; $page<= $totalpages; $page++) { ?>

        <a class="page-link" href="index.php?action=projects&page=<?php echo $page; ?>"><?php echo $page; ?></a></li>

        <?php } ?>

        </li>


      </ul>
    </nav>
