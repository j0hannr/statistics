$(document).ready(function() {
    
    console.log('1');

    // variables
    var smstime;
    var entry;
    var host = "localhost";
    var directory = "statistics";
    var hash = window.location.hash.replace('#', '');

    // init -----------------------------------------------------------------------------

    // google maps
    // init google map -----------------------------------------------------------------------------
    var map;

    var lat;
    var lon;

    function initialize() {
        var roadAtlasStyles = [{
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                }]
            },
            {
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#616161"
                }]
            },
            {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#f5f5f5"
                }]
            },
            {
                "featureType": "administrative.land_parcel",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#bdbdbd"
                }]
            },
            {
                "featureType": "administrative.neighborhood",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#eeeeee"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#757575"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#e5e5e5"
                }]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#9e9e9e"
                }]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffffff"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#757575"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dadada"
                }]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#616161"
                }]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#9e9e9e"
                }]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#e5e5e5"
                }]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#eeeeee"
                }]
            },
            {
                "featureType": "water",
                "stylers": [{
                    "color": "#ffffff"
                }]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffffff"
                }]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#9e9e9e"
                }]
            }
        ];

        var mapOptions = {
            zoom: 11,
            // var chicago = new google.maps.LatLng(50.931444, 6.99050);
            center: new google.maps.LatLng(50.931444, 6.99050),
            mapTypeControl: false,
            fullscreenControl: false,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.BOTTOM_CENTER
            },
            panControl: false,
            panControlOptions: {
                position: google.maps.ControlPosition.TOP_RIGHT
            },
            zoomControl: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.LARGE,
                position: google.maps.ControlPosition.LEFT_CENTER
            },
            scaleControl: false,
            streetViewControl: false,
            streetViewControlOptions: {
                position: google.maps.ControlPosition.LEFT_TOP
            },
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'Statistics']
            }
        };
        map = new google.maps.Map(document.getElementById('gmap'), mapOptions);

        var styledMapOptions = {
            name: 'Statistics'
        };
        var usRoadMapType = new google.maps.StyledMapType(roadAtlasStyles, styledMapOptions);
        map.mapTypes.set('Statistics', usRoadMapType);
        map.setMapTypeId('Statistics');
    }
    google.maps.event.addDomListener(window, 'load', initialize);


    console.log('2');

    // screen size
    var width = $(window).width();
    var height = $(window).height();
    
    
    //tracking
    $.ajax({
    url:"ajax.php",
    type:"POST",
    data: {action: 'track', width: width, height: height, site: '2'},
    success: function(data){ },
    error: function(data) { }
    });

    // Detect mobile device!
    var isMobile = false; //initiate as false
    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) isMobile = true;


    // select date
    $('#input_date').pickadate()


    //get current date
    var daynum = moment().format('D');
    var day = moment().format('dddd');
    var month = moment().format('MMMM');
    var date = moment().format('D. of MMMM');
    var smstime = moment().format('YYYY-MM-DD');

    // if day ≠ today print week day instead

    $('div.number').text(daynum);
    $('div.description').text(month);
    $('#input_date').val(smstime);

    //date picked
    $('#input_date').on('change', function() {
        // alert('changed');
        //save text before
        savestory();
        // load new date
        dates();
    });

    // inital data load
    dates();
    
    console.log('3');


    if (hash) {
//         alert(hash);
        var dateFormat = 'YYYY-MM-DD';
        if (moment(moment(hash).format(dateFormat), dateFormat, true).isValid() == true) {
            // alert("okax");

            dates(hash);

        }
    }




    // load data function -----------------------------------------------------------------------------
    function dates(date) {

      var dayinput;

      if (date) {
        // alert(date);
        dayinput = date;

      }
      else {
        var dayinput = $('#input_date').val();
      }

        // alert(dayinput);

        daynum = moment(dayinput).format('D');
        day = moment(dayinput).format('dddd');
        month = moment(dayinput).format('MMMM');
        date = moment(dayinput).format('D. of MMMM');
        smstime = moment(dayinput).format('YYYY-MM-DD');

        // if day ≠ today print week day instead
        $('div.sitename').text(day);
        $('div.number').text(daynum);
        $('div.description').text(month);

        //get data
        widthtimelineday = $('.day_timeline').width();

        // get the daily graph
        $.ajax({
            url: "ajax.php",
            type: "POST",
//            async: false,
            data: {
                action: 'daily_graph',
                date: smstime,
                width: widthtimelineday,
                mobile: isMobile
            },
            success: function(data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                $('div#dailyactivity').html(data);
                console.log(data);
                console.log("1. - day timeline");


                //alert(smstime);
            },
            error: function(data) {
                alert("sorry, couldn't load day timeline");
            }
        });

        
        console.log("4");
        
        console.log("http://" + host + "/" + directory + "/data.php?id=" + smstime);

        // get data from db
        $.getJSON("http://" + host + "/" + directory + "/data.php?id=" + smstime, function(data) {
                
                
                //$.getJSON( "http://localhost:8888/6/data.php?id=" + smstime, function( data ) {

                if (data == 'notlogged') {
                    alert('you are not logged in');
                }
                else if (!data) {
                    alert('no data');
                }

                // location
                $('p#location').text(data[10]);
                // text
                if (!data[4]) {
                    $('textarea#story').val('');
                } else {
                    $('textarea#story').val(data[4]);
                }
                //$('p#story').text(data[4]);
                $('div#quotesquare').remove();
                if (!data[5]) {} else {
                    $('<div class="double square" id="quotesquare"><p id="quote">' + data[5] + '</p><img src="inc/img/delete_2.png" id="deletequote"><img src="inc/img/edit_2.png" id="editquote"><img src="inc/img/done.png" id="savequote"></div>').appendTo('section#squares');
                }

                var temp = data[9];
                $('p#temperature').html(Math.round(temp) + "&deg;");
                $('div#weathericon').css("background-image", "url(inc/img/" + data[8] + ".png)");

                $('div.weather_icon').html('<div class="icon icon-' + data[8] + '"></div>');



                //center map
                lat = data[11];
                lon = data[12];
                // alert(lat + "     " +lon);



                setTimeout(function() {
                    // alert("Boom!");
                    map.setCenter(new google.maps.LatLng(lat, lon));
                }, 100);




                $('p#location_name').text(data[10]);
                $('p#coor').text(data[11] + ' / ' + data[12]);
                $('select#location').val(data[6]);

                // alert(data[6]);


                //alert[6];
                entry = data[1];
                //alert(entry);

                console.log("2. - weather");

                //tags
                $('span.t').remove();
                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'get',
                        day: entry
                    },
                    success: function(data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        $('div#tags').prepend(data);

                        console.log("3. - tags");

                    },
                    error: function(data) {
                        alert("sorry, couldn't load tags");
                    }
                });


                //fields
                $.getJSON("http://" + host + "/" + directory + "/field.php?id=" + entry, function(field) {
                    //$.getJSON( "http://localhost:8888/6/field.php?id=" + entry, function( field ) {

                    $.each(field, function(index, value) {
                        //console.log(value);
                        var id = value.id;
                        var fid = value.fid;
                        //alert(fid);
                        var name = value.name;
                        var symbol = value.symbol;
                        var values = value.value;
                        //alert(fid);
                        //alert(value.value);
                        if (values == null) {
                            var values = '0';
                        }
                        if (id == null) {
                            var id = '';
                        }
                        if (fid == null) {
                            var fid = '';
                        }
                        //alert(values);

                        if ($('div#fieldarea div#' + name).is('*')) {
                            //alert("just update");
                            //alert(name);
                            //alert(values);
                            $('div#fieldarea div#' + name).removeAttr('class').addClass('field ' + fid);

                            // alert('div.fieldarea div#' + name);
                            // alert(fid);

                            $('div#' + name + '.field p.number').removeAttr('class').addClass('number ' + id);
                            $('div.field#' + name + ' span.value').text(values);
                        } else {
                            //alert("create new");

                            $('div#fieldarea').append("<div id='" + name + "' class='field " + fid + "'><img class='buttons plus' src='inc/img/plus.png'/><img class='buttons minus' src='inc/img/minus.png'/><p class='number " + id + "' id='" + name + "'><span class='value' value='" + values + "'>" + values + "</span><span class='lable'>" + symbol + "</span></p><p class='name'>" + name + "</p></div></li>");

                        }


                    });

                    console.log("4. - fields");

                });




            })
            .success(function() {



              // update location function (just uncomment code below)

              //                             var id = $('select#location').val();
              //                               $.ajax({
              //                                   url: "ajax.php",
              //                                   type: "POST",
              //                                   data: {
              //                                       action: 'changelocation',
              //                                       id: id,
              //                                       entry: entry,
              //                                       date: smstime
              //                                   },
              //                                   success: function(data) {
              //                                       console.log('location updated');
              //
              //                                       if (data == 'notlogged') {
              //                                           relogin();
              //                                           return false;
              //                                       }
              //                                       //dates(); /*alert(data);*/
              //                                   },
              //                                   error: function(data) {
              //                                       alert("sorry, couldn't delete post 2");
              //                                   }
              //                               });
              //
              // // +
              //
              // // next day!!!!
              //
              //
              //                               var next = moment(smstime).subtract(1, 'd').format('YYYY-MM-DD');
              //
              //                               //alert(next);
              //                               // alert(next);
              //                               $('#input_date').val(next);
              //                               // smstime = next;
              //                               //savestory();
              //                               dates();










            })
        
            //creating day if not there
            .error(function() {
            
                console.log("creating day if not there");    
            
                //alert("error");
                //alert(smstime);
                var location = $('select#location').val();
                //alert(location);

                //alert("day not existing -> adding new one");

                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'addday',
                        date: smstime,
                        location: location
                    },
                    success: function(data) {
                        if (data == 'notlogged') {
                            relogin();
                        }

                        //alert("day added - refresh needed");
                        //document.location.reload(true);
                        // call reload function (to get new stuff)
                        
                        
                        
                        dates();

                    },
                    error: function(data) {
                        alert("sorry, couldn't add day");
                    }
                });
            });


          //   setTimeout(function() {
          //
          //     alert("update location!");
          //
          //   var id = $('select#location').val();
          //   $.ajax({
          //       url: "ajax.php",
          //       type: "POST",
          //       data: {
          //           action: 'changelocation',
          //           id: id,
          //           entry: entry,
          //           date: smstime
          //       },
          //       success: function(data) {
          //           if (data == 'notlogged') {
          //               relogin();
          //               return false;
          //           }
          //           dates(); /*alert(data);*/
          //
          //
          //           // alert(lat + "     " +lon);
          //           // chicago = new google.maps.LatLng(lat,lon);
          //           // map.setCenter(chicago);
          //
          //           // map.setCenter(new google.maps.LatLng(44.5403, -78.5463));
          //           // map.setCenter(new google.maps.LatLng(lat, lon));
          //
          //           // map.setCenter({
          //           //     lat: lat,
          //           //     lng: lon
          //           // });
          //       },
          //       error: function(data) {
          //           alert("sorry, couldn't delete post 2");
          //       }
          //   });
          //
          // }, 1000);


    };




    // save day function -----------------------------------------------------------------------------
    function savestory() {
        $('img#savestory').css("display", "none");
        $('img#editstory').css("display", "block");
        //$('textarea#story').attr("contentEditable",false);
        var text = $('textarea#story').val();
        $('div#textshield').css("display", "block");
        //$('textarea#story').focusout().blur();
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'updatetext',
                kind: 'story',
                entry: entry,
                text: text
            },
            success: function(data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
            },
            error: function(data) {
                alert("sorry, couldn't upload text");
            }
        });
    };

    $("textarea#story").on('change keyup paste', function() {
        savestory();
    });


    // tags function -----------------------------------------------------------------------------



    // focus tag on click
    $('div#tagbox').click(function() {
        $('span#write').focus();
    });

    //delete any tag
    $('body').on('click', 'div.remove div.icon', function() {
        var action = "delete";
        var id = $(this).closest('span').attr("class").replace(/t tag id/, '');
        // alert(id);
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: action,
                id: id
            },
            success: function(data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                $('span.id' + id).closest('span').fadeOut();
            },
            error: function(data) {
                alert("sorry, couldn't delete tag");
            }
        });
    });

    // add tag function
    $(function() {
        $("#write").keypress(function(e) {
            if (e.keyCode == 13) {
                var value = "";
                var value = $('#write').text();
                //alert(value);
                if (!value) {
                    return false
                }
                $('#write').empty();

                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'add',
                        date: entry,
                        value: value
                    },
                    success: function(data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        $(data).insertBefore("#write");
                    },
                    error: function(data) {
                        alert("sorry, couldn't upload tag");
                    }
                });
            }
        });
    });
    
    

    // arrows key to navigate days -----------------------------------------------------------------------------
    $('body').keydown(function(e) {
        switch (e.which) {
            case 37: // left
                dayback();
                break;

            case 38: // up
                break;

            case 39: // right
                dayforward();
                break;

            case 40: // down
                break;
                
            case 87: // down
                
                $('#location').trigger('change');
                
            break;

            default:
                return; // exit this handler for other keys
        }
        e.preventDefault(); // prevent the default action (scroll / move caret)
    });

    // Function gets run after document is loaded
    $(function() {
        $("textarea, input").keydown(function(e) {
            e.stopPropagation()
        })
    });


    // back
    $('button#back').click(function() {
        dayback();
    });

    function dayback() {
        // alert('back' + smstime);
        var next = moment(smstime).subtract(1, 'd').format('YYYY-MM-DD');
        // alert(next);
        $('#input_date').val(next);
        // smstime = next;
        savestory();
        dates();
    };
    // forward
    $('button#forward').click(function() {
        dayforward();
    });

    function dayforward() {
        // alert('forward' + smstime);
        var next = moment(smstime).add(1, 'd').format('YYYY-MM-DD');
        // alert(next);
        $('#input_date').val(next);
        // smstime = next;
        savestory();
        dates();
    };


    // change location -----------------------------------------------------------------------------
    $('select#location').on('change', function update_location() {
        var id = $(this).val();
        //alert(id);
        //alert(entry);
        //alert(smstime);

        // var id = $('select#location').val();
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'changelocation',
                id: id,
                entry: entry,
                date: smstime
            },
            success: function(data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                dates(); /*alert(data);*/
                
                console.log("API Request: " + data);
                
                


                // alert(lat + "     " +lon);
                // chicago = new google.maps.LatLng(lat,lon);
                // map.setCenter(chicago);

                // map.setCenter(new google.maps.LatLng(44.5403, -78.5463));
                // map.setCenter(new google.maps.LatLng(lat, lon));

                // map.setCenter({
                //     lat: lat,
                //     lng: lon
                // });
            },
            error: function(data) {
                alert("sorry, couldn't delete post 2");
            }
        });

    });



    // field update -----------------------------------------------------------------------------
    //field plus minus
    $('div.field span.value').on('change', function() {



    });

    // $('body').on('change', 'input.value', function() {
    //     //Do calculation and change value of other span2,span3 here
    //     alert('change');
    // });
    //
    // $("input.value").on('change', function() {
    //     // alert('change');
    // });
    //
    // $('input.value').on('input', function() {
    //     alert('Changed!')
    // });
    //
    // $('input.value').keyup(function() {
    //     alert('test');
    // });
    //
    // $("input.value").keypress(function(event) {
    //     alert('hello');
    // });

    $('body').on('click', 'img.buttons', function() {
        // alert('starting fields');
        var action = 'changevalue';
        //get plus or minus
        var opti = $(this).attr('class').replace(/buttons /, '');
        //alert(opti);
        //get field id
        var id = $(this).closest('div.field').attr('class').replace(/field /, '').replace(/field/, '');
        //alert(id);
        //get field id if exists
        var type = $(this).closest('div.field').attr('id');
        //get suffix for instance euro or km
        var suffix = $('div.field#' + type + ' span.lable').text();
        //get value
        var vale = $('div.field#' + type + ' span.value').text();
        //alert('div.field ' + type + ' p.number');
        //alert(opti + '&' + id + '&' + vale);
        var name = $(this).closest('div.field').attr('id');
        //alert(name);
        //alert(entry);
        //if there is no field existing get field id and change action
        if (!id) {
            //alert('no id');
            var action = 'addfield';
            var field = $('div#' + type + ' p.number').attr('class').replace(/number /, '');
            //alert('div#' + type + ' p.number');
            //alert(field);
            var id = field;
            //alert(id);
            //alert(entry);
        };

        if (opti == 'plus') {
            var vale = +vale + 1;
        } else {
            var vale = +vale - 1;
        }

        //alert(vale);
        //$('div.field#' + type + ' span.value').text(vale)
        //alert(action);
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: action,
                id: id,
                value: vale,
                entry: entry
            },
            success: function(data) {
                //alert('success');
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                if (action == 'changevalue') {
                    $('div.field#' + type + ' span.value').text(vale);

                } else if (action == 'addfield') {
                    $('div.field#' + type + ' span.value').text(vale);
                    //alert(data);
                    //alert(name);
                    $('div#fieldarea div#' + name).removeAttr('class').addClass('field ' + data);
                }

            },
            error: function(data) {
                alert("sorry, couldn't delete post 3");
            }
        });


    });



});
