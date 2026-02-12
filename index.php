<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    include_once "C:\laragon\www\SLAM\Account\partials\curl_weatherapi.php";

    $weather = getWeatherData();
    $date = getdate()["weekday"]." - ".getdate()["mday"]." ".getdate()["month"]." ".getdate()["year"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />

</head>

<body class="relative -z-2">
    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>   

    <?php if (!empty($weather)) :?>

        <div class="absolute mt-4 right-4 w-64 cursor-pointer border b-gray-400 rounded flex flex-col justify-center items-center text-center p-6 bg-white">
            <div class="text-md font-bold flex flex-col text-gray-900"><span class="uppercase">Today</span><span class="font-normal text-gray-700 text-sm"><?= $date ?></span></div>
            <img src="https://openweathermap.org/img/wn/<?= $weather["weather"][0]["icon"] ?>@2x.png" alt="weather-icon">
            <p class="text-gray-700 mb-2"><?= $weather["weather"][0]["main"] ?></p>
            <div class="text-3xl font-bold text-gray-900 mb-6"><?= round($weather["main"]["temp"])."°C" ?></div>
            <div class="flex justify-between w-full">
                <div class="flex items-center text-gray-700 px-2">
                <svg class="mr-2 h-4" viewBox="0 0 11 18" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Desktop-HD" transform="translate(-120.000000, -479.000000)" fill="#60A2D7" fill-rule="nonzero">
                            <g id="Group" transform="translate(95.000000, 222.000000)">
                                <g id="Group-3" transform="translate(25.000000, 256.774194)">
                                    <g id="028-drop" transform="translate(0.000000, 0.225806)">
                                        <path d="M11,11.9334341 C11,15.0552582 8.53750272,17.5862069 5.5,17.5862069 C2.46249728,17.5862069 0,15.0552582 0,11.9334341 C0,7.58026159 5.5,0 5.5,0 C5.5,0 11,7.58026159 11,11.9334341 L11,11.9334341 Z" id="Path"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </svg>
                <?= $weather["main"]["humidity"]?> l/m<sup>2</sup>
            </div>
            <div class="flex items-center text-gray-700 px-2">
            <svg class="mr-2 h-4 w-4" viewBox="0 0 12 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g id="Desktop-HD" transform="translate(-201.000000, -480.000000)" fill="#0ABDE3" fill-rule="nonzero">
                    <g id="Group" transform="translate(95.000000, 222.000000)">
                    <g id="Group-3" transform="translate(25.000000, 256.774194)">
                        <g id="wind" transform="translate(87.500000, 11.225806) rotate(-90.000000) translate(-87.500000, -11.225806) translate(77.000000, 5.225806)">
                        <g id="w25">
                            <path d="M16.222113,3.9997453 C16.1020238,4.11833549 16.0351226,4.28256699 16.0372726,4.45349848 C16.0394226,4.62442997 16.1104323,4.78683812 16.2334644,4.90221395 C16.6379853,5.28943966 17.0750123,5.74649295 17.5388698,6.22999608 C17.7684767,6.47016066 18.06,6.8515674 18.2916708,7.08908699 C16.7035135,7.07321708 16.0399754,7.11553683 15.1586978,7.07639107 C14.8000983,7.05999216 14.595258,7.23032915 14.595258,7.58264107 C14.595258,7.93442398 14.7443735,8.11216693 15.1034889,8.11216693 C15.9563882,8.11216693 16.7896806,8.06878918 18.3881572,8.08571708 C17.6494273,8.82722969 16.9039897,9.56168541 16.151941,10.288989 C16.0291152,10.4045196 15.9582985,10.5669407 15.9562468,10.737822 C15.9541952,10.9087034 16.0210908,11.0728624 16.1411057,11.1914577 C16.3966491,11.4436893 16.7995644,11.4483255 17.0605651,11.2020376 C18.1048894,10.2022335 19.4185504,8.91148119 20.2957002,8.02805643 C20.4143735,7.90850313 20.5072482,7.74874608 20.5072482,7.58264107 L20.5072482,7.56465517 C20.5072482,7.39273119 20.3988943,7.22927116 20.2699017,7.11236285 C19.7188452,6.6151058 19.092457,5.97501959 18.5001229,5.35662226 C18.0589126,4.89113359 17.6081986,4.43521373 17.1482801,3.98916536 C16.8847573,3.74276899 16.4802155,3.74739022 16.222113,3.9997453 L16.222113,3.9997453 Z" id="Path"></path>
                            <path d="M0,7.255721 C0,7.04623824 0.165110565,6.87695925 0.369434889,6.87695925 L18.7214742,6.87695925 C18.9252826,6.87695925 19.0909091,7.04623824 19.0909091,7.255721 L19.0909091,8.08518809 C19.0909091,8.29467085 18.9257985,8.46394984 18.7214742,8.46394984 L0.369434889,8.46394984 C0.165401634,8.46394984 0,8.29437243 0,8.08518809 L0,7.255721 Z" id="Path"></path>
                            <path d="M0.369434889,8.46394984 C0.165401634,8.46394984 0,8.29437243 0,8.08518809 L0,0.378761755 C0,0.169278997 0.165110565,0 0.369434889,0 L1.17847666,0 C1.38228501,0 1.54791155,0.169278997 1.54791155,0.378761755 L1.54791155,8.08518809 C1.54791155,8.29414185 1.38280098,8.46394984 1.17847666,8.46394984 L0.369434889,8.46394984 Z" id="Path"></path>
                        </g>
                        <path d="M4.108,8.53448276 C3.91028206,8.53448276 3.75,8.3634922 3.75,8.15256466 L3.75,0.381918103 C3.75,0.170689655 3.91,0 4.108,0 L4.892,0 C5.0895,0 5.25,0.170689655 5.25,0.381918103 L5.25,8.15256466 C5.25,8.3632597 5.09,8.53448276 4.892,8.53448276 L4.108,8.53448276 Z" id="Path"></path>
                        </g>
                    </g>
                    </g>
                </g>
                </g>
            </svg>
            <?= $weather["wind"]["speed"]?> km/h
            </div>
        </div>
        </div>
    <?php endif ?>



    <div class="relative -z-1 isolate px-6 pt-14 lg:px-8">
        <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-1 transform-gpu overflow-hidden blur-3xl sm:-top-80">
            <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
        </div>
        <div class="mx-auto max-w-2xl py-32 sm:py-24 lg:py-28">
            <div class="text-center">
                <h1 class="text-5xl font-semibold tracking-tight text-balance text-black sm:text-7xl">Welcome back <?= $_SESSION["user"]['username']?></h1>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="shop.php" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Start shopping</a>
                    <a href="todo.php" class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">Complete your Todo List</a>
                    <a href="profile.php" class="text-sm/6 font-semibold text-black">Profile settings<span aria-hidden="true">→</span></a>
                </div>
            </div>
        </div>
        <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
        <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
        </div>
    </div>
</body>
</html>