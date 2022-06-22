var select = document.getElementById('selectdata');
var fileinput = document.getElementById('fileinput');
var addquestion = document.getElementById('addquestion');
select.onchange = function(data){
    if(data.target.value=="Quiz"){
        fileinput.hidden = true;
        addquestion.hidden = false;
        
    }else{
        addquestion.hidden = true;
        fileinput.hidden = false;
    }
}


document.onload = function(){
   
    
    let doc = document.getElementById("createactivity");
    doc.addEventListener('click', function() {
        
        $('#myModal').modal('show');
        console.log("getclick");
    });
    
    }