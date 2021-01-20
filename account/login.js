$(document).ready(function(){
    $("#submit").click(function(){
        
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();

        if(username.length >= 4 && password.length >= 4){

            $.ajax({
                url: './account/verifyCredentials.php',
                type: 'post',
                data: {
                    username: username,
                    password: password
                },
                success: function(response) {
                    json = JSON.parse(response);
                    switch(json.result){
                        case 0:     
                            window.location = "./Home-Page.php";
                            break;
                        case 1:
                            alert("username or password was incorrect");
                            break;
                        case 2:
                            alert("Fejl i hjemmesiden");
                            break;
                    }
                }
            });
        }
    });
})