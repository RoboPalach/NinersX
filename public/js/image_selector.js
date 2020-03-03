let selectInsert = function(e){
    const button = $(e);
    const imageUrl = button.parent().children('img').attr('src');
    const formatedText = `![](${imageUrl})`;
    const pos = simplemde.codemirror.getCursor();
    simplemde.codemirror.setSelection(pos, pos);
    simplemde.codemirror.replaceSelection(formatedText);
    $('#imageSelectorModal').modal('hide')
}

$('#imageSelectorModal').on('show.bs.modal', function (e) {
    const modal = $(e.target);;
    $.ajax({
        url: modal.attr('href'),
        typ:"get",
        date:"",
        success: (r)=>{
            $('.image_list .row').empty();
            r.forEach((e)=>{
                $('.image_list .row').append(`<div class="col-4 pr-1 image_item">
                    <img class="img img-fluid img-thumbnail" src="${e.url}" author="${e.owner.name}" slug="${e.owner.slug}">
                    </div>`)
            });

            $(".img-thumbnail").click((e)=>{
                const image = $(e.target);
                const preview = $('.image_preview');

                $(".selected").removeClass('selected');
                image.addClass('selected');

                preview.empty();
                preview.append(`
                    <img class="img img-fluid" src="${image.attr('src')}">
                    <a href="/profile/${image.attr('slug')}">${image.attr('author')}</a>
                    <button class="btn btn-primary mt-4" onclick="selectInsert(this)">Vybrat</button>
                `);
            });
        },
        error:(e)=>{
            console.log(e)
        }
    })
});

