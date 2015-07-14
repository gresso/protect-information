$(function(){

    //Форма авторизации
    $('#LoginForm #SendLoginForm').on('click', function(){
        $.ajax({
            type: "POST",
            url: "api_login",
            data: $('#LoginForm').serialize(),
            dataType:'json',
            success: function(data){
                console.log(data);
                LoginObr(data);
            }
        });
    })

    function LoginObr(model){
        var count_errors = Object.keys(model._errors).length;

        if(count_errors!=0){
            $('#VerifCode').css('display','none');
            alert ('Обработка ошибок');
        }

        else  {
            //показываем форму ввода верификационного кода
            $('#VerifCode [name="email"]').val(model.email);
            $('#VerifCode [name="passw"]').val(model.passw);
            $('#VerifCode').css('display','');
        }
    }


    //Форма регистрации
    $('#regform #senddata').on('click', function(){

        $.ajax({
            type: "POST",
            url: "api_registration",
            data: $('#regform').serialize(),
            dataType:'json',
            success: function(data){
                regObrab(data);
            }
        });
    })


    function regObrab(model){

        var count_errors = Object.keys(model._errors).length;

        //Если пользователь зарегитрировар
        if (model.u_reg === true && count_errors == 0 ) {
            alert('Пользователь удачно зарегистрирован!');
        }

        //Если есть ошибки при регистрации
        if (model.u_reg === false && count_errors > 0){
            alert ('Есть ошибки которые нужно обработать');
        }

    }

})