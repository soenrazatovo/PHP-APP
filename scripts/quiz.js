import countries from "../pays-capitales.json" with {type: "json"};
// console.log(countries);

function randomElement({array, condition = () => {return true}, exclude = []}){
    let filtered = array.filter(elem => (condition(elem) && !exclude.includes(elem)));
    return filtered.length != 0 ? filtered[Math.floor(Math.random()*(filtered.length))] : 0;
    
}

function newQuestion(){
    
    let answer = randomElement({array: countries});
    let answers = [answer];
    
    while (answers.length != 4){
        answers.push(randomElement({array: countries, condition: (country)=>{return country["zone"]==answer["zone"]}, exclude: answers}));
    }
    
    console.log(answer);
    console.log("Errors", answers);
    
    let quizQuestion = document.querySelector("#quiz-question");
    quizQuestion.textContent = "Quelle est la capitale de \"" + answer["pays"] + "\"";
    
    let btns = document.querySelectorAll(".quiz-button");
    
    let randomAnswers = [];
    
    btns.forEach(btn => {
        let currentAnswer = randomElement({array: answers, exclude: randomAnswers});
        randomAnswers.push(currentAnswer);

        btn.textContent = currentAnswer["capitale"];
        
        const clone = btn.cloneNode(true);

        clone.addEventListener("click", ()=>{
            
            if (answer["capitale"]==clone.textContent){
                alert("Bonne réponse");
                newQuestion();
            } else{
                alert("Réponse incorrect");
            }
        });

        btn.replaceWith(clone);
    });

}

// window.addEventListener("DOMContentLoaded", () => {newQuestion()});
newQuestion();




