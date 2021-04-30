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

    <div class="container text-end" style="margin-top: 25px;">
      <div class="dropdow dropend">
        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <?php 
            session_start();
            echo $_SESSION['userName'];
          ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton1">
          <li><a class="dropdown-item" href="./index.php" type="" id="logout">Log out</a></li>
        </ul>
      </div>
    </div>

    <?php
      session_start();
      if ($_SESSION['userType'] != "inventory") {
        echo "<div class=\"container text-center\" style=\"margin-top: 25px; max-width: 480px;\">
                <h3>You do not have access to that page.<br>Click <a href=\"./index.php\">here</a> to log in.</h3>
              </div>";
      }
      else { ?>
      <div class="container" style="margin-top: 25px;">
        <div class="container d-flex justify-content-end" style="margin-top: 25px;">
          <input class="btn btn-primary" style="margin: 15px;" type="submit" value="Add New Item" id="inputItem" disabled>
          <!-- on click of the button immediately below -->
          <input class="btn btn-primary" style="margin: 15px;" type="submit" value="Change Item Qty" id="inputQty">
          <input class="btn btn-primary" style="margin: 15px;" type="submit" value="Change Item Price" id="inputPrice" disabled>
        </div>
        <div class="container" style="margin-top: 25px;">
          <div class="container border border-dark shadow bg-body rounded" style="margin-top: 25px;">
            <div class="row" style="margin: 10px; padding-bottom: 5px;">
              <div class="col-sm">
                <p>Item Name</p>
              </div>
              <div class="col-sm">
                <label for="itemQty" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="itemQty" value="0.0" required >
              </div>
              <div class="col-sm">
                <label for="itemPrice" class="form-label">Price</label>
                <input type="text" class="form-control" id="itemPrice" value="$0.00" required disabled>
              </div>
              <div class="col-sm text-end">
                <p>Picture</p>
              </div>
            </div>
          </div>
        </div>
      </div> 
    <?php
      }

      //TODO: add code for submitting quantity changes (input from id="itemQty") to the database
      // on click of "inputQty" button, submit query to DB which updates the item qty with the value in the "itemQty" field

    ?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>