<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    include_once "C:\laragon\www\SLAM\Account\config\db_config.php";
    if (isset($_GET["id"])) {
        $idProduct = $_GET["id"];
        $idUser = $_SESSION["user"]["id"];

        $checkCart = "SELECT * FROM cart WHERE id_user = ?";

        $stmtCheck = $db->prepare($checkCart);
        $stmtCheck -> execute([$idUser]);

        $cart = $stmtCheck->fetch();

        if ($cart){
            $content = json_decode($cart["content"], true);

            foreach($content as $key => $product) {
                if ($product["id"] == $idProduct) {
                    unset($content[$key]);
                }
            }
            
            $updateCart = "UPDATE cart SET content = ? WHERE id_user = ?";
            $stmtUpdate = $db->prepare($updateCart);
            $stmtUpdate -> execute([json_encode($content),$idUser]);
        }  
        $_SESSION["cart"]["content"] = $content;
        
    }
    

    header("Location: cart.php");
    exit();
?>


