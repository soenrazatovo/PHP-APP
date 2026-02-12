<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\config\db_config.php";

    if (isset($_POST["submit"])) {

        $getAccount = "SELECT * FROM user WHERE username=? OR email=?";

        if (!empty($_POST["username-email"]) && !empty($_POST["password"])){
            
            $usernameEmail = $_POST["username-email"];
            $password = $_POST["password"];
            
            $stmt = $db->prepare($getAccount);
            $stmt->execute([$usernameEmail,$usernameEmail]);
            // $res = $stmt->fetch();
            $account = $stmt->fetch();
            
            // Variable seul dans if <=> var != false
            if ($account){
                if (password_verify($password, $account["password"])){
                    
                    $_SESSION["user"] = $account;
                    unset($_SESSION["user"]["password"]);

                    $getCart = "SELECT * FROM cart WHERE id_user = ?";

                    $stmt=$db->prepare($getCart);
                    $stmt->execute([$_SESSION["user"]["id"]]);
                    $cart = $stmt->fetch();

                    if ($cart) {
                        $content = json_decode($cart["content"],true);
                        $_SESSION["cart"] = $cart;
                        $_SESSION["cart"]["content"] = $content;
                    }


                    header("Location: index.php");
                    exit();

                } else {
                    $info = "Password incorrect";
                }

            } else {
                $info = "No account exist with this username/email";
                
            }

        } else {
            $info = "Please fill all the fields";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <html class="h-full bg-gray-900">
    <body class="h-full">


</head>
<body>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img src="assets\MystR-Logo-White-NoSmoke.webp" alt="Your Company" class="mx-auto h-10 w-auto" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Log in to your account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form action="" method="POST" class="space-y-6">
        <div>
            <label for="username-email" class="block text-sm/6 font-medium text-gray-100">Username or Email address</label>
            <div class="mt-2">
            <input id="username-email" type="text" name="username-email" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between">
            <label for="password" class="block text-sm/6 font-medium text-gray-100">Password</label>
            </div>
            <div class="mt-2">
            <input id="password" type="password" name="password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
        </div>

        <div>
            <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Log in</button>
        </div>
        </form>
        
        <?php if (isset($info)) : ?>
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-red-500"><?= $info ?></h2>
        <?php endif ?>

        <p class="mt-10 text-center text-sm/6 text-gray-400">
        Don't have an account ?
        <a href="signup.php" class="font-semibold text-indigo-400 hover:text-indigo-300">Sign up now</a>
        </p>

    </div>
    </div>

    <!-- <div class="main-container" id="login-box">
        <h1>Login</h1>
        <form action="" method="POST">
            <div class="secondary-container  login-input">
                <label for="username-email">Enter your username or email :</label>
                <input type="text" placeholder="Username or Email" name="username-email" id="username-email"> 
            </div>

            <div class="secondary-container login-input">
                <label for="password">Enter your password :</label>
                <input type="password" placeholder="Password" name="password" id="password">
            </div>
    
            <input type="submit" name="submit" value="LOGIN">
            
            <?php if (isset($info)) : ?>
                <h2 style="color: red;"><?= $info ?></h2>
            <?php endif ?>
               
        </form>
        <a href="signup.php"><button>SIGNUP</button></a>
    </div> -->

</body>
</html>