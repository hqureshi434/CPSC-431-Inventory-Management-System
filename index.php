<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>CPSC 431, Project - IMS</title>
  </head>
  <body>
    <div class="jumbotron text-center" style="padding: 50px; background-color: #778899; color: white;">
      <h1>Inventory Management System</h1>
      <p>Created by Adam Laviguer and Hammad Qureshi</p>
    </div>

    <div class="container" style="margin-top: 25px; max-width: 480px;">
      <?php
        session_start();
        $_SESSION['userType'] = "";
        $_SESSION['userName'] = "";
        $userName = "";
        $password = "";
      ?>
      <h3>Please Log In</h3>
        <form action="./login.php" method="post" enctype="multipart/form-data">
          <div class="form-group" style="padding: 6px;">
            <label for="userName">Username:</label>
            <input type="text" class="form-control" name="userName" id="userName">
          </div>
          <div class="form-group" style="padding: 6px;">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password">
          </div>
          <div class="form-group text-center" style="padding: 6px;">
            <button type="submit" class="btn btn-primary" name="loginBtn">Log In</button>
            <button type="reset" class="btn btn-primary">Reset</button>
          </div>
        </form>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>
