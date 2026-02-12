<?php
session_start();
include_once 'C:\laragon\www\SLAM\Account\partials\check_session.php';
include_once 'C:\laragon\www\SLAM\Account\config\db_config.php';

if (!empty($_GET['id'])) {
    include_once 'C:\laragon\www\SLAM\Account\partials\curl_fakestoreapi.php';
    $currentProduct = getProduct($_GET['id']);
} else {
    header('Location: shop.php');
    exit();
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['comment']) and strlen(trim($_POST['comment'])) != 0) {
        // Enlève les caractères spéciaux "<" et ">"
        $content = htmlspecialchars($_POST['comment']);
        $insertComment = 'INSERT INTO comment(id_user,id_product,comment) VALUES (?,?,?)';
        $stmt = $db->prepare($insertComment);
        $stmt->execute([$_SESSION['user']['id'], $currentProduct['id'], $content]);

        header('Location: shop-item.php?id=' . $currentProduct['id']);
        exit();
    } else {
        $error = 'Le commentaire est vide';
    }
}

if (isset($_GET['delete'])) {
    $deletComment = 'DELETE FROM comment WHERE id = ?';
    $stmt = $db->prepare($deletComment);
    $stmt->execute([$_GET['delete']]);

    header('Location: shop-item.php?id=' . $currentProduct['id']);
    exit();
}

if (isset($_GET['edit']) && isset($_POST['edit-input' . $_GET['edit']])) {
    $comment = $_POST['edit-input' . $_GET['edit']];
    $updateComment = 'UPDATE comment SET comment = ?, timestamp=CURRENT_TIMESTAMP WHERE id = ?';
    $stmt = $db->prepare($updateComment);
    $stmt->execute([$comment, $_GET['edit']]);

    header('Location: shop-item.php?id=' . $currentProduct['id']);
    exit();
}

$getComments = 'SELECT username, avatar, user.id as user_id, comment.id as comment_id, comment, timestamp FROM comment INNER JOIN user on comment.id_user = user.id WHERE id_product = ? ORDER BY timestamp DESC';
$stmt = $db->prepare($getComments);
$stmt->execute([$currentProduct['id']]);
$comments = $stmt->fetchAll();

$getNumComments = 'SELECT COUNT(id) FROM comment WHERE id_product = ?';
$stmt = $db->prepare($getNumComments);
$stmt->execute([$currentProduct['id']]);
$commentCount = $stmt->fetch();
$commentCountVal = $commentCount['COUNT(id)'];

// var_dump($comments[0]);

$getRating = 'SELECT * FROM rating WHERE id_user = ? AND id_product = ?';
$stmt = $db->prepare($getRating);
$stmt->execute([$_SESSION['user']['id'], $currentProduct['id']]);
$rating = $stmt->fetch();

if (isset($_GET['rating'])) {
    if (!(1 <= $_GET['rating'] && $_GET['rating'] <= 5)) {
        header('Location: shop-item.php?id=' . $currentProduct['id']);
        exit();
    } else {
        if ($rating) {
            if ($_GET['rating'] != $rating['rating']) {
                $updateRating = 'UPDATE rating SET rating = ? WHERE id_user = ? AND id_product = ?';
                $stmt = $db->prepare($updateRating);
                $stmt->execute([$_GET['rating'], $_SESSION['user']['id'], $currentProduct['id']]);
            }
        } else {
            $insertRating = 'INSERT INTO rating(id_user,id_product,rating) VALUES (?,?,?)';
            $stmt = $db->prepare($insertRating);
            $stmt->execute([$_SESSION['user']['id'], $currentProduct['id'], $_GET['rating']]);
        }
    }
} else {
    if ($rating) {
        header('Location: shop-item.php?id=' . $currentProduct['id'] . '&rating=' . $rating['rating']);
        exit();
    }
}

$getNumRating = 'SELECT COUNT(rating) FROM rating WHERE id_product = ?';
$getAverage = 'SELECT AVG(rating) FROM rating WHERE id_product = ?';
$stmt = $db->prepare($getAverage);
$stmt->execute([$currentProduct['id']]);
$average = $stmt->fetch();

$stmt = $db->prepare($getNumRating);
$stmt->execute([$currentProduct['id']]);
$ratingCount = $stmt->fetch();

