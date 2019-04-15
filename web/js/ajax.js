     $("#login-form-ajax").on('submit', function(event){
            event.preventDefault();
            let result = {};
            $.each($(this).serializeArray(), function() {
                result[this.name] = this.value;
            });
            $.ajax({
                url: '',
                type: 'post',
                format: 'json',
                data: {Login:result},
                success: function(response){
                    $('.errors').html('');
                    $('.errors').css('opacity','0');

                    if(Object.keys(response).length) {
                        for (var prop in response) {
                     $('.errors').append('<p>'+response[prop][0]+'</p>');
                    $(".errors").animate(
                      {
                        opacity: 1,
                      },
                    1000);
                        }
                    } else 
                    {
                        $('.success').append('<p>Успешная авторизация!</p>');
                        setTimeout(function(){
                         window.location.href = "";
                        }, 2000);
                    }
                },
            });
        });