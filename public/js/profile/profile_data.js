$("#save").click((e)=>{
    e.preventDefault();
    const form = $("#userData").serializeArray()
    let data = new Array();
    form.forEach((x)=>{
        data[x.name] = x.value;
    });
    console.log(data);
    if(data.password.localeCompare(data.passwordAgain)!=0){
        $('[type="password"]').addClass('border border-danger');
    }
    else{
        $.ajax({
            url: $("#userData").attr('action'),
            dataType: 'json',
            type: "put",
            data:{
                'name':data.name,
                'surname':data.surname,
                'bio': data.bio,
                'password': data.password
            },
            success:(r)=>{
                console.log("OK");
                console.log(r);
                location.reload();
            },
            error: (e)=>{
                console.log("error");
                console.log(e);
            }
        });
    }
})