<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\config\db_config.php";

    if (isset($_POST["submit"])) {

        if (!empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["confirm-password"])){
            
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirm-password"];
            
            $getExistingAccount = "SELECT * FROM user WHERE username=? OR email=?";
            $stmtExisting = $db->prepare($getExistingAccount);
            $stmtExisting->execute([$username,$email]);

            $alreadyExist = $stmtExisting->fetch();

            // Pas de caractères spéciaux
            // Email au bon format
            // 12 charactères min / majuscule / chiffre / caractère spécial
            
            if ($password == $confirmPassword) {

                if (!$alreadyExist) {
                    
                    $updateDb = "INSERT INTO user (username,email,password) VALUES (?,?,?)";
                    
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $db->prepare($updateDb);
                    $stmt->execute([$username,$email,$hash]);
                    
                    $info = "You account has been successfully created : You can now try to login";
                
                } else {
                    
                    $info = "An account has the same email or username";

                }
                     
            } else {
                
                $info = "Password and Confirmation Password are not the same";
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
    <title>Signup</title>
    <!-- <link rel="stylesheet" href="style.css"> -->

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <html class="h-full bg-gray-900">
    <body class="h-full">
</head>

<body>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <img src="assets\MystR-Logo-White-NoSmoke.webp" alt="Your Company" class="mx-auto h-10 w-auto" />
        <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign up on a new account</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form action="" method="POST" class="space-y-6">
        <div>
            <label for="username" class="block text-sm/6 font-medium text-gray-100">Username</label>
            <div class="mt-2">
            <input id="username" type="text" name="username" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm/6 font-medium text-gray-100">Email address</label>
            <div class="mt-2">
            <input id="email" type="text" name="email" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
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
            <div class="flex items-center justify-between">
            <label for="confirm-password" class="block text-sm/6 font-medium text-gray-100">Confirm Password</label>
            </div>
            <div class="mt-2">
            <input id="confirm-password" type="password" name="confirm-password" class="block w-full rounded-md bg-white/5 px-3 py-1.5 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500 sm:text-sm/6" />
            </div>
        </div>

        <div>
            <button type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-500 px-3 py-1.5 text-sm/6 font-semibold text-white hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Sign up</button>
        </div>
        </form>
        
        <?php if (isset($info)) : ?>
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-red-500"><?= $info ?></h2>
        <?php endif ?>

        <p class="mt-10 text-center text-sm/6 text-gray-400">
        Already have an account ?
        <a href="login.php" class="font-semibold text-indigo-400 hover:text-indigo-300">Log in here</a>
        </p>

    </div>
    </div>


    <!-- <div class="main-container" id="login-box">
        <h1>Signup</h1>
        <form action="" method="POST">
            <div class="secondary-container  login-input">
                <label for="username">Enter your username :</label>
                <input type="text" placeholder="Username" name="username" id="username"> 
            </div>
            
            <div class="secondary-container  login-input">
                <label for="email">Enter your email :</label>
                <input type="text" placeholder="Email"name="email" id="email">
            </div>

            <div class="secondary-container  login-input">
                <label for="password">Enter your password :</label>
                <input type="password" placeholder="Password" name="password" id="password">
            </div>

            <div class="secondary-container  login-input">
                <label for="confirm-password">Confirm your password :</label>
                <input type="password" placeholder="Password" name="confirm-password" id="confirm-password">
            </div>
            
            <input type="submit" name="submit" value="Signup">

            <?php if (isset($info)) : ?>
                <h2 style="color: red;"><?= $info ?></h2>
            <?php endif ?>
        
        </form>
        <a href="login.php"><button>Login</button></a>
    </div> -->

</body>
</html>