<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    include_once "C:\laragon\www\SLAM\Account\partials\curl_fakestoreapi.php";   
    
    include_once "C:\laragon\www\SLAM\Account\config\db_config.php";
    include_once "C:\laragon\www\SLAM\Account\config\dotenv.php";

    $products = getProduct();

    // Récupération des catégories
    $categories = [];
    foreach ($products as $product) {
        if(!in_array($product["category"],$categories)){
            $categories[] = $product["category"];
        }
    }

    // ... alors on initialise un tableau vide qui recevra les produits 
    // correspondants à la catégorie choisie 
    $products_filtered = [];
    if (isset($_GET["category"])){

        // Popur chaque produit dans mon ensemble de produits, je vérifie
        // que la catégorie corresponde bien : si c'est le cas je l'ajoute à mon tableau des produits filtrés 
        foreach($products as $product) {
            if ($product["category"] == $_GET["category"]) {
                $products_filtered[] = $product;
        }}

        // Si la catégorie n'existe pas ou ne concerne aucun produit on arffiche un message d'erreur
        if (empty($products_filtered)) {
            $error = "La catégorie ne contient aucun produit ...";
        }
    } else {
        $products_filtered = $products;
    }

    function getAverageCountRating($idProduct){

        $db = Db::connectDB($_ENV["DB_NAME"], $_ENV["DB_USERNAME"], $_ENV["DB_PASSWORD"]);
        
        $getNumRating = "SELECT COUNT(rating) FROM rating WHERE id_product = ?";
        $getAverage = "SELECT AVG(rating) FROM rating WHERE id_product = ?";
        $stmt = $db->prepare($getAverage);
        $stmt->execute([$idProduct]);
        $average = $stmt->fetch();

        $stmt = $db->prepare($getNumRating);
        $stmt->execute([$idProduct]);
        $count = $stmt->fetch();

        if($count["COUNT(rating)"]!=0){
            $countRating = $count["COUNT(rating)"];
            $averageRating = round(floatval($average["AVG(rating)"]),2);
            return ["average" => $averageRating,"count" => $countRating];
        }
    }
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Shop</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>
<body>

    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>

    <div class="bg-white">
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <div class="flex gap-x-20 items-center">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Nos articles</h2>
            <?php if (!empty($_GET["status"])) : ?>
                <h2 class="text-2xl font-bold tracking-tight text-green-500">
                    Votre article "<?= getProduct($_GET["id"])["title"]?>" à été ajouté avec succès - Quantité : <?= $_GET["status"]?>
                </h2>
            <?php endif ?>
            <?php if (!empty($error)) : ?>
                <h2 class="text-2xl font-bold tracking-tight text-red-500">
                    <?= $error ?>
                </h2>
            <?php endif ?>
        </div>
        
        <div class="flex mt-5 gap-x-10 items-center">
            <?php foreach($categories as $category) : ?> 
                <?php if (isset($_GET["category"]) && $_GET["category"]==$category) : ?>
                    <a href="shop.php" class="cursor-pointer mr-4 flex w-48 justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-700 hover:text-indigo-200">
                        <?= ucwords($category) ?>
                    </a>
                <?php else : ?>
                    <a href="shop.php?category=<?= $category ?>" class="cursor-pointer border-2 border-solid border-indigo-600 mr-4 flex w-48 justify-center rounded-md bg-white px-3 py-1.5 text-sm/6 font-semibold text-indigo-600 shadow-xs hover:bg-indigo-200">
                        <?= ucwords($category) ?>
                    </a>
                <?php endif ?>
            <?php endforeach ?>
        </div>
        
        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            
            <?php if (isset($products)) : ?>
                <?php foreach($products_filtered as $product) : ?>
                    <div class="group relative h-full flex flex-col justify-between items-center">
                        <a href="shop-item.php?id=<?= $product["id"]?>">    
                            <img src="<?= $product["image"]?>" alt="<?= substr($product["title"],0,5)?>" class="aspect-square w-full rounded-md bg-gray-200 object-cover group-hover:opacity-80 lg:aspect-auto lg:h-80" />
                            <div class="mt-4">
                                <div class="flex justify-between gap-x-5">
                                    <h3 class="text-sm text-gray-700"><?= $product["title"]?></h3>
                                    <p class="text-sm font-medium text-gray-900"><?= number_format($product["price"], 2, ',', ' ') ?>€</p>
                                </div>

                                <?php 
                                    $ratingProduct = getAverageCountRating($product["id"]);
                                    // var_dump($ratingProduct);
                                    if (!empty($ratingProduct)) {
                                        echo $ratingProduct["average"]." stars (Total : ".$ratingProduct["count"]." ratings)";
                                    } else {
                                        echo "No ratings for this product";
                                    }
                                ?>                            

                                <p class="mt-1 text-sm text-gray-500">
                                    <?php
                                        if (strlen($product["description"]) <= 100){
                                            echo $product["description"];
                                        } else {
                                            echo substr($product["description"],0,97) . "...";
                                        }
                                    ?>
                                </p>
                            </div>
                        </a>
                        <a href="add-to-cart.php?id=<?= $product["id"] ?>" class="addBtn animate__animated flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 mt-5 mb-5">Add to cart</a>
                    </div>  
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
    </div>
    
    <script>
        const addBtns = document.querySelectorAll(".addBtn");
        addBtns.forEach((addBtn) => {
            addBtn.addEventListener("click", () => {
                addBtn.classList.add("animate__bounceOut");
                addBtn.style.setProperty('--animate-duration', '4s');
            })
        })
    </script>

</body>
</html>