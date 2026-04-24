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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956488852865045/IMG_8163.jpg?ex=69e8218c&is=69e6d00c&hm=1dec51d065ba9068dc265390d75afc9870d3b1358b3e5c7715fc22f976f064fb&=&format=webp&width=1152&height=864" alt="erawr" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956490794565793/IMG_8167.jpg?ex=69e8218c&is=69e6d00c&hm=13563c535c1a3f587fc232e611c2ed78a2bd95c98be7818b0e48eecf4ab817b2&=&format=webp&width=1152&height=864" alt="urawr" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956489754378260/IMG_8165.jpg?ex=69e8218c&is=69e6d00c&hm=ffda1cc5fa1d35358abb5433999c59666bdb2b547b31ad46e3772a497e580850&=&format=webp&width=1152&height=864" alt="mirawr" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956490312356011/IMG_8166.jpg?ex=69e8218c&is=69e6d00c&hm=4544b21152ef2e097cedf8cc8181232337097d8ce305dfc1022526f161930667&=&format=webp&width=1152&height=864" alt="tirawr" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956491214131300/IMG_8168.jpg?ex=69e8218d&is=69e6d00d&hm=c9414b9402e0f01544170745a6e886ba0fbd5a59313d4f1491328f40d0fd3f2c&=&format=webp&width=1152&height=864" alt="quagsire" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956491901861978/IMG_8169.jpg?ex=69e8218d&is=69e6d00d&hm=4d1b68c0435689ce8707eae8840bd64e811efec7b7404ba3e6e9ada96a801a5d&=&format=webp&width=1152&height=864" alt="clodsire" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956493428592760/IMG_8172.jpg?ex=69e8218d&is=69e6d00d&hm=45cbaddffc103e48d4ecf7ac65512724c6643367c78cc81814229b3ab6ab00e9&=&format=webp&width=1152&height=864" alt="tamago" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956492908494868/IMG_8171.jpg?ex=69e8218d&is=69e6d00d&hm=1368586784d2a8a10fa010d80e050440d6b13d6f7713ca5b2e536a52d3a292b1&=&format=webp&width=1152&height=864" alt="shibata" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956492434800670/IMG_8170.jpg?ex=69e8218d&is=69e6d00d&hm=094adb1acdee0f7e188e2846ce31ecd4e70590549d740462a52369a2caac216d&=&format=webp&width=1152&height=864" alt="shibata BIG" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956523464134707/IMG_8177.jpg?ex=69e82194&is=69e6d014&hm=ee9eddcb4b96a8f371328f929190e3f20bd0f43625ad96b3dbec4ac6718e6b92&=&format=webp&width=1152&height=864" alt="burnt chibatta" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956524168773752/IMG_8178.jpg?ex=69e82194&is=69e6d014&hm=f930def8bfb399b6bf32308911be8975afea97282a660b42f38c675e285b2d66&=&format=webp&width=1152&height=864" alt="shibata roll" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956522713481246/IMG_8176.jpg?ex=69e82194&is=69e6d014&hm=4428f61cd96890883733902fe43f48345cdf158c9b3b7ebb0be371b8741d60c0&=&format=webp&width=1152&height=864" alt="sharkie" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956489330757773/IMG_8164.jpg?ex=69e8218c&is=69e6d00c&hm=641fd70476ec228e42e86665c13e2dfae3a0ad2d382efe98c5378a73700e932e&=&format=webp&width=1152&height=864" alt="hedhog" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956521723367424/IMG_8175.jpg?ex=69e82194&is=69e6d014&hm=33a8da0292314e44abe2f51b02bb3d9fb2b9207510ed2b5de4428dcbaca9d0cd&=&format=webp&width=1152&height=864" alt="coronavirus" width="300" height="auto"/>
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
                    <img src="https://media.discordapp.net/attachments/1488268700904849598/1495956520683307088/IMG_8173.jpg?ex=69e82194&is=69e6d014&hm=2c93ed54d5a9be5d03f17028880dc511d84653c6dea6525bd2ff2a326a2f0c90&=&format=webp&width=1152&height=864" alt="skunkie" width="300" height="auto"/>
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
