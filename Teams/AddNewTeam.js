$(document).ready(function(){
    $("#submit").click(function(){ // Når knappen i scriptet "CreateTeam.php" kører og knappen med id="submit" klikkes.
        
        // Henter input fra php-script
        let name = $("#name").val().trim();
        let minBirthYear = $("#minBirthYear").val();
        
        if(minBirthYear.toString().length == 4){ // Fødselsåret skal være 4-cifret.
            
            // Sender data til php-script som bearbejder data i forhold til database, og giver respons tilbage.
            $.ajax({
                url: './Teams/AddNewTeam.php', // php-script der bearbejder databasen.
                type: 'post', // Metoden som data sendes til php.
                data: {
                    name: name,
                    minBirthYear: minBirthYear
                },
                // Funktion der kører efter php-script og bruger respons derfra.
                success: function(response) {

                    json = JSON.parse(response);
                    switch(json.result){
                        case 0:
                            // Hvis respons er "0", så blev holdet oprettet og man ledes videre på hjemmesiden.     
                            window.location = "./Training.php";
                            break;
                        case 1:
                            // Holdnavnet var allerede taget.
                            $("#msg").html("Team-name already taken.");
                            break;
                        case 2:
                            // Fejl i hjemmesiden.
                            $("#msg").html("website-error.");
                            break;
                    }
                }
            });
        }
    });
})