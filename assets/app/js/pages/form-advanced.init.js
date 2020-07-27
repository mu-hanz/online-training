
var base_url = window.location.origin;
var select = $('[data-plugin="customselect"]');
var selectone = $('[data-plugin="customselectone"]');
selectone.select2()
select.select2()

select.on('select2:select', function (e) {

    var title = select.select2().find(":selected").data("title");
    var thumbs = select.select2().find(":selected").data("thumbs");
    var cover = select.select2().find(":selected").data("cover");

    if(cover){
        $('#post_cover').val(cover);
        $('#cover').attr('src', cover);
        $('#overlay-cover').addClass('box-overlay');
    }

    if(thumbs){
        $('#post_thumbs').val(thumbs);
        $('#thumbs').attr('src', thumbs);
        $('#overlay-thumbs').addClass('box-overlay');
    }
    
    $('#title').val(title);

    
    
});


var selectType = $('[data-plugin="customselectType"]');
selectType.select2()
selectType.on('select2:select', function (e) {
    var type = selectType.select2().find(":selected").data("training");
    var slug = selectType.select2().find(":selected").data("slug");
    $('#event_type').val(slug);
    if(type == 'Virtual Training'){
        $('.urlStreaming').slideDown();
        $('.meeting').prop('required', true);
    } else {
        $('.urlStreaming').slideUp();
        $('.meeting').prop('required', false);
    }
});

var selectGroup = $('[data-plugin="customselectGroup"]');
selectGroup.select2()
selectGroup.on('select2:select', function (e) {
    var group = selectGroup.select2().find(":selected").data("group");
    $('#event_group').val(group);
});

var selectRegional = $('[data-plugin="customselectRegional"]');
selectRegional.select2()
selectRegional.on('select2:select', function (e) {
    var regional = selectRegional.select2().find(":selected").data("regional");
    $('#event_regional').val(regional);
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

$('#reg_enable').click(function(){
    if($(this).is(':checked')){
        $('#reg_enable_text').text('Enabled Register');
        $('#reg_enable_text').removeClass('text-muted');
        $(this).val('0')
    } else {
        $('#reg_enable_text').text('Disabled Register');
        $('#reg_enable_text').addClass('text-muted');
        $(this).val('1')
    }
});


$("#createnew").click(function() {
    $("#form").prepend('<input type="hidden" name="createnew" value="createnew">');
});