<?php
        require_once "storedCreds.php";
    ?>
<?php
        try 
{
    $pdo = new PDO($stored_database, $stored_user, $stored_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}
catch(PDOException $e)
{
    echo "Connection to database failed: " . $e->getMessage();
}
    ?>
<!DOCTYPE HTML>
<html>

<head>

<title></title>
<meta charset="UTF-8">
<style>

.track-form {
    width: 90%;
    max-width: 400px;
    position: center;
    margin: 0 auto;
    text-align: center;
}

.track-form input {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 2px solid pink;
    border-radius: 8px;
    margin-bottom: 10px;
    box-sizing: border-box;
}

.track-form button {
    margin-top: 10px;
    padding: 10px 16px;
    background-color: hotpink;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}

.track-form button:hover {
    background-color: deeppink;
}

    .top-right-btn {
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

.top-right-btn:hover {
    background-color: deeppink;
    transform: scale(1.05);
}

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
    color: white;
    background-color: hotpink;
        
}

</style>

<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);


$TrackID = session_id(); 

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

        // Insert the order
        $sqlInsert = $pdo->prepare("
            INSERT INTO ORDERS (TrackingID, OrderStatus, Total, CCInfo, ShippingAddr, BillingAddr)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $sqlInsert->execute([
            $TrackID,
            $DefaultStatus,
            $TotalPrice,
            $CreditCard,
            $ShipAdd,
            $BillAdd
        ]);

        session_regenerate_id(true);
        echo $TrackID;

        // Redirect ONLY after successful insert
        header("Location: trackpage.php?success=1");
        exit;
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
<?php if ($TotalPrice > 0): ?>
    <h1 style="text-align:center">THIS WILL BE YOUR TRACKING ID, PLEASE KEEP NOTE OF IT:</h1>
    <h1 style="text-align:center"><?php echo $TrackID; ?></h1>

    <form method="POST" class="track-form">
    <input type="text" placeholder="CC (16 digits)" name="Credit_Card" required>
    <input type="text" placeholder="ShipAddr" name="Ship_Add" required>
    <input type="text" placeholder="BillAddr" name="Bill_Add" required>
    <button type="submit">Place Order</button>

</form>
<?php else: ?>
<p style="color:red; font-size:24px; text-align:center;">
    Your cart is empty — add items before checking out.
</p>
<?php endif; ?>


<a href="https://students.cs.niu.edu/~z1977897/gpstore.php" class="top-right-btn">
    Store Home
</a>
<a href="https://students.cs.niu.edu/~z1977897/trackpage.php" class="top-right-btn2">
    Track Your Package
</a>


</body>

</html>
