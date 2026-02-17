import countries from "../pays-capitales.json" with {type: "json"};

class Quiz{
    
    #questionQuantity
    #questionCount = 1
    #score = 0
    #oldQuestions = []

    #quizContainer = document.querySelector("#quiz")
    #quizQuestion = document.querySelector("#quiz-question")
    #quizNumber = document.querySelector("#quiz-number")
    #quizGrid = document.querySelector("#quiz-grid")
    #nextBtn = document.querySelector("#quiz-next")
    #submitBtn = document.querySelector("#quiz-submit")

    constructor(_questionQuantity=20){
        this.#questionQuantity = _questionQuantity;
        
        this.#quizNumber.textContent = "Question "+ this.#questionCount +" / "+ this.#questionQuantity
        this.#oldQuestions.push(this.#newQuestion())

        this.#nextBtn.addEventListener("click", () => {
            if(this.#questionCount == 0){
                this.#quizContainer.innerHTML = ""
                this.#quizContainer.append(this.#quizNumber,this.#quizQuestion,this.#quizGrid,this.#submitBtn)
            }

            this.#questionCount+=1
            
            if(this.#questionCount <= this.#questionQuantity){
                this.#quizNumber.textContent = "Question "+ this.#questionCount +" / "+ this.#questionQuantity + " - Score : " + this.#score
                this.#oldQuestions.push(this.#newQuestion())
                this.#nextBtn.classList.add("opacity-50", "pointer-events-none")
                this.#nextBtn.classList.remove("cursor-pointer")
            } else {
                this.#quizContainer.innerHTML = '<p class="text-5xl text-center"> Votre score est de '+this.#score+' / '+this.#questionQuantity +'</p>'
                this.#questionCount = 0
                this.#score = 0
            }
        })
    }

    #randomElement({array, condition = () => {return true}, exclude = []}){
        let filtered = Array.from(array).filter(elem => (condition(elem) && !exclude.includes(elem)));
        return filtered.length != 0 ? filtered[Math.floor(Math.random()*(filtered.length))] : null;
    }

    #randomQuestion(){
        let oldCorrects = this.#oldQuestions.map(oldQuestion => oldQuestion.correct);
        let correct = this.#randomElement({array: countries, exclude: oldCorrects})
        let options = [correct]

        for(let i=0; i < 3; i++){
            options.push(this.#randomElement({array: countries, condition: (country)=>{return country.zone==correct.zone}, exclude: options}))
        }

        return {correct: correct, options: options}
    }

    #newQuestion(){
    
        let question = this.#randomQuestion(this.#oldQuestions)
        this.#quizQuestion.textContent = "Quelle est la capitale de \"" + question.correct.pays + "\" ?"
        this.#quizGrid.innerHTML=""
        
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
            this.#quizGrid.append(this.#randomElement({array:quizBtns, exclude:Array.from(this.#quizGrid.childNodes)}));
        }

        // let newSubmitBtn = document.querySelector("#quiz-submit").cloneNode(true)
        let newSubmitBtn = this.#submitBtn.cloneNode(true)

        newSubmitBtn.addEventListener("click",()=>{
            let currentQuizBtn = document.querySelector(".selected");
            
            if(currentQuizBtn.textContent != question.correct.capitale){
                currentQuizBtn.style.setProperty("box-shadow","0 0 20px");
                currentQuizBtn.style.setProperty("color","red");
            } else {
                this.#score+=1
                this.#quizNumber.textContent = "Question "+ this.#questionCount +" / "+ this.#questionQuantity + " - Score : " + this.#score
            }

            quizBtns[0].style.setProperty("box-shadow","0 0 20px");
            quizBtns[0].style.setProperty("color","green");
            
            // Disable buttons
            quizBtns.forEach(btn => {
                btn.classList.add("opacity-95", "pointer-events-none")
                btn.classList.remove("selected", "border-indigo-600")
            })

            this.#nextBtn.classList.remove("opacity-50", "pointer-events-none")
            this.#nextBtn.classList.add("cursor-pointer")

            newSubmitBtn.classList.add("opacity-50", "pointer-events-none")
            newSubmitBtn.classList.remove("cursor-pointer")
        })

        this.#submitBtn.replaceWith(newSubmitBtn)
        this.#submitBtn = newSubmitBtn;

        return question
    }
}

window.addEventListener("DOMContentLoaded", () => {
    new Quiz(5)
});