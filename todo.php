<?php
    session_start();
    include_once "C:\laragon\www\SLAM\Account\partials\check_session.php";
    include "C:\laragon\www\SLAM\Account\config\db_config.php";

    if (isset($_POST["submit"])) {
        if (!empty($_POST["content"])) {

            $content = $_POST["content"];
            $addTodoList = "INSERT INTO todo (content) VALUES (?)"; 

            $stmt = $db->prepare($addTodoList);
            $stmt->execute([$content]);

        } else {
            $error = true;
        }

        header("Location: todo.php");
        exit();
    }

    if (isset($_GET["id"]) && isset($_GET["delete"]) && $_GET["delete"]) {
        $deletTodoList = "DELETE FROM todo WHERE id = ?"; 
        $stmt = $db->prepare($deletTodoList);
        $stmt->execute([$_GET["id"]]);

        header("Location: todo.php");
        exit();
    }

    if (isset($_GET["id"]) && isset($_GET["checked"])) {
        $updateTodoList = "UPDATE todo SET checked = ? WHERE id = ?"; 
        $stmt = $db->prepare($updateTodoList);
        var_dump(intval($_GET["checked"]));
        $stmt->execute([intval($_GET["checked"]), $_GET["id"]]);

        header("Location: todo.php");
        exit();
    }

    if(isset($_GET["id"]) && isset($_GET["edit"]) && $_GET["edit"] == "done"){

        $content = $_POST["edit-input"];
        $updateTodoList = "UPDATE todo SET content = ? WHERE id = ?"; 
        $stmt = $db->prepare($updateTodoList);
        $stmt->execute([$content, $_GET["id"]]);

        header("Location: todo.php");
        exit();
    }

    $getTodoList = "SELECT * FROM todo";
    $todoList = $db->query($getTodoList)->fetchAll();
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <?php include_once "C:\laragon\www\SLAM\Account\partials\header_session_tailwind.php"; ?>

    <h1 class="m-4 text-center text-5xl font-bold">TODO LIST</h1>
    
    <?php if (isset($error)) :?>
        <h1 class="m-4 text-center text-2xl font-bold text-red-500">Veuillez remplir le contenu de la todo</h1>
    <?php endif ?>

    <form class="m-auto mt-4 mb-4 w-fit flex gap-4"  action="" method="POST">
            <input class="border-solid border-1 border-black rounded-xl p-2" type="text" name="content" id="content-input" placeholder="Ajouter une tâche">
            <input class="border-solid border-1 border-black rounded-xl p-2 bg-teal-200 hover:bg-teal-400" type="submit" name="submit" id="submit-input" value="Ajouter">
    </form>

    <div class="grid grid-cols-[repeat(auto-fit,minmax(300px,1fr))] gap-4 p-4">

        <?php if (isset($todoList)) :?>
            <?php foreach ($todoList as $todo) :?>    
                <form class="flex gap-4 justify-between items-center border-solid border-1 border-black rounded-xl p-4 bg-teal-200" action="todo.php?id=<?= $todo["id"]?>&edit=done" method="POST">
                    
                
                    <?php if (intval($todo["checked"])) : ?>
                        <a class="relative flex justify-center items-center text-3xl" href="todo.php?id=<?=$todo["id"]?>&checked=0">&#10063;
                            <p class="absolute text-base -translate-x-0.5">&#10003;</p>
                        </a>
                    <?php else : ?>
                        <a class="text-3xl" href="todo.php?id=<?=$todo["id"]?>&checked=1">&#10063;</a>
                    <?php endif ?>
                    
                    
                    <div class="flex flex-col items-center justify-between">

                        <?php if (isset($_GET["id"]) && isset($_GET["edit"]) && $_GET["edit"] && $_GET["id"]==$todo["id"]) : ?>
                            <input class="w-full border-solid border-1 border-black rounded-xl p-2" type="text" name="edit-input" value="<?= $todo["content"]?>">
                        <?php else : ?>

                            <?php if (intval($todo["checked"])) : ?>
                                <p class="line-through text-center"><?= $todo["content"] ?></p>
                            <?php else : ?>
                                <p class="text-center"><?= $todo["content"] ?></p>
                            <?php endif ?>

                            <p><?= $todo["date"] ?></p>
                        <?php endif ?>
                        
                    </div>

                    <div class="flex gap-1">

                        <?php if (isset($_GET["id"]) && isset($_GET["edit"]) && $_GET["edit"] && $_GET["id"]==$todo["id"]) : ?>
                            <input class="flex justify-center items-center w-8 h-8 border-solid border-1 border-black rounded-full p-0 bg-white hover:text-red-500 cursor-pointer" type="submit" name="submit" value="&#10003;">
                        <?php else : ?>
                            <a href="todo.php?id=<?= $todo["id"]?>&edit=true" class="flex justify-center items-center w-8 h-8 border-solid border-1 border-black rounded-full p-0 bg-white hover:text-red-500 cursor-pointer">&#9998;</a>
                        <?php endif ?>
                        
                        <?php if (!(isset($_GET["id"]) && isset($_GET["edit"]) && $_GET["edit"] && $_GET["id"]==$todo["id"])) : ?>
                            <a href="todo.php?id=<?= $todo["id"]?>&delete=true" class="flex justify-center items-center w-8 h-8 border-solid border-1 border-black rounded-full p-0 bg-white hover:text-red-500 cursor-pointer">&#10005;</a>
                        <?php endif ?>
                    </div>
                </form>
            <?php endforeach ?>
        <?php endif ?> 

    <div>

</body>
</html>