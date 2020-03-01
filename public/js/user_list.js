$(()=>{
    let input, filter, teams;
    input = $("#search").val();
    teams = $(".filter-active");

});

let filter = function(){
    let input, filter, teams;
    input = $("#search").val().toUpperCase();
    teams = $(".badge-filter-active").text().toString().toUpperCase();

    let users = $("tr");
    for (i=1; i<2;i++){
        let name = $(users[i].getElementsByTagName('a')[0]).text();
        var myTeams = [].slice.call($(users[i].getElementsByClassName('badge')));
        function myFunc(i){
            var myRec= /(?<=>)(.*)(?=<)/;
            return myRec.exec(i)[0];
        };
        console.log(myTeams.map(myFunc))
        //console.log(myTeams.toUpperCase().indexOf(teams.toUpperCase()));
        console.log();
        if(name.toUpperCase().indexOf(input)>-1&&
            myTeams.indexOf(teams)>-1){
            $(users[i]).addClass('d-block');
            $(users[i]).removeClass('d-none');
        }
        else{
            $(users[i]).removeClass('d-block');
            $(users[i]).addClass('d-none');
        }
    }
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