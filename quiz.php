<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <script type="module" src="scripts/quiz.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <?php include_once 'C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php'; ?>

    <!-- <main class="w-full max-w-2xl p-6"> -->
        <div class="m-auto mt-16 w-full max-w-2xl p-6 bg-white shadow-2xl border border-gray-200 rounded-xl p-8">
            <div id="quiz-number" class="text-sm text-gray-500">Question 1 / 10</div>
            <h1 id="quiz-question" class="mt-2 text-2xl font-semibold text-gray-800">Quelle est la capitale de la :</h1>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <button class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Error</button>
                <button class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Error</button>
                <button class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Error</button>
                <button class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Error</button>
            </div>

        </div>
    <!-- </main> -->
    
</body>
<!-- <!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quiz — Question</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Small helper to keep answers same height */
        .answer { min-height: 4.5rem; }
    </style>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center">
    <main class="w-full max-w-2xl p-6">
        <div class="bg-white shadow-lg rounded-xl p-8">
            <div class="text-sm text-gray-500">Question 1 / 10</div>
            <h1 class="mt-2 text-2xl font-semibold text-gray-800">Quelle est la capitale de la France ?</h1>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="answer flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Paris</div>
                <div class="answer flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Lyon</div>
                <div class="answer flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Marseille</div>
                <div class="answer flex items-center justify-center border border-gray-200 rounded-lg p-6 text-center text-gray-800 hover:bg-gray-50 cursor-pointer">Toulouse</div>
            </div>

        </div>
    </main>
</body> -->
</html>