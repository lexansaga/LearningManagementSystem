

async function removePayment(filename,id){
    let formdata = new FormData();
    formdata.append("id",id);
    formdata.append("filename",filename);
    var res = await fetch('/students/api/removePayment',{
        credentials: 'same-origin',
        
        method:"POST",
        body:formdata,
        
    })
    window.location.reload()
}

