import countries from "../pays-capitales.json" with {type: "json"};
// console.log(countries);

function randomElement(array, condition = () => {return true}, exclude = []){
    let element = array[Math.floor(Math.random()*(array.length))];
    while (!condition(element) || exclude.includes(element)) {
        element = array[Math.floor(Math.random()*(array.length))];
    }
    return element
}

function btnAnswer(answer, btn) {
    if (answer["capitale"]==btn.textContent){
        alert("Bonne réponse");
        newQuestion();
    } else{
        alert("Réponse incorrect");
    }
}


function newQuestion(){
    
    let answer = randomElement(countries);
    
    let errors = []
    while (errors.length != 3){
        errors.push(randomElement(countries, (country)=>{return country["zone"]==answer["zone"]}, errors));
    }
    
    let answers = errors;
    answers.push(answer);
    
    console.log(answer);
    console.log(answers);
    
    const quizQuestion = document.querySelector("#quiz-question");
    quizQuestion.textContent = "Quelle est la capitale de \"" + answer["pays"] + "\"";
    
    const btns = document.querySelectorAll(".quiz-button");
    
    let randomAnswers = [];
    
    btns.forEach(btn => {
        let currentAnswer = randomElement(answers,()=>{return true}, randomAnswers);
        btn.textContent = currentAnswer["capitale"];
        randomAnswers.push(currentAnswer);
        
        btn.removeEventListener("click", btnAnswer);
        
        btn.addEventListener("click", ()=>{
            if (answer["capitale"]==btn.textContent){
                alert("Bonne réponse");
                newQuestion();
            } else{
                alert("Réponse incorrect");
            }
        });
    
    });

}

window.addEventListener("DOMContentLoaded", () => {newQuestion()});




