function selectStation(item, type) {
    if(type == 1) {
        $('#findform-from_station').val(item.id);
    } else if(type == 2) {
        $('#findform-to_station').val(item.id);
    }
    return false;
}

$(document).ready(function() {
   $('.trainListBtn').click(function(event) {
       event.preventDefault();

       var train_id = $(this).attr('data-train-id');
       var date = $('.pageData').data('date');
       var from_station = $('.pageData').data('from-station');
       var to_station = $('.pageData').data('to-station');

       $('.list-group-item.active').removeClass('active');
       $(this).addClass('active');

       $.ajax({
           type: 'GET',
           url: '/site/prepare/',
           data: { date: date, from_station:from_station, to_station:to_station, train_id:train_id },
           success: function(res){
               $('.ajax_container').html(res);
           }
       });
   });
});