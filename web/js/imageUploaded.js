$(document).ready(function() {
    const shopFormId = '#shop-uploadedshopphoto';
    const eventFormId = '#event-uploadedeventphoto';

    $(shopFormId).change(function () {
        $(shopFormId).submit();
    });
    $(eventFormId).change(function () {
        $(eventFormId).submit();
    });
});