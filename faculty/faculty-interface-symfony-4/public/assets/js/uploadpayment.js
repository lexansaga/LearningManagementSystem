let inputFile = document.getElementById("formFileMultiple");


inputFile.addEventListener('change',(data)=>{
    var formdata = new FormData();
    file = data.target.files[0];
    formdata.append('file',file);
    formdata.append('filename',file.name);
    formdata.append('id',inputFile.dataset.isAuthenticated);
    
    uploadPayment(formdata);
})


async function uploadPayment(formData){
    
    var res = await fetch('/students/api/uploadPayment',{
        credentials: 'same-origin',
        
        method:"POST",
        body:formData,
        
    })
    window.location.reload()
}