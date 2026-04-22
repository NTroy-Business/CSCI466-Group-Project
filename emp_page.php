<!--
Employee Page
Allows the viewer to alter quantity
Table names: Order, StuffedAnimalStore, Requests, ShoppingCart
-->

<html>
    <head>
        <title>Employee Page Stuffie Store</title>
    </head>
    <body>
        <h1><b>All Products:</b></h1>

        <?php

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            $username = "z2015929";//Will be changed later
            $passwd = "?????";//Will be changed later

            try{
                $dsn = "mysql:host=courses;dbname={$username}";
                $pdo = new PDO($dsn, $username, $passwd);
                }

            catch(PDOexception $e) {
                echo "Connection failed " . $e->getmessage();
                exit();
                }

           #Step 1 Create a list of all the products in a Table format
           $step1 = "SELECT StuffieID, Name, Price, InvQty FROM STUFFEDANIMALSTORE;";

           $result1 = $pdo->query($step1);
           $answer1 = $result1->fetchAll(PDO::FETCH_ASSOC);

           echo "<table border='3'>";
           echo "<tr>";



                foreach($answer1[0] as $key => $value) {
                    echo "<th>ID</th>";
                    }
            #print rows
                foreach($answer1 as $row) {
                    echo "<tr>";
                foreach($row as $value) {
                    echo "<td>$value</td>";
                    }
            echo "</tr>";
        }

      echo "</table>";

       #Step 2 Allow the user to alter the InvQty of the products
       echo "<h1><b>Alter The QTY of Any Product!</b></h1>";

    echo "<br/>";
        echo "<form method='POST'>";
            echo "<label>Choose a Product:</label>";
            echo "<select name='product' id='product'>";

            $ProductList = $pdo->query("SELECT StuffieID, name FROM STUFFEDANIMALSTORE");
            while( $row = $ProductList->fetch())
                {
                    echo "<option value='{$row['StuffieID']}'>{$row['name']}</option>";
                    }
                
            echo "</select>";

        echo "<input type="submit" name="submit" value="Show Products">";

        echo "</select>";
        echo "<br/>";
        echo "How Many of That Specific Item to Restock?<input type='number' name='qty'>";

        echo "<input type='submit' name='step3' value='Confirm'>";
    echo "</form>";

#Check if there was an answer submitted
if (isset($_POST['step3'])) && isset($_POST['qty'])) {
    $product = $_POST['product'];
    $qty = isset($_POST['qty']) ? $_POST['qty'] : null;

    $checkStmt = $pdo->prepare("SELECT InvQty FROM STUFFEDANIMALSTORE WHERE StuffieID = ?");
    $checkStmt->execute([$product]);
    $answer3 = $checkStmt->fetch(PDO::FETCH_ASSOC);


        if(!$answer3) {
        echo "Invalid Request";
        }
    else {

        $currentQTY = $answer3['InvQty'];

        if($qty <= 0) {
            echo "Invalid Qty amount";
            }
        else if($qty > 9999) {
            echo "Invalid Qty amount exceeds InvQty";
            }
        else {
            $updateSql = $pdo->prepare("UPDATE InvQty SET InvQty = InvQty + ? WHERE StuffieID = ?");
            $updateSql->execute([$qty, $product]);
            echo "<p>Update complete</p>";

            $resultStmt = $pdo->prepare("SELECT ProductName, InvQty FROM STUFFEDANIMALSTORE WHERE StuffieID = ?");
            $resultStmt->execute([$product]);
            $updatedQTY = $resultStmt->fetch(PDO::FETCH_ASSOC);

            $qty = $updatedQTY['InvQty'];
            $ProductName = $_POST['ProductName'];

            echo "<p>Product: $ProductName now has QTY of: $qty</p>";

            }
        }
    }

    #Step 3 Create a display of all Orders and change the Order Status accordingly
?>      
<h2>Update order status of any order</h2>
    <form method="POST">
        <label>Select an order:</label>
            <select name="order">
                <?php
                    $orderlist = $pdo->query("SELECT TrackingID FROM ORDERS");
                    $count = 0;
                    while ($row = $orderlist->fetch()) 
                    {
                        echo "<option value='{$row['TrackingID']}'>Order ++$count</option>";
                        
                    }
                ?>
            </select>

            <label>Select a status:</label>
            <select name="status">
                <?php
                    $orderstatus = $pdo->query("SELECT OrderStatus FROM ORDERS");
                    while ($row = $orderstatus->fetch()) 
                    {
                        echo "<option value='{$row['OrderStatus']}'>{$row['OrderStatus']}</option>";
                    }
                ?>
            </select>

        <input type="submit" name="submitupdateorder" value="update order">

    </body>
</html>
