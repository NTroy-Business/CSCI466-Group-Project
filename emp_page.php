<!--
Employee Page
Allows the viewer to alter quantity
Table names: ORDERS, STUFFEDANIMALSTORE, REQUESTS, SHOPPINGCART
Allows the viewer to change status of orders
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
            $passwd = "2006Aug30";//Will be changed later

            try{
                $dsn = "mysql:host=courses;dbname={$username}";
                $pdo = new PDO($dsn, $username, $passwd);
                }

            catch(PDOException $e) {
                echo "Connection failed " . $e->getmessage();
                exit();
                }

           #Step 1 Create a list of all the products in a Table format
           $step1 = "SELECT StuffieID, ProductName, ProductSize, Price, InvQty FROM STUFFEDANIMALSTORE;";

           $result1 = $pdo->query($step1);
           $answer1 = $result1->fetchAll(PDO::FETCH_ASSOC);

           echo "<table border='3'>";
           echo "<tr>";


            if (!empty($answer1)) {
                foreach($answer1[0] as $key => $value) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                    }
            }
            echo "</tr>";
            #print rows
                foreach($answer1 as $row) {
                    echo "<tr>";
                foreach($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
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

            $ProductList = $pdo->query("SELECT StuffieID, ProductName FROM STUFFEDANIMALSTORE");
            while( $row = $ProductList->fetch())
                {
                    echo "<option value='{$row['StuffieID']}'>{$row['ProductName']}</option>";
                    }
                
            echo "</select>";

        echo "<br/>";
        echo "How Many of That Specific Item to Restock?<input type='number' name='qty'>";

        echo "<input type='submit' name='step2' value='Add to InvQty'>";
    echo "</form>";

#Check if there was an answer submitted
if (isset($_POST['step2']) && isset($_POST['qty'])) {
    $product = $_POST['product'] ?? null;

    $check = true;

    $qty = filter_input(INPUT_POST, 'qty', FILTER_VALIDATE_INT);

    if($qty === false || $qty === null) {
        echo "<p style='color:red'>Invalid Qty Input</p>";
        $check = false;
        }
    
    if(!$product) {
        echo "No Product Selected";
        $check = false;
    }
    
if($check) {
    $checkStmt = $pdo->prepare("SELECT InvQty FROM STUFFEDANIMALSTORE WHERE StuffieID = ?");
    $checkStmt->execute([$product]);
    $answer2 = $checkStmt->fetch(PDO::FETCH_ASSOC);


        if(!$answer2) {
        echo "Invalid Request";
        }
    else {

        if($qty <= 0) {
            echo "<p style='color:red'>Invalid Qty amount</p>";
            $check = false;
            }
        else if($qty > 9999) {
            echo "<p style='color:red'>Invalid Qty amount exceeds InvQty</p>";
            $check = false;
            }
        else { 
            
            $updateSql = $pdo->prepare("UPDATE STUFFEDANIMALSTORE SET InvQty = InvQty + ? WHERE StuffieID = ?");
            $updateSql->execute([$qty, $product]);
            echo "<p style='color:green;'>Update complete</p>";

            $resultStmt = $pdo->prepare("SELECT ProductName, InvQty FROM STUFFEDANIMALSTORE WHERE StuffieID = ?");
            $resultStmt->execute([$product]);
            $updatedQTY = $resultStmt->fetch(PDO::FETCH_ASSOC);

            $qty = $updatedQTY['InvQty'];
            $ProductName = $updatedQTY['ProductName'];

            echo "<p><b>Product: $ProductName now has QTY of: $qty</b></p>";
                }
            }
        }
    }

    #Step 3 Create a display of all Orders

     $step3 = "SELECT TrackingID, OrderStatus, ShippingAddr, BillingAddr FROM ORDERS;";

           $result3 = $pdo->query($step3);
           $answer3 = $result3->fetchAll(PDO::FETCH_ASSOC);

           echo "<table border='3'>";
           echo "<tr>";


            if (!empty($answer3)) {
                foreach($answer3[0] as $key => $value) {
                    echo "<th>" . htmlspecialchars($key) . "</th>";
                    }
            }
            echo "</tr>";
            #print rows
                foreach($answer3 as $row) {
                    echo "<tr>";
                foreach($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
            echo "</tr>";
        }

      echo "</table>";
    

    #Step 4 Change the Order Status accordingly    
?>      
<h2><b>Update order status of any order</b></h2>
    <form method="POST">
        <label>Select an order:</label>
            <select name="order">
                <?php
                    $orderlist = $pdo->query("SELECT TrackingID FROM ORDERS");
                    $count = 0;
                    while ($row = $orderlist->fetch()) 
                    {
                        $count++;
                        echo "<option value='{$row['TrackingID']}'>Order $count</option>";
                        
                    }
                ?>
            </select>

            <label><b>Select a status:</b></label>
            <select name="status">
                <?php
                    $orderstatus = $pdo->query("SELECT DISTINCT OrderStatus FROM ORDERS");
                    while ($row = $orderstatus->fetch()) 
                    {
                        echo "<option value='{$row['OrderStatus']}'>{$row['OrderStatus']}</option>";
                    }
                ?>
            </select>

        <input type="submit" name="submitupdateorder" value="update order">
    </form>
    <?php
        if (isset($_POST['submitupdateorder'])) {
        $order = $_POST['order'];
        $status = $_POST['status'];

        $update = $pdo->prepare("UPDATE ORDERS SET OrderStatus = ? WHERE TrackingID = ?");
        $update->execute([$status, $order]);

        echo "<p style='color:green;'><b>Order Updated!</b></p>";
            }
    ?>
        
        
        <!-- Step 4 Make a image to return -->
        <style>
            .store-button {
                position: fixed;
                top: 15px;
                right: 15px;
                
                background-color: hotpink;
                color: white;

                padding: 10px 16px;
                border-radius: 10px;

                text-decoration: none;
                font-weight: bold;

                z-index: 999; /* stays above everything */
                box-shadow: 0px 4px 10px rgba(0,0,0,0.2);
                transition: 0.3s ease;

   
                width: 100px;
                max-width: 200px;
                text-align: center;
}
            
.store-button:hover {
    background-color: deeppink;
    transform: scale(1.05);
}

            
        </style>
        
        <a href="https://students.cs.niu.edu/~z1977897/gpstore.php" class="store-button">
            Store Home
        </a>
        
    </body>
</html>
