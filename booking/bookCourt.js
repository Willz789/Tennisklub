$(document).ready(function(){
    $("#book-court").click(function(){
        let courtId = $("#court-id").val().trim();
        let userId = $("#user-id").val().trim();

        $.ajax({
            url: './booking/bookCourt.php',
            type: 'post',
            data: {
                courtId: courtId,
                userId: userId
            },
            success: function(response) {
                json = JSON.parse(response);
                switch(json.result){
                    case 0:     
                        window.location = "./Booking.php";
                        break;
                    case 1:
                        $("#msg").html("Court is already booked.");
                        break;
                    case 2:
                        $("#msg").html("website-error.");
                        break;
                    case 3:
                        $("#msg").html("You cant book more than four courts.");
                        break;
                }
            }
        });
    });
})