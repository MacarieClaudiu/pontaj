<?php

if(!isset($_SESSION['id'])){
     header("Location: index.php?action=login");
}
if($_SESSION['type'] == 1){
  header("Location: index.php?action=welcome");
}

$id= $_SESSION['id'];

$sql= "SELECT * FROM `users` WHERE id_user= '$id';";

   $result = $conn->query($sql);
   $record = $result->fetch_assoc();

?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="nav nav-pills">

            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php?action=hours">Hours</a>
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
    <div class="modal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button
              type="button"
              class="btn-close"
              data-mdb-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <p>Modal body text goes here.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
              Close
            </button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-success table-striped">
      <thead>
        <tr>
          <th scope="col">Project</th>
          <th scope="col">Monday</th>
          <th scope="col">Tuesday</th>
          <th scope="col">Wednesday</th>
          <th scope="col">Friday</th>
          <th scope="col">Thursday</th>
          <th scope="col">Saturday</th>
          <th scope="col">Sunday</th>
        </tr>
      </thead>

      <tbody>

      </tbody>

      </table>
