$('.remove').click((e)=>{
    e.preventDefault();
    let el= $(e.target);
    $.ajax({
        url: el.attr('href'),
        type:"delete",
        date:"",
        success: (r)=>{
            console.log(r)
            el.parents('.col-3').fadeOut()
        },
        error: (e)=>{
            console.log(e)
        }
    })
})