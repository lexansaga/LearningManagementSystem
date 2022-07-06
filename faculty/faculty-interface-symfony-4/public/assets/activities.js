var select = document.getElementById('selectdata');
var fileinput = document.getElementById('fileinput');
var modal = document.getElementById("mymodal");
var addquestion = document.getElementById('addquestion');
var scoreInput = document.getElementById('scoreInput');
var maxScore = document.getElementById('maxScore');
maxScore.textContent = 0;
var tempQ = [];

if(select!=null){
    select.value = "Essay";
    select.onchange = function(data){
        
        if(data.target.value=="Quiz"){
            maxScore.hidden = false;
            scoreInput.hidden = true;
            fileinput.hidden = true;
            addquestion.hidden = false;
            
        }else{
            let questions = document.getElementsByClassName('questions');
            if(questions.length!=0){
                
                for (let index = questions.length-1; index >= 0; index--) {
                    const element = questions[index];   
                    element.remove();
                }
            }
            tempQ = [];
            addquestion.hidden = true;
            fileinput.hidden = false;
            maxScore.hidden = true;
            scoreInput.hidden = false;
        }
    }
   
}

if(addquestion!=null){
    let currentindex = 0;


    addquestion.onclick = function(){
        let obj = {};
        let questionlabel = document.createElement("label");
        questionlabel.textContent = "Question"
        let question = document.createElement("input");
        question.addEventListener('change',(data)=>{
            obj[`question`] = data.target.value;
        });
        let answerlabel = document.createElement("label");
        answerlabel.textContent = "Correct Answer"
        let score = document.createElement("input");
        score.addEventListener('change',(data)=>{
            if(Number.isInteger(parseInt(data.target.value))){

                maxScore.textContent = parseInt(maxScore.textContent) + parseInt(data.target.value);
                obj['score'] = data.target.value;
            }
            
            
        })

        let answer = document.createElement("input");
        let row3 = document.createElement("div");
        let row4 = document.createElement("div");
        questionlabel.classList.add("col");
        question.classList.add("col");
        answerlabel.classList.add("col");
        answer.classList.add("col");
        row3.classList.add("row");
        row4.classList.add("row");
        row3.appendChild(questionlabel);
        row3.appendChild(question);
        row4.appendChild(answerlabel);
        row4.appendChild(answer);
        
        

        answer.addEventListener('change',(data)=>{
            obj[`answer`] = data.target.value;
        });
        let row5 = document.createElement("div");
        let selectTemp = document.createElement("select");
        
        let optionTemp1 = document.createElement("option");
        let optionTemp2 = document.createElement("option");
        let optionTemp3 = document.createElement("option");

        optionTemp3.text = "Identification";
        optionTemp3.value = "Identification";
        optionTemp1.text = "Multiple";
        optionTemp1.value = "Multiple";
        optionTemp2.text = "Essay";
        optionTemp2.value = "Essay";
        
        
        selectTemp.add(optionTemp1);
        selectTemp.add(optionTemp2);
        selectTemp.add(optionTemp3);
        selectTemp.value ="Identification"
        
        row5.appendChild(selectTemp);
        row5.appendChild(score);
        row5.classList.add("row");
        obj[`activitytype`] = "Identification";
        selectTemp.addEventListener('change',(data)=>{
            
            obj[`activitytype`] = data.target.value;
            if(data.target.value == "Multiple"){
                answerlabel.hidden = false;
                answer.hidden = false;
                let choice1 = document.createElement("input");
                let choice2 = document.createElement("input");
                let choice3 = document.createElement("input");
                let label1 = document.createElement("label");
                let label2 = document.createElement("label");
                let label3 = document.createElement("label");
                choice1.classList.add("questions");
                choice1.addEventListener('change',(data)=>{
                    obj[`firstchoice`]=data.target.value
                });
                choice2.classList.add("questions");
                choice2.addEventListener('change',(data)=>{
                    obj[`secondchoice`]=data.target.value
                });
                choice3.classList.add("questions");
                choice3.addEventListener('change',(data)=>{
                    obj[`thirdchoice`]=data.target.value
                });
                let row = document.createElement("div");

                let row1 = document.createElement("div");
                let row2 = document.createElement("div");
                row.classList.add("row");
                row1.classList.add("row");
                row2.classList.add("row");
                label1.classList.add("questions");
                label2.classList.add("questions");
                label3.classList.add("questions");
                choice1.classList.add(`questionsChoice${currentindex}`);
                choice2.classList.add(`questionsChoice${currentindex}`);
                choice3.classList.add(`questionsChoice${currentindex}`);
                label1.classList.add(`questionsChoice${currentindex}`);
                label2.classList.add(`questionsChoice${currentindex}`);
                label3.classList.add(`questionsChoice${currentindex}`);
                label1.textContent = "ANSWER 1";
                label2.textContent = "ANSWER 2";
                label3.textContent = "ANSWER 3";

                row.appendChild(label1);
                row.appendChild(choice1);
                row1.appendChild(label2);
                row1.appendChild(choice2);
                row2.appendChild(label3);
                row2.appendChild(choice3);
                modal.appendChild(row);
                modal.appendChild(row1);
                modal.appendChild(row2);
                
                
            }else{
                if(data.target.value=="Essay"){
                    answerlabel.hidden = true;
                    answer.hidden = true;
                }else{
                    answerlabel.hidden = false;
                    answer.hidden = false;
                }
                
                let questionsChoice = document.getElementsByClassName(`questionsChoice${currentindex}`);
                if(questionsChoice.length!=0){
                    
                    for (let index = questionsChoice.length-1; index >= 0; index--) {
                        const element = questionsChoice[index];   
                        element.remove();
                    }
                }
            }
        })
        score.classList.add("questions");
        selectTemp.classList.add("questions");
        answer.classList.add("questions");
        question.classList.add("questions");
        questionlabel.classList.add("questions");
        answerlabel.classList.add("questions");
        
        modal.appendChild(row3);
        modal.appendChild(row4);
        modal.appendChild(row5);
        
        console.log(obj.hasOwnProperty(`question${currentindex}`),obj);

        tempQ.push(obj);
        currentindex++;
    }

}

