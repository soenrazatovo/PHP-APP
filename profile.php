<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your profile</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>
    
    <div class="m-8 bg-white overflow-hidden shadow-xl rounded-lg border-1 border-gray-200 ">
        <div class="flex justify-start items-center gap-4 px-4 py-5 sm:px-6">
            <img class="w-25 h-25 rounded-3xl" src="<?= $_SESSION["user"]["avatar"] ?>" alt="">
            <div>
                <h3 class="text-6xl leading-6 font-medium text-gray-900">
                    User Profile : <?= $_SESSION["user"]["username"] ?>
                </h3>
            </div>

        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Username
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <?= $_SESSION["user"]["username"]?>
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Email address
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <?= $_SESSION["user"]["email"]?>
                    </dd>
                </div>
                <div class="py-3 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Inscrit depuis
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <?php echo implode("/",array_reverse(explode("-",explode(" ",$_SESSION["user"]["date"])[0]))) . " at " . explode(" ",$_SESSION["user"]["date"])[1]?>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    
</body>
</html>