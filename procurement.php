<?php ini_set('display_errors', 1); ?>

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
      <div class="dropdown dropend">
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
      if ($_SESSION['userType'] != "procurement") {
        echo "<div class=\"container text-center\" style=\"margin-top: 25px; max-width: 480px;\">
                <h3>You do not have access to that page.<br>Click <a href=\"./index.php\">here</a> to log in.</h3>
              </div>";
      }
      else { 
        $_SESSION['currentPage'] = "procurement"; //using a "current page" session variable to track which page the user came from after udpating the database
        ?>
      <div class="container" style="margin-top: 25px;">
        <div class="row">
          <div class="col">
            <?php
              //REFER TO GALLERY.PHP (ASSIGNMENT 2) TO PROPERLY DISPLAY THE NAME, QTY, AND PRICE FOR THE DIV CONTAINER
              //NAME AND VALUES NEEDS TO BE STORED IN GLOBAL ARRAY AND ITERATED THROUGH A FOR LOOP

              function ArrayData() {
                $db = new mysqli('mariadb', 'cs431s1', 'oong3aiK', 'cs431s1');
                if (mysqli_connect_errno()) {
                  echo '<p>Error: Could not connect to database.<br/>
                  Please try again later.</p>';
                  exit;
                }
            
                $query = mysqli_query($db, "SELECT * FROM IMSitem");

                $largeArr = array();
                //Look through each row in the table
                while($itemRow = mysqli_fetch_assoc($query)){
                  //Adds each row into the array
                  $largeArr[] = $itemRow;
                }
                return $largeArr;
              }
            
              $array = ArrayData();
              $len = count($array);
              for($row2 = 0; $row2 < $len; $row2++) {
                $iName = $array[$row2]['itemName'];
                $iPrice = $array[$row2]['itemPrice'];
                $iQty = $array[$row2]['itemQty'];
                $iPic = $array[$row2]['itemPic'];
                ?>
                <div class="container" style="">
                  <div class="container border border-dark shadow bg-body rounded" style="margin-top: 25px; margin-bottom: 25px;">
                    <div class="row" style="margin: 10px; padding-bottom: 5px;">
                      <div class="col-sm">
                        <p><b>Item Name</b><br><?php echo $iName;?></p>
                      </div>
                      <div class="col-sm">
                        <p><b>Quantity</b><br><?php echo $iQty;?></p>
                      </div>
                      <div class="col-sm">
                        <p><b>Price</b><br><?php echo "$".$iPrice;?></p>
                      </div>
                      <div class="col-sm">
                        <p><b>Picture</b></p>
                        <div class="thumbnail border border-1 border-dark">
                          <img src="./photoUploads/<?php echo $iPic ?>" alt="..." style="width:100%">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                ;
              }
            ?>
          </div>

          <div class="col">
            <div class="container d-flex justify-content-end" style="">
              <form action="updateDB.php" method="post" enctype="multipart/form-data">
                <div class="container" style="margin-top: 25px;">
                  <div class="container border border-dark shadow bg-body rounded" style="margin-top: 25px;">
                    <input class="btn btn-primary" style="margin: 15px;" type="submit" value="Add New Item" id="inputItem" name="inputItem">
                    <div class="row" style="margin: 10px; padding-bottom: 5px;">
                      <div class="col-sm">
                        <label for="itemName" class="form-label"><b>Item Name</b></label>
                        <input type="text" class="form-control" id="itemName" name="itemName" value="" required >
                      </div>
                      <div class="col-sm">
                        <label for="itemQty" class="form-label"><b>Quantity</b></label>
                        <input type="number" class="form-control" id="itemQty" name="itemQty" value="" required >
                      </div>
                      <div class="col-sm">
                        <label for="itemPrice" class="form-label"><b>Price</b></label>
                        <input type="number" class="form-control" id="itemPrice" name="itemPrice" value="" required >
                      </div>
                    </div>
                    <div class="row" style="margin: 10px; padding-bottom: 5px;">
                      <div class="col-sm">
                        <label for="itemPic" class="form-label"><b>Picture</b></label>
                        <input type="file" class="form-control" name="itemPic" id="itemPic" required>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="container d-flex justify-content-end" style="">
              <form action="updateDB.php" method="post" enctype="multipart/form-data">
                <div class="container" style="margin-top: 25px;">
                  <div class="container border border-dark shadow bg-body rounded" style="margin-top: 25px;">
                    <input class="btn btn-primary" style="margin: 15px;" type="submit" value="Change Item Price" id="inputPrice" name="inputPrice">
                    <div class="row" style="margin: 10px; padding-bottom: 5px;">
                      <div class="col-sm">
                        <label for="itemName" class="form-label"><b>Item Name</b></label>
                        <input type="text" class="form-control" id="itemName" name="itemName" value="" required >
                      </div>
                      <div class="col-sm">
                        <label for="itemPrice" class="form-label"><b>Price</b></label>
                        <input type="number" class="form-control" id="itemPrice" name="itemPrice" value="" required >
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <div class="container d-flex justify-content-end" style="">
              <form action="updateDB.php" method="post" enctype="multipart/form-data">
                <div class="container" style="margin-top: 25px;">
                  <div class="container border border-dark shadow bg-body rounded" style="margin-top: 25px;">
                    <input class="btn btn-danger" style="margin: 15px;" type="submit" value="Delete Item" id="deleteItem" name="deleteItem">
                    <div class="row" style="margin: 10px; padding-bottom: 5px;">
                      <div class="col-sm">
                        <label for="itemName" class="form-label"><b>Item Name</b></label>
                        <input type="text" class="form-control" id="itemName" name="itemName" value="" required >
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div> 
    <?php
      }
    ?>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  </body>
</html>