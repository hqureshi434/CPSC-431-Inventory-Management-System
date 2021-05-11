<?php ini_set('display_errors', 1); ?>

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
          $("#itemFound").modal('show');
      });
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
            $itemPic = (string) $_FILES['itemPic']['name'];

            $db2 = new mysqli('mariadb', 'cs431s1', 'oong3aiK', 'cs431s1');
            if ($db2->connect_errno) {
                echo "<p>Error: Could not connect to database.<br>Please try again later.</p>";
                exit;
            }
            else {
              //echo "Successful DB connection.<br>";
            }

            if(isset($_POST['inputQty'])){
              if (itemExists($db2, $itemName) === TRUE) {
                updateItemQty($db2, $itemName, $itemQty);
              }
            }

            if(isset($_POST['inputPrice'])){
              if (itemExists($db2, $itemName) === TRUE) {
                updateItemPrice($db2, $itemName, $itemPrice);
              }
            }

            if(isset($_POST['inputItem'])){
              if (itemNotFound($db2, $itemName) === TRUE) {
                addItem($db2, $itemName, $itemQty, $itemPrice, $itemPic);
                uploadPhoto($itemPic);
              }
            }

            if(isset($_POST['deleteItem'])){
              if (itemExists($db2, $itemName) === TRUE) {
                deleteItem($db2, $itemName);
              }
            }

            function updateItemQty($db2, $itemName, $itemQty) {
                $sql = "UPDATE IMSitem SET itemQty = ? WHERE itemName = ?";
                $stmt = $db2->prepare($sql);
                $stmt->bind_param('ds', $itemQty, $itemName);
                $stmt->execute();

                if($stmt->error){
                  sleep(2);
                  echo "An error has occurred.<br>The updated quantity was not pushed." . $stmt->error;
                }
                else{
                  echo "The updated quanitity has been pushed to the server.<br>";
                }
                /*
                if ($db2->query("UPDATE IMSitem SET itemQty = '".$itemQty."' WHERE itemName = '".$itemName."'") === TRUE) {
                  echo "The updated quanitity has been pushed to the server.<br>";
                }
                else {
                  sleep(2);
                  echo "An error has occurred.<br>The updated quantity was not pushed.";
                }*/

                //IF statements to return the user to the appropriate page
                if ($_SESSION['currentPage'] == "inventory") { //if the user was last on the Inventory.php page, return them there
                  header("Location: ./inventory.php");
                }
                else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                  header("Location: ./manager.php");
                }
                
            }

            function updateItemPrice($db2, $itemName, $itemPrice) {
              $sql = "UPDATE IMSitem SET itemPrice = ? WHERE itemName = ?";
              $stmt = $db2->prepare($sql);
              $stmt->bind_param('ds', $itemPrice, $itemName);
              $stmt->execute();

              if($stmt->error){
                sleep(2);
                echo "An error has occurred.<br>The updated price was not pushed." . $stmt->error;
              }
              else{
                echo "The updated price has been pushed to the server.<br>";
              }

              /*
              if ($db2->query("UPDATE IMSitem SET itemPrice = '".$itemPrice."' WHERE itemName = '".$itemName."'") === TRUE) {
                  echo "The updated price has been pushed to the server.<br>";
              }
              else {
                  echo "An error has occurred.<br>The updated price was not pushed.";
              }*/

              //IF statements to return the user to the appropriate page
              if ($_SESSION['currentPage'] == "procurement") { //if the user was last on the Procurement.php page, return them there
                header("Location: ./procurement.php");
              }
              else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                header("Location: ./manager.php");
              }
            }

            function addItem($db2, $itemName, $itemQty, $itemPrice, $itemPic) {
              $sql = "INSERT INTO IMSitem VALUES (?, ?, ?, ?)";
              $stmt = $db2->prepare($sql);
              $stmt->bind_param('sdds', $itemName, $itemQty, $itemPrice, $itemPic);
              $stmt->execute();

              if($stmt->error){
                sleep(2);
                echo "An error has occurred.<br>The item was not added." . $stmt->error;
              }
              else{
                echo "The new item has been pushed to the server.<br>";
              }

              /*
              if ($db2->query("INSERT INTO IMSitem VALUES ('".$itemName."','".$itemQty."','".$itemPrice."','".$itemPic."')") === TRUE) {
                  echo "The new item has been pushed to the server.<br>";
              }
              else {
                  echo "An error has occurred.<br>The item was not added.";
              }*/

              //IF statements to return the user to the appropriate page
              if ($_SESSION['currentPage'] == "procurement") { //if the user was last on the Procurement.php page, return them there
                header("Location: ./procurement.php");
              }
              else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                header("Location: ./manager.php");
              }
            }

            function uploadPhoto($itemPic) {
              $target_dir = "photoUploads/";
              $target_file = $target_dir . basename($_FILES["itemPic"]["name"]);
              $uploadOk = 1;
              $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

              // Check if image file is a actual image or fake image
              $check = getimagesize($_FILES["itemPic"]["tmp_name"]);
              if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
              } else {
                echo "File is not an image.";
                $uploadOk = 0;
              }

              // Check if file already exists
              if (file_exists($target_file)) {
                echo "Sorry, file already exists.<br>";
                $uploadOk = 0;
              }

              // // Check file size
              // if ($_FILES["fileToUpload"]["size"] > 500000) {
              //   echo "Sorry, your file is too large.";
              //   $uploadOk = 0;
              // }

              // Allow certain file formats
              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
              && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
              }

              // Check if $uploadOk is set to 0 by an error
              if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
              // if everything is ok, try to upload file
              } else {
                if (move_uploaded_file($_FILES["itemPic"]["tmp_name"], $target_file)) {
                  echo "The file ". htmlspecialchars( basename( $_FILES["itemPic"]["name"])). " has been uploaded.";
                } else {
                  echo "Sorry, there was an error uploading your file.<br>";
                }
              }
            }

            function deleteItem($db2, $itemName) {
              /*
              $deleteImg = $db2->query("SELECT itemPic FROM IMSitem WHERE itemName = '".$itemName."'");
              $sql = "DELETE FROM IMSitem WHERE itemName = ?"
              $stmt = $db2->prepare($sql);
              $stmt->bind_param('s', $itemName);
              $stmt->execute();
              if($stmt->error){
                sleep(2);
                echo "An error has occurred.<br>The item was not removed." . $stmt->error;
              }
              else{
                echo "The item has been removed from the server.<br>";
                while ($delete = $deleteImg->fetch_assoc()) {
                  unlink("photoUploads/".$delete['itemPic']);
                }
              }*/

              $deleteImg = $db2->query("SELECT itemPic FROM IMSitem WHERE itemName = '".$itemName."'");
              if ($db2->query("DELETE FROM IMSitem WHERE itemName = '".$itemName."'") === TRUE) {
                echo "The new item has been removed from the server.<br>";
                while ($delete = $deleteImg->fetch_assoc()) {
                  unlink("photoUploads/".$delete['itemPic']);
                }
              }
              else {
                  echo "An error has occurred.<br>The item was not removed.";
              }

              //IF statements to return the user to the appropriate page
              if ($_SESSION['currentPage'] == "procurement") { //if the user was last on the Procurement.php page, return them there
                header("Location: ./procurement.php");
              }
              else if ($_SESSION['currentPage'] == "manager") { //if the user was last on the Manager.php page, return them there
                header("Location: ./manager.php");
              }
            }

            function itemExists($db2, $itemName) {
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
                <div class="modal fade" id="itemFound" tabindex="-1" aria-labelledby="itemFound" aria-hidden="true"  data-bs-backdrop="static">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="itemFound">Error</h5>
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

            function itemNotFound($db2, $itemName) {
              if (mysqli_num_rows($db2->query("SELECT itemName FROM IMSitem WHERE itemName = '".$itemName."'")) === 0) {
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
                        Item already found.<br>Please enter an Item Name that does not exist.
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