if ($ratingCount['COUNT(rating)'] != 0) {
    $ratingCountVal = $ratingCount['COUNT(rating)'];
    $averageRating = round(floatval($average['AVG(rating)']), 2);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop item</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="scripts/app.js" defer></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    >
    <!-- <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    > -->

</head>
<body>
    <?php include_once 'C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php'; ?>
    <section>
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:items-center md:gap-8">
                
                <div class="flex flex-col items-center">
                    <div class="max-w-prose md:max-w-none">
                        <h2 class="text-2xl font-semibold text-gray-900 sm:text-3xl">
                            <?= $currentProduct['title'] ?>
                        </h2>
                        
                        <p class="mt-4 text-pretty text-gray-700">Average rating :
                            <?php if (isset($averageRating)): ?>
                                <?= $averageRating ?> stars (Total : <?= $ratingCountVal ?> ratings)
                            <?php else: ?>
                                No ratings for this product
                            <?php endif ?>
                        </p>
                        
                        <p class="mt-4 text-pretty text-gray-700">
                            <?php
                            if (strlen($currentProduct['description']) <= 100) {
                                echo $currentProduct['description'];
                            } else {
                                echo substr($currentProduct['description'], 0, 97) . '...';
                            }
                            ?>
                        </p>
                    </div>

                    <a href="add-to-cart.php?id=<?= $currentProduct['id'] ?>" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 mt-5 mb-5 max-w-75">Add to cart</a>                
                
                    <div class="flex items-center space-x-1">
                        <?php if (isset($_GET['rating'])): ?>
                            <p class="text-gray-700">Your note : </p>
                        <?php else: ?>
                            <p class="text-gray-700">Please enter your note : </p>
                        <?php endif ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                <?php if (isset($_GET['rating']) && $i <= $_GET['rating']): ?>
                                    <a href="shop-item.php?id=<?= $currentProduct['id'] ?>&rating=<?= $i ?>"><svg class="w-5 h-5 fill-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/></svg></a>
                                <?php else: ?>
                                    <a href="shop-item.php?id=<?= $currentProduct['id'] ?>&rating=<?= $i ?>"><svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/></svg></a>
                                <?php endif ?>
                        <?php endfor ?>
                    </div>
                
                </div>
                
                <div class="flex flex-col items-center">
                    <img src="<?= $currentProduct['image'] ?>" class="rounded max-w-75" alt="">
                    <h2 class="text-2xl font-semibold text-gray-900 sm:text-3xl mt-5">
                        <?= number_format($currentProduct['price'], 2, ',', ' ') ?> €
                    </h2>
                </div>

            </div>
        </div>
    </section>
    
    <section id="comments" class="bg-white dark:bg-gray-900 py-8 lg:py-16 antialiased">
        <div class="max-w-2xl mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion (<?= $commentCountVal ?>)</h2>
            </div>
            <form action="#comments" method="POST" class="mb-6">
                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" rows="6" name="comment" maxlength="200"
                        class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                        placeholder="Write a comment..."></textarea>
                </div>
                <div class="flex gap-4 items-center">
                    <button type="submit" name="submit"
                        class="cursor-pointer inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-indigo-500 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        Post comment
                    </button>
                    <?php if (isset($error)): ?>
                        <h2 class="text-2xl font-bold tracking-tight text-red-500">
                            <?= $error ?>
                        </h2>
                    <?php endif ?>
                </div>
            </form>
            

            <?php foreach ($comments as $comment): ?>
                <form action="" method="POST" id="comment<?= $comment['comment_id'] ?>">
                    <article class="flex justify-between gap-4 items-start p-6 text-base bg-white rounded-lg dark:bg-gray-900">
                        <footer class="flex flex-col mb-2 w-full">
                            <div class="flex items-center">
                                <p class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white font-semibold"><img
                                        class="mr-2 w-6 h-6 rounded-full"
                                        src="<?= $comment['avatar'] ?>"
                                        alt="Michael Gough"><?= $comment['username'] ?></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                                        title="February 8th, 2022"><?= $comment['timestamp'] ?></time></p>
                            </div>
                            <?php if (isset($_GET['edit']) && $_GET['edit'] == $comment['comment_id']): ?>
                                <input class="mt-4 w-full bg-white border-solid border-1 border-black rounded-xl p-2" rows="6"     type="text" name="edit-input<?= $_GET['edit'] ?>" value="<?= $comment['comment'] ?>">
                            <?php else: ?>
                                <p class="break-all mt-4 text-gray-500 dark:text-gray-400"><?= $comment['comment'] ?></p>
                            <?php endif ?>
                        </footer>
                        
                        <?php if ($comment['user_id'] == $_SESSION['user']['id']): ?>
                            <div id="dropdown<?= $comment['comment_id'] ?>"
                                class="z-10 w-36 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconHorizontalButton">
                                    <li>
                                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $comment['comment_id']): ?>
                                            <input name="submit" type="submit" class="block w-full text-left py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white" value="Confirm">
                                        <?php else: ?>
                                            <?php if (isset($_GET['rating'])): ?>
                                                <a href="shop-item.php?id=<?= $currentProduct['id'] ?>&edit=<?= $comment['comment_id'] ?>&rating=<?= $_GET['rating'] ?>#comment<?= $comment['comment_id'] ?>"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            <?php else: ?>
                                                <a href="shop-item.php?id=<?= $currentProduct['id'] ?>&edit=<?= $comment['comment_id'] ?>#comment<?= $comment['comment_id'] ?>"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                            <?php endif ?>
                                        <?php endif ?>
                                        
                                    </li>
                                    <li>
                                        <a href="shop-item.php?id=<?= $currentProduct['id'] ?>&delete=<?= $comment['comment_id'] ?>&rating=<?= $_GET['rating'] ?>#comments"
                                            class="removeBtn animate__animated block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                    </li>
                                </ul>
                            </div>
                        <?php endif ?>

                        <!-- <div class="flex items-center mt-4 space-x-4">
                            <button type="button"
                                class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium">
                                <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                                </svg>
                                Reply
                            </button>
                        </div> -->
                    </article>
                </form>
            <?php endforeach ?>
        </div>
    </section>
</body>
</html>