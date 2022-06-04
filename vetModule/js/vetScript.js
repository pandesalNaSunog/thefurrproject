$(document).ready(function(){
    var email = $('#email');
    var password = $('#password');
    var login = $('#log-in');

    login.on('click', function(){
        if(email.val() != "" && password.val() != ""){
            $.ajax({
                type: 'POST',
                url: '../vetModule/php/vetLogin.php',
                data: {
                    email: email.val(),
                    password: password.val()
                },
                success: function(response){
                    console.log(response);
                    window.location.replace(response);
                }
            })
        }
    })
})