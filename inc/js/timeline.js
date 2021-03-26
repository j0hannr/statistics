$(document).ready(function () {

    // tests:
    var width = $(window).width();
    var height = $(window).height();
    
    //tracking
    $.ajax({
    url:"ajax.php",
    type:"POST",
    data: {action: 'track', width: width, height: height, site: '8'},
    success: function(data){ },
    error: function(data) { }
    });

    var height_timeline = $('div#timeline').height();


    // layer count define
    var layercount = 12; // inital = 9
    // layerheight define
    // var layerheight = 50; // inital = 70
    var layerheight = height_timeline / layercount; // inital = 70
    // alert(layerheight);

    // day length define
    var daylength = 23; // inital 24
    var daylengthborder = 1; // border
    // timeline length < day length * 365
    var timelinelength = (daylength + daylengthborder) * (365); // Problem Dez. 31 not included!
    // timeline height < layerheight * layer count
    var timelineheight = layerheight * layercount;
    // define year
    var year = (new Date).getFullYear();
//    var year = 2020;
    
//    alert(year);

    // alert(layerheight);

    // set time line lines .dateline < timeline height
    // $('.dateline').height(timelineheight+ 16);
    $('.dateline').width(daylength);
    $('.dateline').css("padding-top", height_timeline - layerheight);
    // set time line height < timeline height
    // $('#timeline').height(timelineheight);
    $('#timeline').width(timelinelength + 5);
    $('.timeline').height(layerheight);
    $('.milestone').height(layerheight);
    // // set dateline width < day length

    // // set div.horizontal width < timeline length
    $('.horizontal').width(timelinelength);
    $('.horizontal').height(layerheight);

    // // #today height < timeline height
    $('div.today div#todayline').height(timelineheight);

    $('div.day').width(daylength + daylengthborder);
    $('div.day').height(layerheight);
    // $('div.day').top( - layerheight - 30);
    $('div.day').css("top", -layerheight - 35 + "px");

    $('p.start, p.width, p.end').css("top", layerheight);





    // alert(timelineheight);
    // alert(timelinelength);
    // $('#timeline').width(8760);


    // scroll to today ...


    // init Draggable and Resizable Timeline events
    
    $(".timeline").resizable({
        // grid: [(daylength + daylengthborder), 10],
        grid: [((daylength + daylengthborder) / 2), 10],
        maxHeight: layerheight, // - 10 because its expanding on resize, bug has to be fixed
        minHeight: layerheight, // - 10 because its expanding on resize, bug has to be fixed
        snap: ".snap",
        minWidth: (daylength + daylengthborder)
        // ghost: true
    });

    $(".timeline").draggable({
        snap: ".snap",
        grid: [1, (layerheight)],
        distance: 10
        // grid: [1, (layerheight / 2)] // 2nd = half layer height
        // snapMode: ".dateline",
        // snapTolerance: 30
    });

    $(".milestone").draggable({
        snap: ".snap",
        grid: [1, (layerheight)],
        distance: 10
        // grid: [1, (layerheight / 2)] // 2nd = half layer height
        // snapMode: ".dateline",
        // snapTolerance: 30
    });

    // init Draggable and Resizable Timeline events
    // $(".timeline").resizable({
    //     grid: [24, 10],
    //     maxHeight: 70,
    //     minHeight: 70,
    //     snap: ".snap",
    //     minWidth: 23
    // });
    //
    // $(".timeline").draggable({
    //     snap: ".snap",
    //     grid: [1, (35)] // 2nd = half layer height
    //     // snapMode: ".dateline",
    //     // snapTolerance: 30
    // });

    //
    //     setTimeout(function(){
    // alert("Boom!");
    //
    // $(this).hide().delay(i * 350).fadeIn(1500);
    // }, 2000);

//    orient timeline events on grid
    setTimeout(function () {

        $('.timeline.draggable').hide();

        $('.timeline.draggable').each(function (i) {

            var thislayer = $(this).find('p.layer').text();
            // alert(thislayer);
            $(this).css('top', (layerheight + 1) * (thislayer - 1));
            // 'i' stands for index of each element
            $(this).hide().delay(i * 50).fadeIn(500);
        });

        // scroll to today!
        var scroll = $('div.dateline.today.snap').position().left - width / 2;

        $('html, body').animate({
            scrollLeft: scroll
        }, 800);


    }, 1000);
    
    
//    orient milestone events on grid
    
    setTimeout(function () {

        $('.milestone.draggable').hide();

        $('.milestone.draggable').each(function (i) {

            var thislayer = $(this).find('p.layer').text();
            // alert(thislayer);
            $(this).css('top', (layerheight + 1) * (thislayer - 1));
            // 'i' stands for index of each element
            $(this).hide().delay(i * 50).fadeIn(500);
        });

    }, 1000);
    

    // initial load of Timeline event metadata
    $(".timeline.draggable").each(function (i) {

        // $(this).animate({
        //     opacity: 1
        // }, 1050);
        // $(this).hide();


        var left = $(this).position().left;
        var top = $(this).position().top;
        var width = $(this).width();
        var id = $(this).attr('id');
        var layer = (top / layerheight) + 1;
        layer = Math.round(layer);
        var days = width / 24;
        days = Math.round(days);

        $(this).height(layerheight);

        var start = left / 24;
        start = moment(year + '-01-01').add(start, 'd').format('YYYY-MM-DD');
        var end = (left / 24) + days;
        end = moment(year + '-01-01').add(end - 1, 'd').format('YYYY-MM-DD');
        // alert(end);
        // $(this).find('p.position').text('left: ' + left + 'px & top:' + top + 'px');
        // $(this).find('p.width').text('width: ' + $(this).width() + 'px + days:' + days + 'layer: ' + layer);
        // $(this).find('p.date').text('Start: ' + start + ' End: ' + end);

    });


    $(".milestone.draggable").each(function (i) {

        // $(this).animate({
        //     opacity: 1
        // }, 1050);

        // $(this).hide();


        var left = $(this).position().left;
        var top = $(this).position().top;
        var width = $(this).width();
        var id = $(this).attr('id');
        var layer = (top / layerheight) + 1;
        layer = Math.round(layer);
        var days = width / 24;
        days = Math.round(days);

        $(this).height(layerheight);

        var start = left / 24;
        start = moment(year + '-01-01').add(start, 'd').format('YYYY-MM-DD');


        //        var end = (left / 24) + days;
        //        end = moment(year + '-01-01').add(end - 1, 'd').format('YYYY-MM-DD');


        // alert(end);
        // $(this).find('p.position').text('left: ' + left + 'px & top:' + top + 'px');
        // $(this).find('p.width').text('width: ' + $(this).width() + 'px + days:' + days + 'layer: ' + layer);
        // $(this).find('p.date').text('Start: ' + start + ' End: ' + end);

    });



    // $('.timeline.draggable').each(function(i) {
    //   // 'i' stands for index of each element
    //   $(this).hide().delay(i * 3500).fadeIn(1500);
    // });
    
//    prevent context menu on right click
    
    $('#timeline').bind("contextmenu",function(e){
        return false;
    });


    // create new milestone event on right click

    $('#timeline').mousedown(function (e) {
        if (e.button == 2) {
            //      alert('Right mouse button!'); 


            var x = event.pageX,
                y = event.pageY - 100;
                y = y - layerheight;

//            alert(event.pageY);
//            alert(y);

            var layer = (y / layerheight) + 1;
            layer = Math.round(layer);
            y = (layerheight + 1) * (layer - 1);

            $(".new.milestone").first().css("top", y).css("left", x);

            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'addmilestone',
                    width: '50',
                    top: y,
                    left: x
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }
                    // alert(data);

                    $(".new.milestone").first().css("opacity", "1").css("display", "block").removeClass('new').attr('id', data).addClass('draggable');

                    // $(".new").first()


                },
                error: function (data) {
                    alert("sorry, couldn't creat timeline in Database");
                }
            });



            return false;
        }
        return true;
    });


    // Creat new Timeline Event on doubleclick and save to DB
    $("#timeline").dblclick(function (event) {
        var x = event.pageX,
            y = event.pageY - 100;
            y = y - layerheight;
        // alert(y);

        // y = (Math.round(y / 10) * 10);

        var layer = (y / layerheight) + 1;
        layer = Math.round(layer);
        y = (layerheight + 1) * (layer - 1);

        $(".new.timeline").first().css("top", y).css("left", x);


        // $(".new").first().find('p.position').text('left: ' + x + 'px & top:' + y + 'px');
        // $(".new").first().find('p.width').text('width: ' + $(this).width() + 'px');


        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'addtimeline',
                width: '120',
                top: y,
                left: x
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                // alert(data);
                
//                alert(y, x);

                $(".new.timeline").first().css("opacity", "1").css("display", "block").removeClass('new').attr('id', data).addClass('draggable');

                // $(".new").first()


            },
            error: function (data) {
                alert("sorry, couldn't creat timeline in Database");
            }
        });

    });

    $(function () {
        $("input").dblclick(function (e) {
            e.stopPropagation()
        })
    });

    $(function () {
        $(".timeline").dblclick(function (e) {
            e.stopPropagation()
        })
    });

    $('.timeline').mousedown(function (e) {
        if (e.button == 2) {
            e.stopPropagation()
            //      alert('Right mouse button!'); 
            return false;
        }
        return true;
    });


    // Drah timeline event and save to DB
    $('div.timeline').draggable({
        stop: function (event, ui) {


            var id = $(this).attr('id');
            // alert(id);
            updateTimeline(id);

        }
    });

    $('div.milestone').draggable({
        stop: function (event, ui) {


            var id = $(this).attr('id');
            // alert(id);
            updateMilestone(id);

            //			alert(id);

        }
    });



    $("div.timeline").resizable({
        resize: function (event, ui) {
            // maxHeight: layerheight, // - 10 because its expanding on resize, bug has to be fixed
            // minHeight: layerheight // - 10 because its expanding on resize, bug has to be fixed
            ui.size.height = layerheight;
        }
    });


    // Resize (x) Timeline event and save to DB
    $("div.timeline").resizable({
        stop: function (event, ui) {

            var id = $(this).attr('id');
            // alert(id);
            updateTimeline(id);

        }
    });

    $('input.name').keydown(function (e) {
        // if (e.keyCode == 13) {

            var id = $(this).parent('div.timeline.draggable').attr('id');
            // alert(id);
            updateTimeline(id);

        // }
    });

    $('.timeline select.project').on('change', function () {
        var id = $(this).parent('div.timeline.draggable').attr('id');
        alert(id);
        updateTimeline(id);

    });

    $('.icon.timelinedelete').on('click', function () {
        var id = $(this).parent('div.timeline.draggable').attr('id');
        var name = $('div.timeline.draggable#' + id).find('input.name').val();
        // alert(id);

        // updateTimeline(id);
        if (confirm('Do you want to delete the Timeline ' + name + '?')) {

            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'deletetimeline',
                    id: id
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }
                    // alert(data);

                    $('div.timeline.draggable#' + id).fadeOut(300, function () {
                        $(this).remove();
                    });
                },
                error: function (data) {
                    alert("sorry, couldn't update Timeline");
                }
            });
        }
    });

    $('.icon.milestonedelete').on('click', function () {
        var id = $(this).parent('div.milestone.draggable').attr('id');
        var name = $('div.milestone.draggable#' + id).find('input.name').val();
        // alert(id);

        // updateTimeline(id);
        if (confirm('Do you want to delete the Milestone ' + name + '?')) {

            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'deletemilestone',
                    id: id
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }
                    // alert(data);

                    $('div.milestone.draggable#' + id).fadeOut(300, function () {
                        $(this).remove();
                    });
                },
                error: function (data) {
                    alert("sorry, couldn't update Timeline");
                }
            });
        }
    });


    
    // update timeline
    function updateTimeline(id) {

        var left = $('div.timeline.draggable#' + id).position().left;
        // alert(left);
        var top = $('div.timeline.draggable#' + id).position().top;
        // alert(top);
        var width = $('div.timeline.draggable#' + id).width();
        // alert(width);
        var layer = (top / layerheight) + 1;
        layer = Math.round(layer);
        // alert(layer);
        var days = width / (daylength + daylengthborder);
        days = Math.round(days);
        // alert(days);
        var name = $('div.timeline.draggable#' + id).find('input.name').val();
        // alert(name);
        // alert(name);
        var project = $('div.timeline.draggable#' + id).find('select').val();
        // alert(project);
        // alert(project);

        var start = left / (daylength + daylengthborder);
        start = moment(year + '-01-01').add(start, 'd').format('YYYY-MM-DD');
//         alert(start);
        var end = (left / (daylength + daylengthborder)) + days;
        end = moment(year + '-01-01').add(end - 1, 'd').format('YYYY-MM-DD');
//         alert(end);

        // var startshow = moment(start).format('d. MMMM');

        // moment(start).format('d. MMMM')
        // var endshow = moment(end).format('d. MMMM');
        $('div.timeline.draggable#' + id + ' p.start').text(moment(start).format('D. MMMM'));
        $('div.timeline.draggable#' + id + ' p.width').text(days + ' days');
        $('div.timeline.draggable#' + id + ' p.end').text(moment(end).format('D. MMMM'));

        $(this).height(layerheight);


        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'edittimeline',
                width: width,
                top: top,
                left: left,
                id: id,
                layer: layer,
                days: days,
                start: start,
                end: end,
                name: name,
                project: project
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                
//                alert(start);
                // alert(data);
                var color = '#' + data;
                $('div.timeline.draggable#' + id).animate({
                    backgroundColor: color
                }, 'slow');

                $('div.timeline.draggable#' + id + ' p.start, div.timeline.draggable#' + id + ' p.width, div.timeline.draggable#' + id + ' p.end').animate({
                    color: color
                }, 'slow');

            },
            error: function (data) {
                alert("sorry, couldn't update Timeline");
            }
        });

    }

    $('.milestone input.name').keydown(function (e) {

        //    	alert('name');
        //        if (e.keyCode == 13) {

        var id = $(this).parent().parent('div.milestone.draggable').attr('id');
//                     alert(id);
        updateMilestone(id);

        //        }
    });

    $('.milestone select.project').on('change', function () {
        //    	alert('select');
        var id = $(this).parent().parent('div.milestone.draggable').attr('id');
        //         alert(id);
        updateMilestone(id);

    });
 
    // update milestone
    function updateMilestone(id) {

        var left = $('div.milestone.draggable#' + id).position().left;
//                 alert(left);
        var top = $('div.milestone.draggable#' + id).position().top;
        //         alert(top);
        var width = $('div.milestone.draggable#' + id).width();
        //         alert(width);
        var layer = (top / layerheight) + 1;
        layer = Math.round(layer);
        //         alert(layer);
        var days = width / (daylength + daylengthborder);
        days = Math.round(days);
        //         alert(days);
        var name = $('div.milestone.draggable#' + id).find('input.name').val();
        //         alert(name);
        // alert(name);
        var project = $('div.milestone.draggable#' + id).find('select').val();
        //         alert(project);
        // alert(project);

        var start = left / (daylength + daylengthborder);
        start = moment(year + '-01-01').add(start, 'd').format('YYYY-MM-DD');
//                 alert(start);
        var end = (left / (daylength + daylengthborder)) + days;
        end = moment(year + '-01-01').add(end - 1, 'd').format('YYYY-MM-DD');
//                 alert(end);

        // var startshow = moment(start).format('d. MMMM');

        // moment(start).format('d. MMMM')
        // var endshow = moment(end).format('d. MMMM');
        $('div.milestone.draggable#' + id + ' p.date').text(moment(start).format('D. MMMM'));
        //        $('div.milestone.draggable#' + id + ' p.width').text(days + ' days');
        //        $('div.milestone.draggable#' + id + ' p.end').text(moment(end).format('D. MMMM'));

        $(this).height(layerheight);


        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'edittmilestone',
                width: width,
                top: top,
                left: left,
                id: id,
                layer: layer,
                days: days,
                start: start,
                //end: end,
                name: name,
                project: project
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                // alert(data);
                var color = '#' + data;

                $('div.milestone.draggable#' + id + ' div.dot').animate({
                    backgroundColor: color
                }, 'slow');

                //				alert('div.milestone#' + id + ' p.date');

                //				$('div.milestone#' + id + ' p.date').css("display","none");

                $('div.milestone#' + id + ' input.name').animate({
                    color: color
                }, 'slow');

                $('div.milestone#' + id + ' p.date').animate({
                    color: color
                }, 'slow');

                $('div.milestone#' + id + ' select.project').animate({
                    color: color
                }, 'slow');

                $('div.milestone#' + id + ' div.milestonedelete').animate({
                    color: color
                }, 'slow');



            },
            error: function (data) {
                alert("sorry, couldn't update Timeline");
            }
        });

    }

});
