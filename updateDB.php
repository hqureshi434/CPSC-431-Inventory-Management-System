

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>CPSC 431, Project - IMS</title>
  </head>
  <body>
    <div class="jumbotron text-center" style="padding: 50px; background-color: #778899; color: white;">
      <h1>Inventory Management System</h1>
      <p>Created by Adam Laviguer and Hammad Qureshi</p>
    </div>

    <script>
      $(document).ready(function(){
          $("#noItemFound").modal('show');
      });
    </script>

    <div class="container text-start" style="margin-top: 25px;">
        <?php
            session_start();
            $itemName = (string) $_POST['itemName']; //Get the name from the textbox
            $itemQty = (int) $_POST['itemQty']; //Get the quantity from the textbox
            $itemPrice = (float) $_POST['itemPrice']; //Get the price from the textbox
            $itemPic = "";

            $db2 = new mysqli('mariadb', 'cs431s1', 'oong3aiK', 'cs431s1');
            if ($db2->connect_errno) {
                echo "<p>Error: Could not connect to database.<br>Please try again later.</p>";
                exit;
            }
            else {
              //echo "Successful DB connection.<br>";
            }

            if(isset($_POST['inputQty'])){
              if (itemCheck($db2, $itemName) === TRUE) {
                updateItemQty($db2, $itemName, $itemQty);
              }
            }

            if(isset($_POST['inputPrice'])){
              if (itemCheck($db2, $itemName) === TRUE) {
                updateItemPrice($db2, $itemName, $itemPrice);
              }
            }

            if(isset($_POST['inputItem'])){
              if (itemCheck($db2, $itemName) === TRUE) {
                addItem($db2, $itemName, $itemQty, $itemPrice, $itemPic);
              }
            }

            function updateItemQty($db2, $itemName, $itemQty) {
                if ($db2->query("UPDATE IMSitem SET itemQty = '".$itemQty."' WHERE itemName = '".$itemName."'") === TRUE) {
                  echo "The updated quanitity has been pushed to the server.<br>";
                }
                else {
                  sleep(2);
                  echo "An error has occurred.<br>The updated quantity was not pushed.";
                }
                //IF statements to return the user to the appropriate page
                if ($_SESSION['currentPage'] == "inventory") { //if the user was last on the Inventory.php page, return them there
                  header("Location: ./inventory.php");
                }
                else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                  header("Location: ./manager.php");
                }
            }

            function updateItemPrice($db2, $itemName, $itemPrice) {
              if ($db2->query("UPDATE IMSitem SET itemPrice = '".$itemPrice."' WHERE itemName = '".$itemName."'") === TRUE) {
                  echo "The updated price has been pushed to the server.<br>";
              }
              else {
                  echo "An error has occurred.<br>The updated price was not pushed.";
              }

              //IF statements to return the user to the appropriate page
              if ($_SESSION['currentPage'] == "procurement") { //if the user was last on the Procurement.php page, return them there
                header("Location: ./procurement.php");
              }
              else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                header("Location: ./manager.php");
              }
            }

            function addItem($db2, $itemName, $itemQty, $itemPrice) {
              if ($db2->query("INSERT IMSitem SET itemPrice = '".$itemPrice."' WHERE itemName = '".$itemName."'") === TRUE) {
                  //echo "The updated price has been pushed to the server.<br>";
              }
              else {
                  echo "An error has occurred.<br>The item was not added.";
              }

              //IF statements to return the user to the appropriate page
              if ($_SESSION['currentPage'] == "procurement") { //if the user was last on the Procurement.php page, return them there
                header("Location: ./procurement.php");
              }
              else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                header("Location: ./manager.php");
              }
            }

            function itemCheck($db2, $itemName) {
              if (mysqli_num_rows($db2->query("SELECT itemName FROM IMSitem WHERE itemName = '".$itemName."'")) > 0) {
                return TRUE;
              }
              else {
                //IF statements to return the user to the appropriate page
                if ($_SESSION['currentPage'] == "procurement") { //if the user was last on the Procurement.php page, return them there
                  $page = "./procurement.php";
                }
                else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                  $page = "./manager.php";
                }
                else if ($_SESSION['currentPage'] == "inventory") { //if the user was last on the Inventory.php page, return them there
                  $page = "./inventory.php";
                }
                ?>
                <!-- Modal -->
                <div class="modal fade" id="noItemFound" tabindex="-1" aria-labelledby="noItemFound" aria-hidden="true"  data-bs-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="noItemFound">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Item not found.<br>Please enter an Item Name that already exists, or add a new item.
                      </div>
                      <div class="modal-footer">
                        <a href="<?php echo $page ?>" type="button" class="btn btn-primary">Back</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
              }
            }
          ?>
    </div>


    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>