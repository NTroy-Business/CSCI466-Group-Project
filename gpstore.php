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

session_start();
$trackingID = session_id();

if(isset($_POST['addtocart']))
{
    $stuffieID=$_POST['stuffie_id'];

    //check if in cart already
    $statement = $pdo->prepare("SELECT CartQty FROM SHOPPINGCART WHERE TrackingID = ? AND StuffieID = ?");
    $statement->execute([$trackingID, $stuffieID]);
    $row = $statement->fetch();

    if ($row)
    {
        // if it already exists, increase quantity
        $stmt = $pdo->prepare("UPDATE SHOPPINGCART SET CartQty = CartQty + 1 WHERE TrackingID = ? AND StuffieID = ?");
        $stmt->execute([$trackingID, $stuffieID]);
    }
    else
    {
        // if not, insert
        $stmt = $pdo->prepare("INSERT INTO SHOPPINGCART (TrackingID, StuffieID, CartQty) VALUES (?, ?, 1)");
        $stmt->execute([$trackingID, $stuffieID]);
    }
}
                
?>

<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

        <style>
            h1 {text-align: center; font-family:'Nunito', sans-serif; color:hotpink; padding: 15px;}
            p {text-align: center; font-family:'Nunito', sans-serif; color:lightpink; word-break: break-word;}
            div {text-align: center;}

            form {text-align: center;}
            img 
            {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 75%; /* Optional: set a width smaller than the container */
                border-radius: 10px;
            }
            td
            {
                border: 1px solid lightgray;
                border-radius: 10px;
                word-wrap: break-word;
                overflow-wrap: break-word;
                background-color: white;
            }
            img:hover 
            {
                transform: scale(1.05);
                transition: 0.3s;
            }
            
            table 
            {
                margin: auto;
                border-radius: 10px;
                border-spacing: 20px;
                background-color: #ffe8f8;
            }

            .button 
            {
                border: none;
                color: white;
                padding: 16px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                transition-duration: 0.3s;
                cursor: pointer;
            }

            .button1 
            {
                background-color: white; 
                color: black; 
                border: 2px solid hotpink;
                border-radius: 10px;
            }

            .button1:hover 
            {
                background-color: pink;
                color: white;
                border-radius: 10px;
            }

            .top-right-btn2 
            {
                position: fixed;
                top: 20px;
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
                font-family:'Nunito', sans-serif; 
            }

            .top-right-btn2:hover 
            {
                background-color: deeppink;
                transform: scale(1.05);
            }
        </style>
    </head>



    <body style="background-color:Lavender">
        
        <h1>Stuffie Store<hr></h1>
        <a href="https://students.cs.niu.edu/~z1977897/shoppingcart.php" class="top-right-btn2">
            My Cart
        </a>

        <table width="75%" border="0">    
            <tr>
                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/erawr.jpg" alt="erawr" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S001">
                    </form>

                    <p>erawr</p>
                    <p>$500.00</p>
                    <p>green dinosaur</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/urawr.jpg" alt="urawr" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S002">
                    </form>

                    <p>urawr</p>
                    <p>$67.00</p>
                    <p>light pink dinosaur</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/mirawr.jpg" alt="mirawr" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S003">
                    </form>

                    <p>mirawr</p>
                    <p>$3.25</p>
                    <p>pink dinosaur</p>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/tirawr.jpg" alt="tirawr" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S004">
                    </form>

                    <p>tirawr</p>
                    <p>$487.75</p>
                    <p>yellow dinosaur</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/quagsire.jpg" alt="quagsire" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S005">
                    </form>

                    <p>quagsire</p>
                    <p>$620.00</p>
                    <p>quagsire pokemon</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/clodsire.jpg" alt="clodsire" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S006">
                    </form>

                    <p>clodsire</p>
                    <p>$980.00</p>
                    <p>clodsire pokemon</p>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/tamago.jpg" alt="tamago" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S007">
                    </form>

                    <p>tamago</p>
                    <p>$495.00</p>
                    <p>lil egg</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/shibata.jpg" alt="shibata" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S008">
                    </form>

                    <p>shibata</p>
                    <p>$420.00</p>
                    <p>shiba inu</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/shibata%20big.jpg" alt="shibata BIG" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S009">
                    </form>

                    <p>shibata BIG</p>
                    <p>$515.00</p>
                    <p>BIG shiba inu</p>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/burnt%20shibata.jpg" alt="burnt chibatta" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S010">
                    </form>

                    <p>burnt chibatta</p>
                    <p>$499.00</p>
                    <p>black shiba inu</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/shibata%20roll.jpg" alt="shibata roll" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S011">
                    </form>

                    <p>shibata roll</p>
                    <p>$455.00</p>
                    <p>round shiba inu</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/sharkie.jpg" alt="sharkie" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S012">
                    </form>

                    <p>sharkie</p>
                    <p>$510.00</p>
                    <p>shark with a pineapple surfboard</p>
                    <br>
                </td>
            </tr>

            <tr>
                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/hedgehog.jpg" alt="hedhog" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S013">
                    </form>

                    <p>hedhog</p>
                    <p>$520.00</p>
                    <p>squeaks, honks, AND crinkles?! perfect for dogs or people with whimsy</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/corona.jpg" alt="coronavirus" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S014">
                    </form>

                    <p>coronavirus</p>
                    <p>$2019.00</p>
                    <p>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAHHHHHHHHHHHHHH</p>
                    <br>
                </td>

                <td>
                    <br>
                    <img src="https://students.cs.niu.edu/~z1977897/skunkie.jpg" alt="skunkie" width="300" height="auto"/>
                    <form method="post">
                        <button class="button button1" type="submit" name="addtocart">ADD TO CART</button>
                        <input type="hidden" name="stuffie_id" value="S015">
                    </form>

                    <p>skunkie</p>
                    <p>$510.50</p>
                    <p>BIG FAT GUY he wants love, i know hes expensive but pls buy him</p>
                    <br>
                </td>
            </tr>
        </table>
    </body>
</html>
