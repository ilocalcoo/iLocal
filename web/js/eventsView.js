$(document).ready(function () {
    $('.event-view').click(function (event) {
        event.preventDefault();
        let model = $('#event-modal');
        let id = event.target.id;
        model.modal('show');
        $.ajax({
            url: `/events/${id}`,
            type: "GET",
            success: function (data) {
                $('.modal-body').html($(data).find('#event-view-content').html());
            }
        });
    });
});

$(document).on('click', '#del-event', function (e) {
    $.pjax.reload({container: '#event-list'});
});
$(document).on('click', '#del-shop', function (e) {
    $.pjax.reload({container: '#shop-list'});
});