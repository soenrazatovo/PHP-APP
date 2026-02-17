import countries from "../pays-capitales.json" with {type: "json"};
// console.log(countries);

function randomElement({array, condition = () => {return true}, exclude = []}){
    // Fonctionne avec un NodeList
    let filtered = Array.from(array).filter(elem => (condition(elem) && !exclude.includes(elem)));
    return filtered.length != 0 ? filtered[Math.floor(Math.random()*(filtered.length))] : null;
    
}

function randomQuestion(){
    let correct = randomElement({array: countries})
    let options = [correct]
    
    for(let i=0; i < 3; i++){
        options.push(randomElement({array: countries, condition: (country)=>{return country.zone==correct.zone}, exclude: options}))
    }

    return {correct: correct, options: options}
}

function newQuestion(){
    
    let question = randomQuestion()
    console.log(question)

    quizQuestion.textContent = "Quelle est la capitale de \"" + question.correct.pays + "\" ?"
    
    let quizBtns = []
    quizGrid.innerHTML=""

    if(document.querySelector("#quiz-submit")){
        quiz.removeChild(document.querySelector("#quiz-submit"))
    }

    let newSubmitBtn=document.createElement("div");
    newSubmitBtn.classList="opacity-50 pointer-events-none mt-4 block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    newSubmitBtn.textContent="Submit"
    newSubmitBtn.id="quiz-submit";

    question.options.forEach(option => {
        let quizBtn = document.createElement("div");
        quizBtns.push(quizBtn);
        quizBtn.classList = "quiz-button flex items-center justify-center border border-gray-200 rounded-lg p-6 hover:bg-gray-50 cursor-pointer"
        quizBtn.innerHTML = '<p class="text-center text-gray-800">'+ option.capitale +'</p>'
        
        quizBtn.addEventListener("click", ()=>{

            quizBtns.forEach(btn => btn.classList.remove("selected", "border-indigo-600"))
            quizBtn.classList.add("selected", "border-indigo-600")

            newSubmitBtn.classList.remove("opacity-50", "pointer-events-none")
            newSubmitBtn.classList.add("cursor-pointer")

            // if (option != question.correct){
            //     quizBtn.style.setProperty("box-shadow","0 0 20px");
            //     quizBtn.style.setProperty("color","red");
            // } else {
            //     score+=1
            //     quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion + " - Score : " + score
            // }

            // // randomBtns[0] => Correct Button
            // quizBtns[0].style.setProperty("box-shadow","0 0 20px");
            // quizBtns[0].style.setProperty("color","green");
            
            // // Disable buttons
            // quizBtns.forEach(btn => {btn.classList.add("opacity-95", "pointer-events-none")})

        });
    });


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

    for(let i=0; i < 4; i++){
        quizGrid.append(randomElement({array:quizBtns, exclude:Array.from(quizGrid.childNodes)}));
    }

    quiz.appendChild(newSubmitBtn)

}

const quiz = document.querySelector("#quiz")
const quizQuestion = document.querySelector("#quiz-question")
const quizNumber = document.querySelector("#quiz-number")
const quizGrid = document.querySelector("#quiz-grid")
const nextBtn = document.querySelector("#quiz-next")
const submitBtn = document.querySelector("#quiz-submit")

const maxQuestion = 10
let score = 0
let questionCount = 1

console.log(nextBtn.classList)

window.addEventListener("DOMContentLoaded", () => {
    quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion
    newQuestion()
});

nextBtn.addEventListener("click", () => {
    if(questionCount == 0){
        quiz.innerHTML = ""
        quiz.append(quizNumber,quizQuestion,quizGrid)
    }
    questionCount+=1
    
    if(questionCount <= maxQuestion){
        quizNumber.textContent = "Question "+ questionCount +" / "+ maxQuestion + " - Score : " + score
        newQuestion()
        nextBtn.classList.add("opacity-50", "pointer-events-none")
        nextBtn.classList.remove("cursor-pointer")
    } else {
        quiz.innerHTML = '<p class="text-5xl text-center"> Votre score est de '+score+' / '+maxQuestion +'</p>'
        questionCount = 0
        score = 0
    }
    
})

