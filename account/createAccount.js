$(document).ready(function(){
    $("submit").click(function(){
        let password = $("password").val().trim();
        let confirm_password = $("confirm_password").val().trim();
        if(if(password === confirm_password)){
            let username = $("username").val().trim();
        }
    });
})