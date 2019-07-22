$(document).ready(function () {
    $('.contact-form').click(function (event) {
        event.preventDefault();
        $.ajax({
            url: '/site/contact',
            type: "GET",
            success: function (data) {
                $('#contact-form').html($(data).find('#contact-form-content').html());
            }
        });
    });


    $(document).on("submit", '.contact-form', function (event) {
        event.preventDefault();
        let form = $(this);
        $.ajax({
            url: "/site/contactsend",
            type: "POST",
            data: form.serialize(),
            success: function (result) {

                if (result === 'true') {
                    $('.contact-form_btn').addClass('contact-disabled');
                        $('#massage').text('Поздравляем! Ваше сообщение успешно отправлено.');
                        setTimeout(function() {
                            $(".modal").modal('hide');
                        }, 3000);
                } else {
                    $('#massage-error').text('Упс, что-то пошло не так. Внимательно проверьте правильность заполнения полей.');
                }
            }
        });
    });
});