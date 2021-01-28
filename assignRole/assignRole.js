$(document).ready(function(){
    $("#submit").click(function(){
        let username = $("#username").val().trim();
        let password = $("#password").val().trim();
        let newRole = $("#select-new-role").val();
        $.ajax({
            url: './assignRole/assignNewRole.php',
            type: 'post',
            data: {
                username: username,
                password: password,
                newRole: newRole
            },
            success: function(response) {
                json = JSON.parse(response);
                switch(json.result){
                    case 0:     
                        window.location = "./Home-Page.php";
                        alert("succesfully changed role");
                        break;
                    case 1:
                        alert("password was incorrect");
                        break;
                    case 2:
                        alert("username was incorrect");
                        break;
                    case 3:
                        alert("The assigned role was already set");
                        break;
                    case 4:
                        alert("fejl i hjemmeside");
                        break;
                }
            }
        });
    });
})