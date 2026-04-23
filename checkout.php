
<!DOCTYPE HTML>
<html>

<head>
<?php
session_start();
echo "Session ID: " . session_id();
?>
<title></title>
<meta charset="UTF-8">
<style>

    
/* ------------------------------
Top Button 2 
 ------------------------------*/
.top-right-btn2 {
    position: fixed;
    top: 60px;
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

.top-right-btn2:hover {
    background-color: deeppink;
    transform: scale(1.05);
}

    .page-wrapper {
    width: 90%;
    max-width: 1000px;
    margin: 30px auto;
    padding-top: .2%;
    padding-left: 3%;
    padding-right: 3%;
    padding-bottom: 3%;
    background: #ffe4f1;
    border-radius: 20px;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2; /* keeps content above side images */
}

body {
    background-color: lavender;
    margin: 0;
    font-family: Arial, sans-serif;
}
.checkout-top {
    background-color: #ffcaeb;
    margin: 10px auto;
    font-size: 75px;
    font-weight: bold;
    padding: 3%;
}    
.checkout {
    margin: 5px auto;
    padding: 3%;
    border-radius: 10px;
}
.checkout-prices {
    
    font-size: 50px;
    color: hotpink;
}
.checkout-total {
    font-size: 75px;
    font-color: white;
    font-weight: bold;
    color: #3cff00;
    background-color: hotpink;
        
}

</style>

<?php
session_start();
echo "Session ID: " . session_id();

ini_set('display_errors', 1);
error_reporting(E_ALL);
/*
=====================CHANGE____CREDS=====================
=====================CHANGE____CREDS=====================
=====================CHANGE____CREDS=====================
=====================CHANGE____CREDS=====================

UPDATE THE CREDENTIALS HERE

=====================CHANGE____CREDS=====================
=====================CHANGE____CREDS=====================
=====================CHANGE____CREDS=====================
=====================CHANGE____CREDS=====================
*/
try {
    $username = "z2054630"; //MAKE UR USERNAME
    $password = "2006Oct12"; // MAKE UR USERNAME
    $dsn = "mysql:host=courses;dbname=z2054630"; // CHANGE Z_ID
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
$TrackID = "T102"; // CORRECT THIS LATER TO PROPER ID!!!!
$TotalPrice = 0.00;
$sqlPrepared = $pdo->prepare("SELECT StuffieID FROM SHOPPINGCART WHERE TrackingID = ?"); //where trackingID = SessionID
$sqlPrepared->execute([$TrackID]);

$sqlPrepared2 = $pdo->prepare('SELECT Price FROM STUFFEDANIMALSTORE WHERE StuffieID = ?');

$StuffieIDs = $sqlPrepared->fetchAll(PDO::FETCH_COLUMN);

$PriceArray = [];

?>
</head>

<body>
<div class="page-wrapper">
    <?php
    $TrackingIdTemp = "T666"; //this wont work. The shopping cart must already have this. 
    $DefaultStatus = "Processing";
    foreach($StuffieIDs as $SID) {
        $sqlPrepared2->execute([$SID]);
        $Price = (float)$sqlPrepared2->fetchColumn();
        $PriceArray[] = number_format($Price, 2, '.', ''); //adds current Price into the array to be used and formatted later
        $TotalPrice += $Price;
        
        
    }
        $FormatTotal = number_format($TotalPrice, 2, '.', '');

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $CreditCard = $_POST["Credit_Card"] ?? "";
    $ShipAdd    = $_POST["Ship_Add"] ?? "";
    $BillAdd    = $_POST["Bill_Add"] ?? "";

    if (!empty($CreditCard) &&
        !empty($ShipAdd) &&
        !empty($BillAdd) &&
        strlen($CreditCard) == 16 &&
        strlen($ShipAdd) <= 128 &&
        strlen($BillAdd) <= 128) {

        $sqlInsert = $pdo->prepare("
            INSERT INTO ORDERS (TrackingID, OrderStatus, Total, CCInfo, ShippingAddr, BillingAddr)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        header("Location: checkout.php?success=1"); //this resets the page so that old php info doesnt get pushed every time it reloads
        exit;
        $sqlInsert->execute([
            $TrackingIdTemp,
            $DefaultStatus,
            $TotalPrice,
            $CreditCard,
            $ShipAdd,
            $BillAdd
        ]);
    }
}

    ?>


    <div class="checkout checkout-prices">
        <div class="checkout-top">
            Checkout Total
    </div>
        <?php

            foreach ($PriceArray as $value){
                echo "$" .  $value . "<br>" . "<p></p>";
            }
        ?>
    </div>

    <div class="checkout checkout-total">
        Total: 
        $<?php echo $FormatTotal?>
    </div>
</div>

<form method="POST">
    <input type="text" placeholder="CC (16 digits)" name="Credit_Card" required>
    <input type="text" placeholder="ShipAddr" name="Ship_Add"  required>
    <input type="text" placeholder="BillAddr" name="Bill_Add" required>
    <button type="submit">Place Order</button>
</form>

<a href="https://students.cs.niu.edu/~z1977897/gpstore.php" class="top-right-btn2">
    My Cart
</a>


</body>

</html>
