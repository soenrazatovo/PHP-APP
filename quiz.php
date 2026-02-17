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

    <main class="mt-16 gap-8 flex justify-center items-center">

        <div id="quiz" class="w-full max-w-2xl p-6 bg-white shadow-2xl border border-gray-200 rounded-xl p-8">
            <div id="quiz-number" class="text-sm text-gray-500">Question 0 / 10</div>
            <h1 id="quiz-question" class="mt-2 text-2xl font-semibold text-gray-800">Quelle est la capitale de la :</h1>

            <div id="quiz-grid" class="grid grid-cols-2 gap-4 mt-6">
                <!-- <div class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 hover:bg-gray-50 cursor-pointer"><p class="text-center text-gray-800">Error</p></div>
                <div class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 hover:bg-gray-50 cursor-pointer"><p class="text-center text-gray-800">Error</p></div>
                <div class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 hover:bg-gray-50 cursor-pointer"><p class="text-center text-gray-800">Error</p></div>
                <div class="quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 hover:bg-gray-50 cursor-pointer"><p class="text-center text-gray-800">Error</p></div> -->
            </div>
        </div>

        <button id="quiz-next" class="opacity-50 pointer-events-none"><img width="100" height="100" src="https://img.icons8.com/ios-filled/100/forward--v1.png" alt="forward--v1"/></button>
        <!-- cursor-pointer -->
    </main>
    
</body>
</html>