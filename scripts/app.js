// Shop-item
const removeBtns = document.querySelectorAll(".removeBtn");

removeBtns.forEach(removeBtn => {
    console.log(removeBtn);
    removeBtn.addEventListener("click", () => {
        const comment = removeBtn.parentNode.parentNode.parentNode.parentNode;
        comment.classList.add("animate__bounceOut");
        comment.style.setProperty('--animate-duration', '3s');

    });

});

// parentNode
// childNodes
// uuiv for unique hash

// Todo
const todoContent = document.querySelector("#todo-content");
const todoSubmit = document.querySelector("#todo-submit");
const todoGrid = document.querySelector("#todo-grid");

function saveTodo(id, content, checked) {
    let todos = JSON.parse(localStorage.getItem("todos")) || [];
    
    let todoCellObject = {
        id : id,
        content: content,
        checked: checked
    };

    exist = false;
    for(let i = 0; i<todos.length; i++){
        if(todos[i]["id"] == id){
            todos.splice(i,1, todoCellObject);
            exist = true;
        }
    }

    if(!exist){
        todos.push(todoCellObject);
    }

    localStorage.setItem("todos", JSON.stringify(todos));
}

function removeTodo(id){
    let todos = JSON.parse(localStorage.getItem("todos")) || [];
    for(let i = 0; i<todos.length; i++){
        if(todos[i]["id"] == id){
            todos.splice(i,1);
        }
    }
    localStorage.setItem("todos", JSON.stringify(todos))
}

function createTodo(content, checked = false){
    if(content != ""){
        let todos = JSON.parse(localStorage.getItem("todos")) || [];
        let id = todos.length != 0 ? todos[todos.length-1]["id"]+1 : 0;
        loadTodo(id, content, checked);
        saveTodo(id, content, checked);
    }
}

function loadTodo(id, content, checked) {
    todoContent.value = "";

    let todoCell = document.createElement("div");
    todoCell.classList = "animate__animated animate__backInUp flex gap-4 justify-between items-center border-solid border-1 border-black rounded-xl p-4 bg-teal-200";
    todoCell.style.setProperty("--animate-duration", "0.75s");

    let todoCheckbox = document.createElement("input");
    todoCheckbox.type = "checkbox";
    todoCheckbox.checked = checked;

    let todoText = document.createElement("p");
    todoText.classList = "text-center";
    todoText.textContent = content;
    todoText.style.setProperty("overflow-wrap", "anywhere")

    let todoTextInput = document.createElement("input");
    todoTextInput.classList = "w-full border-solid border-1 border-black rounded-xl p-2";
    todoTextInput.style.setProperty("display","none");
    todoTextInput.type = "text";
    todoTextInput.value = content;

    if(todoCheckbox.checked){
        todoText.classList.add("line-through")
    }
    todoCheckbox.addEventListener("click", () => {
        todoText.classList.toggle("line-through");
        saveTodo(id, todoText.textContent, todoCheckbox.checked);
    });

    let todoEdit = document.createElement("button");
    todoEdit.classList = "flex justify-center items-center w-8 h-8 border-solid border-1 border-black rounded-full p-0 bg-white hover:text-red-500 cursor-pointer";
    todoEdit.innerHTML = "&#9998;";

    let todoConfirm = document.createElement("button");
    todoConfirm.classList = "flex justify-center items-center w-8 h-8 border-solid border-1 border-black rounded-full p-0 bg-white hover:text-red-500 cursor-pointer";
    todoConfirm.innerHTML = "&#10003;";
    todoConfirm.style.setProperty("display","none");

    todoEdit.addEventListener("click", () => {
        console.log("click")
        todoEdit.style.setProperty("display","none");
        todoText.style.setProperty("display","none");
        todoConfirm.style.setProperty("display","block");
        todoTextInput.style.setProperty("display","block");
    });

    todoConfirm.addEventListener("click", () => {
        todoText.textContent = todoTextInput.value;
        todoConfirm.style.setProperty("display","none");
        todoTextInput.style.setProperty("display","none")
        todoEdit.style.setProperty("display","block");
        todoText.style.setProperty("display","block");
        saveTodo(id, todoText.textContent, todoCheckbox.checked);
    });

    let todoDelete = document.createElement("button");
    todoDelete.classList = "flex justify-center items-center w-8 h-8 border-solid border-1 border-black rounded-full p-0 bg-white hover:text-red-500 cursor-pointer";
    todoDelete.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>'; // "&#10005;";
    todoDelete.addEventListener("click", () => {
        todoCell.classList.remove("animate__backInUp");
        todoCell.classList.add("animate__backOutDown");
        removeTodo(id);
        
        todoCell.addEventListener('animationend', () => {
            todoCell.remove();
        }, { once: true });

    });

    let todoButtons = document.createElement("div");
    todoButtons.classList = "flex gap-1";
    todoButtons.append(todoEdit, todoConfirm, todoDelete);

    todoCell.append(todoCheckbox, todoText, todoTextInput, todoButtons);
    todoGrid.append(todoCell);
}

window.addEventListener("DOMContentLoaded", () => {
    let todos = JSON.parse(localStorage.getItem("todos")) || [];
    if (todos.length){
        todos.forEach(todo => {
            loadTodo(todo["id"],todo["content"],todo["checked"]);
        });
    }
});

window.addEventListener("keydown", (event) => {
    if(event.key == "Enter"){
        if(document.activeElement == todoContent){
            createTodo(todoContent.value);
        }
    }
})
todoSubmit.addEventListener("click", () => {createTodo(todoContent.value,)});
