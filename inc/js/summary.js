$(document).ready(function () {

    // variables
    var smstime;
    var entry;
    var host = "arrenberg.studio";
    var directory = "statistics";
    var hash = window.location.hash.replace('#', '');



    // screen size
    var width = $(window).width();
    var height = $(window).height();


    //    //tracking
    //    $.ajax({
    //        url: "ajax.php",
    //        type: "POST",
    //        data: {
    //            action: 'track',
    //            width: width,
    //            height: height,
    //            site: '2'
    //        },
    //        success: function (data) {},
    //        error: function (data) {}
    //    });


    //get current date
    var daynum = moment().format('D');
    var day = moment().format('dddd');
    var month = moment().format('MMMM');
    var date = moment().format('D. of MMMM');
    var smstime = moment().format('YYYY-MM-DD');


    //    one month (30 days)
    //    var end = moment().format('YYYY-MM-DD');
    //    var start = moment().subtract(1, 'months').format('YYYY-MM-DD');
    //
    //    var prevstart = moment().subtract(2, 'months').format('YYYY-MM-DD');
    //    var prevend = moment().subtract(1, 'months').format('YYYY-MM-DD');

    //    current and last month
    var end = moment().add(1, 'days').format('YYYY-MM-DD');
    var start = moment().format('YYYY-MM-01');
    //    alert(end);
    //    alert(start);

    var prevstart = moment().subtract(1, 'months').format('YYYY-MM-01');
    //    end of month function?
    var prevend = moment().subtract(1, 'months').format('YYYY-MM-31');


    $.ajax({
        url: "ajax.php",
        type: "POST",
        data: {
            action: 'summary',
            start: start,
            end: end,
            prevstart: prevstart,
            prevend: prevend
        },
        success: function (data) {
            if (data == 'notlogged') {
                relogin();
                return false;
            }
            $('div#summary').html(data);
            //            alert(data);
        },
        error: function (data) {
            alert("sorry, couldn't load day timeline");
        }
    });




});
