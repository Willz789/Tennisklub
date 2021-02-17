$(document).ready(function(){
    $("#submit").click(function(){
        let password = $("#password").val().trim();
        let confirm_password = $("#confirm_password").val().trim();
        let username = $("#username").val().trim();
        let phonenumber = $("#phonenumber").val().trim();
        let mail = $("#mail").val().trim();
        let birthDay = $("#birthDay").val();
        let birthMonth = $("#birthMonth").val();
        let birthYear = $("#birthYear").val();
        let name = $("#name").val().trim();
        if(password != confirm_password){
            $("#msg").html("passwords must match.");
        } else if (username.length >= 4 && password.length >= 4 && birthDay>0 && birthMonth>0){
            
            let extra0Day = "";
            let extra0Month = "";
            if(birthDay.length == 1){
                extra0Day = "0";
            }
            if(birthMonth.length == 1){
                extra0Month = "0";
            }
            let birthDate = extra0Day + birthDay.toString() + "/" + extra0Month + birthMonth.toString() + "/" + birthYear.toString();
            $.ajax({
                url: './account/signup.php',
                type: 'post',
                data: {
                    username: username,
                    password: password,
                    name: name,
                    phonenumber: phonenumber,
                    mail: mail,
                    birthday: birthDate
                },
                success: function(response) {
                    json = JSON.parse(response);

                    switch(json.result){
                        case 0:
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
                                            alert("website-error");
                                            window.location = "./Home-Page.php";
                                            break;
                                        case 2:
                                            alert("website-error");
                                            window.location = "./Home-Page.php";
                                            break;
                                    }
                                }
                            })
                            break;
                        case 1:
                            $("#msg").html("Username is already taken.");
                            break;
                        case 2:
                            $("#msg").html("Mailaddress is already in use.");
                            break;
                        case 3:
                            $("#msg").html("website-error.");
                            break;
                    }
                }
            })
        } else {
            $("#msg").html("wrong credentials.");
        }
    });
})