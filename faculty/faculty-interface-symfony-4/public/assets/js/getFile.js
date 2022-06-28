async function getFile(filename,filepath,userid){
    
    var res = await fetch(`/student/getFile?name=${filename}&path=${filepath}&id=${userid}`,{
        credentials: 'same-origin',
        headers:{
            'Content-type':'application/json'
        },
        method:"GET",
        
        
    })

    var a = document.createElement('a');
    a.href = res.url;
    a.target="_blank"
    a.click();
}