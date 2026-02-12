<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    
    const infos = ["sucess" => "Votre message à été envoyé avec succès",
                    "empty" => "Veuillez remplir tout les champs",
                    "not-agreed" => "Veuillez accepter la politique de confidentialité"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
</head>
<body>
    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>

    <div class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
        <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">Contact</h2>
        <p class="mt-2 text-lg/8 text-gray-600">Contacter-nous par mail via le formulaire ci-dessous</p>
        <?php if (isset($_GET["info"])) : ?>            
            <?php if ($_GET["info"]=="sucess") : ?>            
                <p class="mt-6 text-center font-bold text-lg/8 text-green-600"><?= infos[$_GET["info"]] ?></p>
            <?php else : ?>
            <p class="mt-6 text-center font-bold text-lg/8 text-red-600"><?= infos[$_GET["info"]] ?></p>
            <?php endif ?>
        <?php endif ?>
    </div>
    <form action="contact-process.php" method="POST" class="mx-auto mt-10 max-w-xl sm:mt-20">
        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
        <div>
            <label for="first-name" class="block text-sm/6 font-semibold text-gray-900">First name</label>
            <div class="mt-2.5">
            <input id="first-name" type="text" name="first-name" autocomplete="given-name" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
            </div>
        </div>
        <div>
            <label for="last-name" class="block text-sm/6 font-semibold text-gray-900">Last name</label>
            <div class="mt-2.5">
            <input id="last-name" type="text" name="last-name" autocomplete="family-name" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="email" class="block text-sm/6 font-semibold text-gray-900">Email</label>
            <div class="mt-2.5">
            <input id="email" type="email" name="email" autocomplete="email" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="subject" class="block text-sm/6 font-semibold text-gray-900">Subject</label>
            <div class="mt-2.5">
            <input id="subject" type="text" name="subject" autocomplete="subject" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
            </div>
        </div>
        <div class="sm:col-span-2">
            <label for="message" class="block text-sm/6 font-semibold text-gray-900">Message</label>
            <div class="mt-2.5">
            <textarea id="message" name="message" rows="4" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
            </div>
        </div>
        </div>
        <div class="flex mt-6 gap-x-4 sm:col-span-2">
            <div class="flex h-6 items-center">
            <div class="group relative inline-flex w-8 shrink-0 rounded-full bg-gray-200 p-px inset-ring inset-ring-gray-900/5 outline-offset-2 outline-indigo-600 transition-colors duration-200 ease-in-out has-checked:bg-indigo-600 has-focus-visible:outline-2">
                <span class="size-4 rounded-full bg-white shadow-xs ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out group-has-checked:translate-x-3.5"></span>
                <input id="agree-to-policies" type="checkbox" name="agree-to-policies" aria-label="Agree to policies" class="absolute inset-0 size-full appearance-none focus:outline-hidden" />
            </div>
            </div>
            <label for="agree-to-policies" class="text-sm/6 text-gray-600">
            By selecting this, you agree to our
            <a href="#" class="font-semibold whitespace-nowrap text-indigo-600">privacy policy</a>.
            </label>
        </div>
        
        <div class="mt-10">
            <button type="submit" name="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Let's talk</button>
        </div>
    </form>
    </div>

</body>
</html>