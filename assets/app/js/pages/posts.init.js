$(".datepicker").flatpickr({
    enableTime: false,
    dateFormat: "Y-m-d"
})

$(".time24").flatpickr({
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true
})



$(document).on('click', '#scheduler', function(e) {
    if($(this).is(':checked')){
        $('.input_scheduler').prop('disabled', false);
    } else {
        $('.input_scheduler').prop('disabled', true);
        $('.input_scheduler').val('');
    }
});

$(document).on('click', '#draft', function() {
    $("#form").prepend('<input type="hidden" name="draft" value="draft">');
});