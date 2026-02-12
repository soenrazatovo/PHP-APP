<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    include_once "C:\laragon\www\SLAM\Account\config\db_config.php";

    $idUser = $_SESSION["user"]["id"];

    $getCart = "SELECT * FROM cart WHERE id_user = ?";

    $stmt=$db->prepare($getCart);
    $stmt->execute([$idUser]);

    $cart = $stmt->fetch();

    $subtotal = 0;
    $total = 0;

    if ($cart){
        $content = json_decode($cart["content"],true);
        
        if (!empty($content)){
            foreach ($content as $product) {
                $subtotal += floatval($product["price"]*$product["quantity"]);
            }
            $total = $subtotal;
        } else {
            $message = "Your cart is currently empty";
        }

    } else {
        $message = "Your cart is currently empty";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Mon Panier</h2>
        
        <?php if (isset($message)) : ?>
            <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm text-center">
                <p class="text-black-600"><?= htmlspecialchars($message) ?></p>
                <a href="shop.php" class="mt-4 inline-block text-indigo-600 hover:text-indigo-500">Continuer vos achats</a>
            </div>
        <?php elseif ($content && count($content) > 0) : ?>
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-12">
                <!-- Cart Items -->
                <div class="lg:col-span-7 space-y-4">

                    <?php foreach($content as $product) : ?>
                        <!-- Cart Item -->
                        <div class="flex rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                            <img src="<?= $product["image"] ?>" alt="<?= htmlspecialchars($product["title"]) ?>" class="h-24 w-24 rounded-md object-cover flex-shrink-0">
                            <div class="ml-6 flex-1">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($product["title"]) ?></h3>
                                        <p class="text-sm text-gray-500 mt-1"><?= number_format($product["price"], 2, ',', ' ') ?> €</p>
                                    </div>

                                    <!-- Custom Attribute with data-* -->
                                    <a href="#" data-product-id="<?= $product["id"] ?>" class="deleteBtn text-gray-400 hover:text-red-500 transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </div>
                                <p class="text-gray-500 mt-4 w-fit rounded-md border border-gray-300 px-3 py-1 text-sm"> Quantity : <?= $product["quantity"] ?></p>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>

                <!-- Order Summary -->
                <div class="mt-10 lg:col-span-5 lg:mt-0">
                    <div class="rounded-lg border border-gray-200 bg-white px-6 py-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Résumé</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Sous-total</span>
                                <span class="font-medium"><?= number_format($subtotal, 2, ',', ' ') ?> €</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Livraison</span>
                                <span class="font-medium">Gratuite</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-4">
                                <span class="font-semibold">Total</span>
                                <span class="font-semibold"><?= number_format($total, 2, ',', ' ') ?> €</span>
                            </div>
                        </div>

                        <button class="mt-6 w-full rounded-md bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                            Passer la commande
                        </button>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </main>

    <script defer>
        const deleteBtns = document.querySelectorAll(".deleteBtn");

        deleteBtns.forEach((deleteBtn)=>{
            deleteBtn.addEventListener("click", () => {
                if (window.confirm("Êtes vous sur de vouloir supprimer cet article ?")) {
                    window.location.href = "remove-from-cart.php?id="+deleteBtn.getAttribute("data-product-id");
                } 
            })
        })
    </script>
</body>
</html>