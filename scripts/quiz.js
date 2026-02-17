import countries from "../pays-capitales.json" with {type: "json"};
// console.log(countries);

function randomElement({array, condition = () => {return true}, exclude = []}){
    // Fonctionne avec un NodeList
    let filtered = Array.from(array).filter(elem => (condition(elem) && !exclude.includes(elem)));
    return filtered.length != 0 ? filtered[Math.floor(Math.random()*(filtered.length))] : null;
    
}

function randomQuestion(oldQuestions=[]){
    let oldCorrects;

    if(oldQuestions!=[]){
        oldCorrects = oldQuestions.map(oldQuestion => oldQuestion.correct);
    } else {
        oldCorrects = []
    }

    let correct = randomElement({array: countries, exclude: oldCorrects})
    let options = [correct]
    
    for(let i=0; i < 3; i++){
        options.push(randomElement({array: countries, condition: (country)=>{return country.zone==correct.zone}, exclude: options}))
    }

    return {correct: correct, options: options}
}


// const quiz = document.querySelector("#quiz")
// const quizQuestion = document.querySelector("#quiz-question")
// const quizNumber = document.querySelector("#quiz-number")
// const quizGrid = document.querySelector("#quiz-grid")
// const nextBtn = document.querySelector("#quiz-next")

// const maxQuestion = 20
// let score = 0
// let questionCount = 1

// window.addEventListener("DOMContentLoaded", () => {
//     quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion
//     newQuestion()
// });

// nextBtn.addEventListener("click", () => {
//     if(questionCount == 0){
//         quiz.innerHTML = ""
//         quiz.append(quizNumber,quizQuestion,quizGrid)
//     }
//     questionCount+=1
    
//     if(questionCount <= maxQuestion){
//         quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion + " - Score : " + score
//         newQuestion()
//         nextBtn.classList.add("opacity-50", "pointer-events-none")
//         nextBtn.classList.remove("cursor-pointer")
//     } else {
//         quiz.innerHTML = '<p class="text-5xl text-center"> Votre score est de '+score+' / '+maxQuestion +'</p>'
//         questionCount = 0
//         score = 0
//     }
    
// })

function initQuiz() {
    const quiz = document.querySelector("#quiz")
    const quizQuestion = document.querySelector("#quiz-question")
    const quizNumber = document.querySelector("#quiz-number")
    const quizGrid = document.querySelector("#quiz-grid")
    const nextBtn = document.querySelector("#quiz-next")

    const maxQuestion = 20
    let score = 0
    let questionCount = 1
    let oldQuestions = []

    function newQuestion(){
    
        let question = randomQuestion(oldQuestions)
        quizQuestion.textContent = "Quelle est la capitale de \"" + question.correct.pays + "\" ?"
        quizGrid.innerHTML=""
        
        let quizBtns = []
        question.options.forEach(option => {
            if(option != null){
                
                let quizBtn = document.createElement("div");
                quizBtns.push(quizBtn);
                quizBtn.classList = "quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 hover:bg-gray-50 cursor-pointer"
                quizBtn.innerHTML = '<p class="text-center text-gray-800">'+ option.capitale +'</p>'
                
                quizBtn.addEventListener("click", ()=>{
        
                    quizBtns.forEach(btn => btn.classList.remove("selected", "border-indigo-600"))
                    quizBtn.classList.add("selected", "border-indigo-600")
        
                    newSubmitBtn.classList.remove("opacity-50", "pointer-events-none")
                    newSubmitBtn.classList.add("cursor-pointer")
        
                });

            } else {
                let quizBtn = document.createElement("div");
                quizBtns.push(quizBtn);
                quizBtn.classList = "quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 bg-gray-200"
            }
        });

        for(let i=0; i < 4; i++){
            quizGrid.append(randomElement({array:quizBtns, exclude:Array.from(quizGrid.childNodes)}));
        }

        let newSubmitBtn = document.querySelector("#quiz-submit").cloneNode()
        newSubmitBtn.textContent="Submit"

        newSubmitBtn.addEventListener("click",()=>{
            let currentQuizBtn = document.querySelector(".selected");
            
            if(currentQuizBtn.textContent != question.correct.capitale){
                currentQuizBtn.style.setProperty("box-shadow","0 0 20px");
                currentQuizBtn.style.setProperty("color","red");
            } else {
                score+=1
                quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion + " - Score : " + score
            }

            quizBtns[0].style.setProperty("box-shadow","0 0 20px");
            quizBtns[0].style.setProperty("color","green");
            
            // Disable buttons
            quizBtns.forEach(btn => {
                btn.classList.add("opacity-95", "pointer-events-none")
                btn.classList.remove("selected", "border-indigo-600")
            })

            nextBtn.classList.remove("opacity-50", "pointer-events-none")
            nextBtn.classList.add("cursor-pointer")

            newSubmitBtn.classList.add("opacity-50", "pointer-events-none")
            newSubmitBtn.classList.remove("cursor-pointer")
        })

        document.querySelector("#quiz-submit").replaceWith(newSubmitBtn)

        return question
    }

    quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion
    oldQuestions.push(newQuestion(score,questionCount,maxQuestion,oldQuestions))

    nextBtn.addEventListener("click", () => {
        if(questionCount == 0){
            quiz.innerHTML = ""
            quiz.append(quizNumber,quizQuestion,quizGrid)
        }

        questionCount+=1
        
        if(questionCount <= maxQuestion){
            quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion + " - Score : " + score
            oldQuestions.push(newQuestion(score,questionCount,maxQuestion,oldQuestions))
            console.log(oldQuestions)
            nextBtn.classList.add("opacity-50", "pointer-events-none")
            nextBtn.classList.remove("cursor-pointer")
        } else {
            quiz.innerHTML = '<p class="text-5xl text-center"> Votre score est de '+score+' / '+maxQuestion +'</p>'
            questionCount = 0
            score = 0
        }
    })

}

window.addEventListener("DOMContentLoaded", () => {
    initQuiz()
});
