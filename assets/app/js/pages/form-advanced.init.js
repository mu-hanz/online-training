
var base_url = window.location.origin;
var select = $('[data-plugin="customselect"]');

select.select2()

select.on('select2:select', function (e) {

    var title = select.select2().find(":selected").data("title");
    var thumbs = select.select2().find(":selected").data("thumbs");
    var cover = select.select2().find(":selected").data("cover");

    $('#post_thumbs').val(thumbs);
    $('#thumbs').attr('src', '/media/'+thumbs);
    $('#post_cover').val(cover);
    $('#cover').attr('src', '/media/'+ cover);
    $('#title').val(title);

    $('#overlay-cover').addClass('box-overlay');
    $('#overlay-thumbs').addClass('box-overlay');
});



var selectRegional = $('[data-plugin="customselectRegional"]');
selectRegional.select2()
selectRegional.on('select2:select', function (e) {
    var regional = selectRegional.select2().find(":selected").data("regional");
    $('#regional').val(regional);
});


var selectGroup = $('[data-plugin="customselectGroup"]');
selectGroup.select2()
selectGroup.on('select2:select', function (e) {
    var group = selectGroup.select2().find(":selected").data("group");
    $('#group').val(group);
});



var selectType = $('[data-plugin="customselectType"]');
selectType.select2()
selectType.on('select2:select', function (e) {
    var type = selectType.select2().find(":selected").data("training");
    $('#type').val(type);
    if(type == 'Virtual Training'){
        $('.urlStreaming').slideDown();
    } else {
        $('.urlStreaming').slideUp();
    }
});

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

$("#createnew").click(function() {
    $("#form").prepend('<input type="hidden" name="createnew" value="createnew">');
});