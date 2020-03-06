//Apply filters on users
let filter = function(){
    let searchQuery = $("#search").val().toUpperCase();
    let selectedTeams = $(".badge-filter-active");
    selectedTeams = selectedTeams.map(x=>selectedTeams[x].innerText).toArray()
    let users = $('.user-row').toArray();

    users.forEach((u)=>{
        let userName = $(u).children().children('a').text().toUpperCase();
        let userTeams = $(u).children().children('.badge');
        let teamCrit = false;
        let nameCrit = false;
        userTeams = userTeams.map(x=>userTeams[x].innerText).toArray()
        if(selectedTeams.length>0){
            selectedTeams.forEach((st)=>{   //check team selector
                if(userTeams.includes(st))
                    teamCrit=true;
            })
        }
        else{
            teamCrit=true;
        }


        if(userName.indexOf(searchQuery)>-1)
            nameCrit=true;

        if(nameCrit && teamCrit){
            $(u).addClass('d-block');
            $(u).removeClass('d-none');
        }
        else{
            $(u).addClass('d-none');
            $(u).removeClass('d-block');
        }
    })
}

$(".badge-filter").click((e)=>{
    let el= e.target;
    $(el).toggleClass('badge-filter-active');
    $(el).toggleClass('p-2');
    filter();
});

$('#search').keyup((e)=>{
   filter()
});

$('.point-change').click((e)=>{
    e.preventDefault();
    let el = e.target;
    if(!$(el).attr('href'))
        el = $(el).parent('a')[0];
    let points = $(el).siblings('input').val();
    if(!$(el).hasClass('btn-success'))
        points= points*(-1);
    $.ajax({
        url: $(el).attr('href'),
        type: "POST",
        data:{
            'points':points
        },
        dataType:'json',
        success: (r)=>{
            console.log($(el).parents('tr').find('.karma'));
            $(el).parents('tr').find('.karma')[0].innerText = r['points'];
        },
        error:(e)=>{
            console.log(e);
        }
    })
})

$(".team-points").click((e)=>{
    e.preventDefault();
    let el = e.target;
    if(!$(el).attr('href'))
        el = $(el).parent('a')[0];
    let points = $(el).siblings('input').val();
    if(!$(el).hasClass('btn-success'))
        points= points*(-1);
    let teams = $('.badge-filter-active');
    teams = teams.map(x=>$(teams[x]).attr('id')).toArray();
    teams.forEach((t)=>{
        $.ajax({
            url: $(el).attr('href').replace('99',t),
            type: "POST",
            data:{
                'points':points
            },
            dataType:'json',
            success: (r)=>{
                console.log(r)
            },
            error:(e)=>{
                console.log(e);
            }
        })
    })
    location.reload()
})

$(".addTeam").click((e)=>{
    e.preventDefault()
    let a = $(e.target);
    if(!a.attr('href'))
        a = $(a.parent('a'));
    const modal = $('#addTeamModal').modal('show')
    modal.append(`<span id="a${a.attr('id')}" class="userId"></span>`);
})

$('.newBadget').click((e)=>{
    const badget =$(e.target)
    if(badget.parent().attr('id')=="selectedBadges")
        $('#badgeSelection').append(badget);
    else
        $('#selectedBadges').append(badget);
})

$('#addTeamModalSave').click((e)=>{
    e.preventDefault();
    let badges = $('#selectedBadges').find('.badge').toArray().map(x=>x.innerText);
    const userId= $("#addTeamModal").find('.userId').attr('id').substring(1);
    $.ajax({
        url: $('#'+userId).attr('href'),
        type: "post",
        dataType:"json",
        data: JSON.stringify(badges),
        success:(r)=>{
            console.log(r)
            location.reload();
        },
        error:(e)=>{
            console.log(e)
        }
    })
})