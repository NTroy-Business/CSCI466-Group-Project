<?php
/* Plug in the VARS in place of any credentials you have on Every Page you plan to test with

PLACE THE CODE BELOW AT THE ABSOLUTE TOP (ABOVE DOCTYPE) of Every Page you plan to test

     <?php
        require_once "storedCreds.php";
    ?>

Save this file as storedCreds.php in your public_html. DONT WORRY YOUR CREDS WILL
NOT BE VISIBLE if someone sources the page. Its hidden in php

When putting the varibles in, do so like this...
-------------------------------------------------------------------
try {

    $pdo = new PDO($stored_database, $stored_user, $stored_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

-------------------------------------------------------------
//USERNAME
*/
$stored_user = "_____"; //edit 

//PASSWORK
$stored_pass = "_____"; //edit 

//DATABASE / DSN "mysql:host=courses;dbname=ZID_HERE"
$stored_database = "mysql:host=courses;dbname=z2054630"; //CHANGE THE ZID HERE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

?>
