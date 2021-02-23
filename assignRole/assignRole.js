$(document).ready(function(){
    $("#submit").click(function(){ // Når knappen i scriptet "CreateAccount.php" kører og knappen med id="submit" klikkes.

        // Henter input fra php-script "AssignRoles.php"
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();
        let newRole = $("#select-new-role").val();

        // Jeg sender data videre til scriptet der opdaterer rollen, hvor ajax så giver mig et respons.
        $.ajax({
            url: './assignRole/assignNewRole.php', // Script der opdaterer rollen
            type: 'post', // metode som data sendes.
            data: {
                username: username,
                password: password,
                newRole: newRole
            },
            // Funktion der kører efter respons kommer fra php-scriptet.
            success: function(response) {
                json = JSON.parse(response);
                switch(json.result){
                    case 0:     
                        // Hvis rollen ændres korrekt, så ledes man videre til Home-Page.php.
                        window.location = "./Home-Page.php";
                        alert("succesfully changed role");
                        break;
                    case 1:
                        // Det givne password var ikke korrekt.
                        alert("password was incorrect");
                        break;
                    case 2:
                        // Brugeren findes ikke.
                        alert("username was incorrect");
                        break;
                    case 3:
                        // Fejl i php-script.
                        alert("fejl i hjemmeside");
                        break;
                }
            }
        });
    });
})