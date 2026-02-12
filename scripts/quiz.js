import countries from "../pays-capitales.json" with {type: "json"};
// console.log(countries);

function randomElement({array, condition = () => {return true}, exclude = []}){
    // Fonctionne avec un NodeList
    let filtered = Array.from(array).filter(elem => (condition(elem) && !exclude.includes(elem)));
    return filtered.length != 0 ? filtered[Math.floor(Math.random()*(filtered.length))] : 0;
    
}

function newQuestion(){
    
    let correct = randomElement({array: countries});
    let answers = [correct];
    
    while (answers.length != 4){
        answers.push(randomElement({array: countries, condition: (country)=>{return country["zone"]==correct["zone"]}, exclude: answers}));
    }
    
    console.log(correct);
    console.log(answers);
    
    let quizQuestion = document.querySelector("#quiz-question");
    quizQuestion.textContent = "Quelle est la capitale de \"" + correct["pays"] + "\" ?";
    
    let btns = document.querySelectorAll(".quiz-button");
    let oldRandomBtns = [];
    let newRandomBtns = [];

    answers.forEach(answer => {
        // randomBtn to remove previous event listeners
        let oldRandomBtn = randomElement({array: btns, exclude: oldRandomBtns});
        oldRandomBtns.push(oldRandomBtn);
        
        let newRandomBtn = oldRandomBtn.cloneNode(true);
        newRandomBtns.push(newRandomBtn);

        newRandomBtn.childNodes[0].textContent = answer["capitale"];

        newRandomBtn.addEventListener("click", ()=>{
            if (answer != correct){
                newRandomBtn.style.setProperty("box-shadow","0 0 20px");
                newRandomBtn.style.setProperty("color","red");
            }

            // randomBtns[0] => Correct Button
            newRandomBtns[0].style.setProperty("box-shadow","0 0 20px");
            newRandomBtns[0].style.setProperty("color","green");

            // Disable buttons
            newRandomBtns.forEach(btn => {btn.style.pointerEvents = "none";})
        });

        oldRandomBtn.replaceWith(newRandomBtn);
    });


    // let randomAnswers = [];
    
    // btns.forEach(btn => {
    //     let currentAnswer = randomElement({array: answers, exclude: randomAnswers});
    //     randomAnswers.push(currentAnswer);

    //     btn.textContent = currentAnswer["capitale"];
        
    //     const clone = btn.cloneNode(true);

    //     clone.addEventListener("click", ()=>{
            
    //         if (answer["capitale"]==clone.textContent){
    //             alert("Bonne réponse");
    //             newQuestion();
    //         } else{
    //             alert("Réponse incorrect");
    //         }
    //     });

    //     btn.replaceWith(clone);
    // });

}

// window.addEventListener("DOMContentLoaded", () => {newQuestion()});
newQuestion();




