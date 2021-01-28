$(document).ready(function(){
    $("#submit").click(function(){
        let titel = $("#titel").val().trim();
        if(titel.length > 0){
            let tekst = $("#tekst").val().trim();
            if(typeof tekst != "undefined"){
                alert(typeof tekst);
            } else {
                alert("HI");
            }
        }
    });
})