var temp = document.getElementById("actbutton");
var objTemp = new FormData();
if(temp!=null){


    fileinput.addEventListener('change',(data)=>{
        for (let index = 0; index <  data.target.files.length; index++) {
            const element =  data.target.files[index];
            objTemp.append(`file${index}`,element);
            objTemp.append(`filename${index}`,element.name);
        }
        
    })
    
}
async function addActivity(data,coursename,programclass){   
    let err = document.getElementById("errorACT");
    let hasvalue = true;

    let description = document.getElementById("description").value;
    let activityname = document.getElementById("activityname").value;
    let maxAttempt = document.getElementById("maxattempt").value;
    let deadline = document.getElementById("deadline").value;
    objTemp.append('activitytype',select.value);


    objTemp.append('activityname',activityname);
    
    let currentScore = 0;
    let somemutiplesareequal = false;
    if(select.value=="Quiz"){
        
        tempQ.forEach((a)=>{
            if(a.activitytype!="Essay"&&(!a.hasOwnProperty("question")||!a.hasOwnProperty("answer")||!a.hasOwnProperty("score"))){
                hasvalue = false;
                
            }else{
                if(!a.hasOwnProperty("question")||!a.hasOwnProperty("score")){
                    hasvalue = false;
                }
            }
            if(a.activitytype=="Multiple"){
                if(!a.hasOwnProperty('firstchoice')||!a.hasOwnProperty('secondchoice')||!a.hasOwnProperty('thirdchoice')){
                    hasvalue = false;
                }else{
                    if(a.firstchoice==a.secondchoice||a.firstchoice==a.thirdchoice||a.secondchoice==a.thirdchoice||a.answer==a.firstchoice||a.answer==a.secondchoice||a.answer==a.thirdchoice){
                        somemutiplesareequal = true;
                    }

                }
            }
            
        })

        console.log(hasvalue,somemutiplesareequal);
        objTemp.append('questions',JSON.stringify(tempQ));
        currentScore = parseInt(maxScore.textContent);
        objTemp.append('maxscore',currentScore);
    }else{
        currentScore = parseInt(scoreInput.value);
        objTemp.append('maxscore',currentScore);
    }
    
    if(currentScore==NaN||currentScore==0||description==""||activityname==""||maxAttempt==""||deadline==""){
        err.textContent = "COMPLETE MISSING FIELDS";
        return;
    }
    if(hasvalue&&somemutiplesareequal){
        err.textContent = "PLEASE CHECK THE CHOICES IF IT HAS A SAME VALUE WITH THE OTHER CHOICES";
        return
    }
    
    err.textContent = "";
    
    objTemp.append('description',description);
    objTemp.append('allowfile',document.getElementById("allowfile").value);
    objTemp.append('tasktype',document.getElementById("tasktype").value);
    objTemp.append('maxattempt',maxAttempt);
    objTemp.append('allowlate',document.getElementById("allowlate").value);
    objTemp.append('facultyloadid',data);
    
    objTemp.append('deadline',deadline);

    objTemp.append('course',coursename);
    objTemp.append('programclass',programclass);
    
    var res = await fetch('/subjects/api/addActivity',{
        credentials: 'same-origin',
        
        method:"POST",
        body:objTemp,
        
    })
   window.location.reload();
}

async function clickRemove(id){
    var res = await fetch('/subjects/api/removeActivity',{
        credentials: 'same-origin',
        headers:{
            'Content-type':'application/json'
        },
        method:"POST",
        body:
        JSON.stringify({
            id:id
        }),
        
    })
    window.location.reload();
}
function clickFile(data){
    console.log(data.value);
    
    

}