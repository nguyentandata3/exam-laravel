function startTimer(duration, display) {
    var timer = duration, hours, minutes, seconds;
    setInterval(function () {
        hours = parseInt(timer / 3600, 10)
        minutes = parseInt((timer - hours * 3600) / 60, 10)
        seconds = parseInt((timer - (hours * 3600 + minutes * 60 )) % 3600, 10);

        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.text(hours + ":" + minutes + ":" + seconds);
        $("input[name='time']").val(hours + ":" + minutes + ":" + seconds);
        if (--timer < 0) {
            timer = duration;
            $(document).ready(function () {
                $.get("http://localhost:8000/users/delete-session", function(data, status){
                    window.location.href = 'http://localhost:8000/';
                });
            });
        }
    }, 1000);
}

jQuery(function ($) {
    if($('#time_test').val()) {
    var time = $('#time_test').val();  
    // alert(123);
    var fiftyfiveMinutes = time,
    display = $('#time');
    startTimer(fiftyfiveMinutes, display);
    }
});

$(document).ready(function () {
    $('#example').DataTable();

    $('input[type=radio][class=answer]').change(function() {
        var id = $(this).data("idquestion");
        $(".checked_question" + id).css("background","yellow");
    });

});


