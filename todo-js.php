<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="scripts/app.js" defer></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    >
</head>
<body class="overflow-y-hidden">
    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>
    <h1 class="m-4 text-center text-5xl font-bold">TODO LIST</h1>

    <div class="m-auto mt-4 mb-4 w-fit flex gap-4">
        <input class="border-solid border-1 border-black rounded-xl p-2" type="text" name="content" id="todo-content" placeholder="Ajouter une tâche">
        <input class="border-solid border-1 border-black rounded-xl p-2 bg-teal-200 hover:bg-teal-400" type="submit" name="submit" id="todo-submit" value="Ajouter">
    </div>

    <div class="grid grid grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-4 p-4 w-9/10 m-auto" id="todo-grid">
    </div>


</body>