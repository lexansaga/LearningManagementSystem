async function removeModule(filename,id){
    let formdata = new FormData();
    formdata.append("id",id);
    formdata.append("filename",filename);
    var res = await fetch('/students/api/removeModule',{
        credentials: 'same-origin',
        
        method:"POST",
        body:formdata,
        
    })
    window.location.reload()
}