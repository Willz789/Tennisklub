$(document).ready(function(){
    $("#submit").click(function(){
        
        let name = $("#name").val().trim();
        let minBirthYear = $("#minBirthYear").val();
        
        if(minBirthYear.toString().length == 4){
            
            $.ajax({
                url: './Teams/AddNewTeam.php',
                type: 'post',
                data: {
                    name: name,
                    minBirthYear: minBirthYear
                },
                success: function(response) {

                    json = JSON.parse(response);
                    switch(json.result){
                        case 0:     
                            window.location = "./Training.php";
                            break;
                        case 1:
                            $("#msg").html("Team-name already taken.");
                            break;
                        case 2:
                            $("#msg").html("website-error.");
                            break;
                    }
                }
            });
        }
    });
})