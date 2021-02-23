$(document).ready(function(){
    $("#book-court").click(function(){ // Når knappen i scriptet "CreateAccount.php" kører og knappen med id="submit" klikkes.
        
        // Henter input fra php-scriptet "CourtInformation.php".
        let courtId = $("#court-id").val().trim();
        let userId = $("#user-id").val().trim();

        // Data sendes videre til scriptet der booker en bane, hvor ajax så giver et respons.
        $.ajax({
            url: './booking/bookCourt.php', // Script der booker en bane.
            type: 'post', // Metode som data sendes til php-script.
            data: {
                courtId: courtId,
                userId: userId
            },
            // Funktion der kører efter php-script og tager respons derfra.
            success: function(response) {
                json = JSON.parse(response);
                switch(json.result){
                    case 0:     
                        // Hvis respons er "0" så blev banen booket.
                        window.location = "./Booking.php";
                        break;
                    case 1:
                        // Banen var allerede booket på tidspunktet.
                        $("#msg").html("Court is already booked.");
                        break;
                    case 2:
                        // Fejl i hjemmesiden
                        $("#msg").html("website-error.");
                        break;
                    case 3:
                        // Medmindre man er træner eller admin, så kan man kun have fire baner booket i løbet af en uge på en gang.
                        $("#msg").html("You cant book more than four courts.");
                        break;
                }
            }
        });
    });
})