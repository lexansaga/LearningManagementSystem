let inputFile = document.getElementById("formFileMultiple");
let err = document.getElementById("error");

var formdata = new FormData();

inputFile.addEventListener('change',(data)=>{
    
    err.textContent = "";
    for (let index = 0; index <  data.target.files.length; index++) {
        const element =  data.target.files[index];
        formdata.append(`file${index}`,element);
        formdata.append(`filename${index}`,element.name);
        
    }
    
    formdata.append('id',inputFile.dataset.isAuthenticated);
    
    
})


async function uploadPayment(){
    if(inputFile.value==""){
        
        err.textContent = "PLEASE UPLOAD FILES";
        return;
    }
    
    var res = await fetch('/students/api/uploadPayment',{
        credentials: 'same-origin',
        
        method:"POST",
        body:formdata,
        
    })
    window.location.reload()
}