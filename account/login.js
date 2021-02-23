$(document).ready(function(){
    $("#submit").click(function(){ // Når knappen i scriptet "CreateAccount.php" kører og knappen med id="submit" klikkes.
        
        // Henter input fra php-scriptet "Login.php".
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();

        // Jeg sender data videre til scriptet der verificerer login-credentials, hvor ajax så giver mig et respons.
        $.ajax({
            url: './account/verifyCredentials.php', // Script der logger ind
            type: 'post', // Metode data bliver sendt til php
            data: {
                username: username,
                password: password
            },
            // Funktion der kører efter php-scriptet har givet et respons
            success: function(response) {

                json = JSON.parse(response); 
                switch(json.result){
                    // Hvis respons er "0", så logger man ind.
                    case 0:     
                        window.location = "./Home-Page.php";
                        break;
                    // Hvis respons er "1", så er credentials forkerte.
                    case 1:
                        $("#msg").html("username or password was incorrect.");
                        break;
                    // Hvis respons er "2", så er der en fejl i hjemmesiden.
                    case 2:
                        $("#msg").html("website-error.");
                        break;
                }
            }
        });
    });
})