<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    include_once "C:\laragon\www\SLAM\Account\config\db_config.php";

    if (!empty($_GET["id"])){
        
        include_once "C:\laragon\www\SLAM\Account\partials\curl_fakestoreapi.php";
        $currentProduct = getProduct($_GET["id"]);

        $idUser = $_SESSION["user"]["id"];

        $checkCart = "SELECT * FROM cart WHERE id_user = ?";

        $stmtCheck = $db->prepare($checkCart);
        $stmtCheck -> execute([$idUser]);

        $cart = $stmtCheck->fetch();

        if ($cart){
            $updateCart = "UPDATE cart SET content = ? WHERE id_user = ?";
            $content = json_decode($cart["content"], true);

            $productExist = FALSE;
            foreach($content as $key => $product) {
                if ($product["id"] == $currentProduct["id"]) {
                    $content[$key]["quantity"] += 1;
                    $quantity = $content[$key]["quantity"];
                    $productExist = TRUE;
                }
            }

            if (!$productExist){
                $quantity = 1;
                $currentProduct["quantity"] = $quantity;
                $content[] = $currentProduct;
            }

            $stmtUpdate = $db->prepare($updateCart);
            $stmtUpdate -> execute([json_encode($content),$idUser]);


        } else {
            $createCart = "INSERT INTO cart(id_user, content) VALUES (?, ?)";

            // Création d'un tableau vide avec comme premier élément le produit ajouté
            $quantity = 1;
            $currentProduct["quantity"] = $quantity;
            $content = [$currentProduct];

            $stmtCreate = $db->prepare($createCart);
            $stmtCreate->execute([$idUser, json_encode($content)]);

        }

        $_SESSION["cart"]["content"] = $content;

        header("Location: shop.php?id=".$currentProduct["id"]."&status=".$quantity);
        exit();
        


    } else {
        header("Location: shop.php");
        exit();
    }

        
?>