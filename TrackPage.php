<!DOCTYPE HTML>
<html>
<head>

<title>TrackingPage</title>
<meta charset="UTF-8">

<style>

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
}

.top-right-btn:hover {
    background-color: deeppink;
    transform: scale(1.05);
}
    .side-ad {
    position: fixed;
    top: 10%;              /* pushes them down a bit */
    width: 110px;          /* narrow like ads */
    height: 75vh;          /* NOT full page height */
    object-fit: cover;
    z-index: 0;
    opacity: 0.85;
    border-radius: 10px;
}

.ad-left {
    pointer-events: none;
    left: 10px;   /* space from edge */
}

.ad-right {
    pointer-events: none;
    right: 10px;  /* space from edge */
}
/* =======================
   PAGE WRAPPER
======================= */
body {
    background-color: lavender;
    margin: 0;
    font-family: Arial, sans-serif;
}

.page-wrapper {
    width: 90%;
    max-width: 1000px;
    margin: 30px auto;
    padding: 3%;
    background: #ffe4f1;
    border-radius: 20px;
    box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    position: relative;
    z-index: 2; /* keeps content above side images */
}

/* =======================
   HEADER
======================= */
h1 {
    text-align: center;
    color: hotpink;
    margin-bottom: 20px;
}

/* =======================
   FORM
======================= */
.track-form {
    width: 90%;
    max-width: 400px;
    margin: 0 auto;
    text-align: center;
}

.track-form input {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 2px solid pink;
    border-radius: 8px;
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

/* =======================
   IMAGE GALLERY
======================= */
.gallery {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 3%;
    margin-top: 30px;
}

.img-box {
    width: 22%;
    max-width: 200px;
    height: 28%;
    max-height: 255px;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    transition: 0.3s ease;
}

/* =======================
   MOBILE
======================= */
@media (max-width: 1000px) {
    .img-box {
        width: 80%;
        max-width: none;
    }
      .side-ad {
        display: none !important;
    }

    .page-wrapper {
        width: 95%;
        margin: 20px auto;
    }
}
</style>

<?php
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
    $username = ""; //MAKE UR USERNAME
    $password = ""; // MAKE UR USERNAME
    $dsn = "mysql:host=courses;dbname=z2054630"; // CHANGE Z_ID
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

/* =======================
   GET ORDER DATA
======================= */
$order = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $trackingID = $_POST["Track_ID"] ?? "";

    if (!empty($trackingID) && strlen($trackingID) <= 64) {

        $stmt = $pdo->prepare("
            SELECT TRACKING_ID, OrderStatus, Total 
            FROM ORDERS 
            WHERE TRACKING_ID = ?
        ");

        $stmt->execute([$trackingID]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

/* =======================
   TRACKING LOGIC
======================= */
$status = $order["OrderStatus"] ?? "";

function activeStep($status, $steps) {
    return in_array($status, $steps)
        ? "filter: hue-rotate(90deg) saturate(1.5);"
        : "opacity: 0.3;";
}
?>

</head>

<body>
<img class="side-ad ad-left" src="https://cdn.discordapp.com/attachments/1256462561063342142/1496000019118161971/images.png?ex=69e84a16&is=69e6f896&hm=30c21908e9b468fe398875c588a3590f1c140bfceea83cbb6856b0197a2b3bff&">
<img class="side-ad ad-right" src="https://cdn.discordapp.com/attachments/1256462561063342142/1496000019118161971/images.png?ex=69e84a16&is=69e6f896&hm=30c21908e9b468fe398875c588a3590f1c140bfceea83cbb6856b0197a2b3bff&">
<div class="page-wrapper">

    <h1>TRACK YOUR ORDER</h1>

    <form method="POST" class="track-form">
        <input type="text" name="Track_ID" maxlength="64" placeholder="Enter Tracking ID" required>
        <button type="submit">Track Your Order</button>
    </form>

    <div class="gallery">

        <img class="img-box"
        style="<?= activeStep($status, ['OrderPlaced','Processing','Shipped','Delivered']) ?>"
        src="https://media.discordapp.net/attachments/1488268700904849598/1495981239918792764/Screenshot_2026-04-20_215512.png?ex=69e83899&is=69e6e719&hm=a99e5187d6f88bfd7cb721eb847eafe0b6adaec58188eb4cd5eecf141b6fd287&=&format=webp&quality=lossless">

        <img class="img-box"
        style="<?= activeStep($status, ['Processing','Shipped','Delivered']) ?>"
        src="https://media.discordapp.net/attachments/1488268700904849598/1495981240212520970/Screenshot_2026-04-20_215435.png?ex=69e83899&is=69e6e719&hm=08aee18c6839cf1c71910496c26a149412456c4b5b6a27e3be541054f37affee&=&format=webp&quality=lossless">

        <img class="img-box"
        style="<?= activeStep($status, ['Shipped','Delivered']) ?>"
        src="https://media.discordapp.net/attachments/1488268700904849598/1495981240501932133/Screenshot_2026-04-20_215423.png?ex=69e83899&is=69e6e719&hm=af7cbe0280d5297a2eaa3ad5d01dbd72196a06507f52432f3191ee167dc94e14&=&format=webp&quality=lossless">

        <img class="img-box"
        style="<?= activeStep($status, ['Delivered']) ?>"
        src="https://media.discordapp.net/attachments/1488268700904849598/1495981240778625095/Screenshot_2026-04-20_215405.png?ex=69e83899&is=69e6e719&hm=1992d7cd3550c5917c9e09fd31dc31be8ac5d4c896ff72d786a7226ed7d5fed2&=&format=webp&quality=lossless">

    </div>

</div>

<a href="https://students.cs.niu.edu/~z1977897/gpstore.php" class="top-right-btn">
    Store Home
</a>

</body>
</html>
