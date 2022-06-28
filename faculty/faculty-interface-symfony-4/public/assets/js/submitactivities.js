var answers = document.getElementsByClassName("answers");
var inputFile = document.getElementById("formFileMultiple");




let formData = new FormData();
if(inputFile!=null){
    inputFile?.addEventListener("change",(data)=>{
    
        for (let index = 0; index <  data.target.files.length; index++) {
            const element =  data.target.files[index];
            formData.append(`file${index}`,element);
            formData.append(`filename${index}`,element.name);
        }
       
        
    })
}
async function submitAnswer(data,actid,studentid,programclass,course,roomID) {
    
    
    let correctanswers = [];
    
    let points = 0;
    for (let index = answers.length-1; index >= 0; index--) {
        const eachelement = answers[index];
        
        for (let i = data.length-1; i >= 0; i--) {
            const element = data[i];
            
            if(element.activitytype=="Multiple" ){
                
                if(element['question'+(i+1)].trim()==eachelement.ariaLabel){
                    if(eachelement.checked){
                        let judge = "wrong";
                        if(eachelement.value==element['answer'+(i+1)]){

                            points += parseInt(element['score'+(i+1)]);
                            judge = "right";
                        }
                        correctanswers = [...correctanswers,{
                            activitytype:"Multiple",
                            answer:eachelement.value.trim(),
                            type:judge,
                            question: eachelement.ariaLabel
                        }];
                    }

                    
                }
            }else{

                if(element['question'+(i+1)].trim()==eachelement.ariaLabel){
                   
                    if(element.activitytype=="Identification"){
                        let judge = "wrong";
                        if(element['answer'+(i+1)].trim()==eachelement.value.trim()){

                            points += parseInt(element['score'+(i+1)]);
                            judge = "right"
                        }
                        correctanswers = [...correctanswers,{
                            activitytype:"Identification",
                            answer:eachelement.value.trim(),
                            type:judge,
                            question: eachelement.ariaLabel
                        }];
                    }
                    if(element.activitytype=="Essay"){
                        correctanswers = [...correctanswers,{
                            activitytype:"Essay",
                            answer:eachelement.value.trim(),
                            type:"wrong",
                            question: eachelement.ariaLabel
                        }];
                    }
                }
            }
        }
        
        console.log(points);
        
    }

    

    formData.append("correctanswers",JSON.stringify(correctanswers));
    formData.append("score",points);
    formData.append("activityid",actid);
    formData.append("studentid",studentid);
    formData.append("programclass",programclass);
    formData.append("course",course);
    
    await fetch("/student/submitActivity",{
        credentials: 'same-origin',
        
        method:"POST",
        body: formData
        
    })

    
    
    
}


