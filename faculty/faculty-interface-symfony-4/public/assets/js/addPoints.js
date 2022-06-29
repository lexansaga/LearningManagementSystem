async function addPoints(actID,prevAnswers){
    var allInput = document.getElementsByClassName("points");
    let allpoints = 0;
    for (let index = allInput.length-1; index >=0; index--) {
        const element = allInput[index];
        allpoints += parseInt(element.value);

    }

    console.log(actID,prevAnswers)
    var res = await fetch(`/students/api/addpoints`,{
        credentials: 'same-origin',
        headers:{
            'Content-type':'application/json'
        },
        method:"POST",
        body:JSON.stringify({
            id:actID,
            score:allpoints,
            answers:prevAnswers
        })
        
    })

    window.location.reload();
}