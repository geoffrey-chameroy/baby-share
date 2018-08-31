$(document).on('click', '[data-toggle="lightbox"]', function (event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

$('.js-datepicker').flatpickr({
    enableTime: false,
    nextArrow: '<i class="fa fa-long-arrow-right" />',
    prevArrow: '<i class="fa fa-long-arrow-left" />',
    altFormat: 'd.m.Y',
    altInput: true,
});
