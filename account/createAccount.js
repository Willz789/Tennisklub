$(document).ready(function(){
    $("#submit").click(function(){ // Når knappen i scriptet "CreateAccount.php" kører og knappen med id="submit" klikkes.
        
        /* Henter alle input fra php-script */
        let password = $("#password").val().trim();
        let confirm_password = $("#confirm_password").val().trim();
        let username = $("#username").val().trim();
        let phonenumber = $("#phonenumber").val().trim();
        let mail = $("#mail").val().trim();
        let birthDay = $("#birthDay").val();
        let birthMonth = $("#birthMonth").val();
        let birthYear = $("#birthYear").val();
        let name = $("#name").val().trim();

        // Tjekker at password er lig med confirm-password fra input.
        if(password != confirm_password){
            $("#msg").html("passwords must match."); // Fejlbesked til bruger
        } else if (username.length >= 4 && password.length >= 4 && birthDay>0 && birthMonth>0){ // Krav til credentials.
            
            // Tilføjer "0" foran dag og måned, hvis de kun indeholder ét ciffer.
            let extra0Day = "";
            let extra0Month = "";
            if(birthDay.length == 1){
                extra0Day = "0";
            }
            if(birthMonth.length == 1){
                extra0Month = "0";
            }
            // Sætter hele fødselsdatoen sammen
            let birthDate = extra0Day + birthDay.toString() + "/" + extra0Month + birthMonth.toString() + "/" + birthYear.toString();
            
            // Jeg bruge ajax til at sende data videre til php-script, som behandler det i forhold til databasen
            $.ajax({
                url: './account/signup.php', // php-script der behandler databasen
                type: 'post', // Metode til at sende data til php-script
                data: {
                    username: username,
                    password: password,
                    name: name,
                    phonenumber: phonenumber,
                    mail: mail,
                    birthday: birthDate
                },
                success: function(response) { // Kører følgende funktion efter php-script er kørt, og tager respons fra php-script
                    json = JSON.parse(response);

                    switch(json.result){
                        case 0:
                            // Hvis repons er 0 (det virkede), så logger den inde for dig.
                            $.ajax({
                                url: './account/verifyCredentials.php', // php-script der logger ind
                                type: 'post',
                                data: {
                                    username: username,
                                    password: password
                                },
                                success: function(response) {
                                    json = JSON.parse(response);
                
                                    switch(json.result){
                                        case 0:
                                            // Når du er logget ind, så går du videre til Home-Page.php
                                            window.location = "./Home-Page.php";
                                            break;
                                        case 1:
                                            // Hvis den ikke kunne logge ind, så giver den en fejlbesked.
                                            alert("website-error");
                                            window.location = "./Home-Page.php";
                                            break;
                                        case 2:
                                            // Hvis den ikke kunne logge ind, så giver den en fejlbesked.
                                            alert("website-error");
                                            window.location = "./Home-Page.php";
                                            break;
                                    }
                                }
                            })
                            break;
                        case 1:
                            // Username var taget.
                            $("#msg").html("Username is already taken."); // Fejlbesked til bruger.
                            break;
                        case 2:
                            // mail var taget.
                            $("#msg").html("Mailaddress is already in use.");// Fejlbesked til bruger.
                            break;
                        case 3:
                            // Fejl i hjemmeside.
                            $("#msg").html("website-error.");// Fejlbesked til bruger.
                            break;
                    }
                }
            })
        } else {
            $("#msg").html("wrong credentials.");
        }
    });
})