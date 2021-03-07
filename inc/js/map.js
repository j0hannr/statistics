jQuery(document).ready(function () {

    var widthx = $(window).width();
    var heightx = $(window).height();

    var host = "localhost";
    var directory = "statistics";

    $('div.container#map_menu').css("top", "-" + heightx + "px");

    $('body').css('height', heightx + 'px').css('overflow', 'hidden');

    //tracking
    $.ajax({
        url: "ajax.php",
        type: "POST",
        data: {
            action: 'track',
            width: widthx,
            height: heightx,
            site: '5'
        },
        success: function (data) {},
        error: function (data) {}
    });

    var mapCenter = new google.maps.LatLng(50.931444, 6.99050); //Google map Coordinates
    var map;

    $('#google_map').height(heightx);

    map_initialize(); // initialize google map

    var smstime = moment().format('YYYY-MM-DD');

    // $.getJSON( "http://one-squared.com/statistics/data.php?id=" + smstime, function( data ) {
    $.getJSON("http://" + host + "/" + directory + "/data.php?id=" + smstime, function (data) {
        //$.getJSON( "http://localhost:8888/6/data.php?id=" + smstime, function( data ) {

        //center map
        var lat = data[11];
        var lon = data[12];
        //alert(lat + lon);

        chicago = new google.maps.LatLng(lat, lon);
        map.setCenter(chicago);

    });


//    alert('hi');
//    console.log('hello');


    //############### Google Map Initialize ##############
    function map_initialize() {
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
        geocoder = new google.maps.Geocoder();
        var googleMapOptions = {
            center: mapCenter, // map center
            zoom: 6, //zoom level, 0 = earth view to higher value
            mapTypeControl: false,
            streetViewControl: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL //zoom control size
            },
            //scaleControl: , // enable scale control
            mapTypeId: google.maps.MapTypeId.ROADMAP // google map type
        };

        map = new google.maps.Map(document.getElementById("google_map"), googleMapOptions);

        var styledMapOptions = {
            name: 'Statistics'
        };
        var usRoadMapType = new google.maps.StyledMapType(roadAtlasStyles, styledMapOptions);
        map.mapTypes.set('Statistics', usRoadMapType);
        map.setMapTypeId('Statistics');

        //search function
        $('input#address').keypress(function (e) {
            if (e.which == 13) {
                //alert('hallo');
                var address = $("input#address").val();
                //alert(address);
                geocoder.geocode({
                    'address': address
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        //var marker = new google.maps.Marker({
                        //map: map,
                        //position: results[0].geometry.location
                        //});
                    } else {
                        alert("not found");
                    }
                });

                return false;
            }
        });

        
//        $.ajax({
//            url: "ajax.php",
//            type: "POST",
//            data: {
//                action: 'getlocations'
//            },
//            success: function (data) {
//                
//                
//                alert(data);
//                console.log(data);
//                
//                
//                $.each(data, function(index, value) {
//                    
//                    console.log(value);
//                    
//                }
//                
//                
//            }
//        });
        
//        console.log('hii 2');


//        alert("hello world");
//        alert("http://" + host + "/" + directory + "/ajax.php?action=getlocations");


        //Load Markers from the XML File, Check (map_process.php)
        //$.get("map_process.php", function (data) {
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'getlocations'
            },
            success: function (data) {

//                alert(data);

                if (data == 'notlogged') {
                    relogin();
                    return false;
                }

                $(data).find("marker").each(function () {
                    var name = $(this).attr('name');
                    var id = $(this).attr('id');
                    var address = $(this).attr('address');
                    var type = $(this).attr('type');
                    var point = new google.maps.LatLng(parseFloat($(this).attr('lat')), parseFloat($(this).attr('lng')));

//                    alert(name);

                    var marker = new google.maps.Marker({
                        position: point,
                        map: map,
                        draggable: false,
                        animation: google.maps.Animation.DROP,
                        title: "Hello World!",
                        // icon: "http://one-squared.com/statistics/inc/icons/pin.png"
                        icon: "http://" + host + "/" + directory + "/inc/icons/pin.png"
                    });


                    //Content structure of info Window for the Markers

                    // Create an infoWindow
                    var infowindow = new google.maps.InfoWindow({
                        content: '',
                        width: 205,
                        maxWidth: 205
                    });


                    // var infowindow = new google.maps.InfoWindow({
                    // content: contentString[0],
                    // maxWidth: 200
                    // });


                    google.maps.event.addListener(map, "click", function (event) {
                        // infowindow.close();
                        closeinfo();
                    });

                    function closeinfo() {
                        infowindow.close();
                    }

                    // var infowindow = new google.maps.InfoWindow();
                    //set the content of infoWindow
                    // infowindow.setContent(contentString[0]);
                    // infoWindow = null;



                    google.maps.event.addListener(marker, 'click', function () {

                        closeinfo();
                        // infowindow.close();
                        infowindow.setContent(contentString[0]);
                        infowindow.open(map, marker);
                    });


                    var contentString = $('<div class="mapwin id' + id + '"><input class="pinname" placeholder="Name..." value="' + name + '"/><textarea class="pintext" placeholder="description...">' + address + '</textarea><select class="pinselect"><option value="1">City/Town</option><option value="2">House</option><option value="3">Hotel</option><option value="4">Restaurant</option><option value="5">Public Place</option><option value="6">Bar</option></select><button class="pinsave">SAVE</button><button class="pindelete">DELETE</button></div>');



                    //add click listner to save marker button
                    // google.maps.event.addListener(marker, 'click', function() {
                    //
                    // // map.clearMarkers();
                    // infowindow.open(map,marker); // click on marker opens info window
                    // });


                    var removeBtn = contentString.find('button.pindelete')[0];
                    //add click listner to remove marker button
                    google.maps.event.addDomListener(removeBtn, "click", function (event) {
                        remove_marker(marker);
                    });

                    contentString.find('select.pinselect').val(type);

                    if (false) //whether info window should be open by default
                    {
                        infowindow.open(map, marker);
                    }

                });

            },
            error: function (data) {
                alert("could not add pins to map");
            }
        });



        //Right Click to Drop a New Marker
        google.maps.event.addListener(map, 'rightclick', function (event) {

            var marker = new google.maps.Marker({
                position: event.latLng,
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                title: "Hello World!",
                // icon: "http://one-squared.com/statistics/inc/icons/pin.png"
                icon: "http://" + host + "/" + directory + "/inc/icons/pin.png"
            });


            //Content structure of info Window for the Markers
            var contentString = $('<div class="outerpin"><div class="innerpin"><div class="mapwin id0"><input class="pinname" placeholder="Name..." /><textarea class="pintext" placeholder="description..."></textarea><select class="pinselect"><option value="1">City/Town</option><option value="2">House</option><option value="3">Hotel</option><option value="4">Restaurant</option><option value="5">Public Place</option><option value="6">Bar</option></select><button class="pinadd">SAVE</button><button class="pindelete">DELETE</button></div></div></div>');

            //Create an infoWindow
            var infowindow = new google.maps.InfoWindow({
                maxWidth: 205,
                width: 205
            });
            //var infowindow = new google.maps.InfoWindow({
            //content: contentString[0],
            //Width: 50
            //Height: 500
            //});
            google.maps.event.addListener(map, "click", function (event) {
                infowindow.close();
            });

            //set the content of infoWindow
            infowindow.setContent(contentString[0]);

            //add click listner to save marker button
            google.maps.event.addListener(marker, 'click', function () {

                infowindow.open(map, marker); // click on marker opens info window
            });

            if (true) //whether info window should be open by default
            {
                infowindow.open(map, marker);
            }


            //Find remove button in infoWindow
            var removeBtn = contentString.find('button.pindelete')[0];
            var saveBtn = contentString.find('button.pinadd')[0];

            //add click listner to remove marker button
            google.maps.event.addDomListener(removeBtn, "click", function (event) {
                remove_marker(marker);
            });

            //add click listner to remove marker button
            //google.maps.event.addDomListener(removeBtn, "click", function(event) {
            //remove_marker(marker);
            //});

            //if(typeof saveBtn !== 'undefined') //continue only when save button is present
            //{
            //add click listner to save marker button
            google.maps.event.addDomListener(saveBtn, "click", function (event) {
                var mReplace = contentString.find('div.innerpin'); //html to be replaced after success
                var mName = contentString.find('input.pinname')[0].value; //name input field value
                var mDesc = contentString.find('textarea.pintext')[0].value; //description input field value
                var mType = contentString.find('select.pinselect')[0].value; //type of marker
                //alert(mType);
                if (mName == '' || mDesc == '') {
                    alert("Please enter Name and Description!");
                } else {
                    //alert('hallo');
                    //Save new marker using jQuery Ajax
                    var mLatLang = marker.getPosition().toUrlValue(); //get marker position
                    //console.log(replaceWin);
                    //alert('hallo');
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            name: mName,
                            description: mDesc,
                            latlang: mLatLang,
                            type: mType,
                            action: "addlocation"
                        },
                        success: function (data) {
                            if (data == 'notlogged') {
                                relogin();
                                return false;
                            }

                            mReplace.html(data); //replace info window with new html
                            marker.setDraggable(false); //set marker to fixed
                            // marker.setIcon('http://one-squared.com/statistics/inc/icons/pin.png'); //replace icon
                            marker.setIcon("http://" + host + "/" + directory + "/inc/icons/pin.png");

                            contentString.find('select.pinselect').val(mType);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError); //throw any errors
                        }
                    });
                    //mType.val('')
                    //alert('schiau');
                    infowindow.close(map, marker);

                }


            });
        });


    }


    //############### Remove Marker Function ##############
    function remove_marker(Marker) {
        /* determine whether marker is draggable
        new markers are draggable and saved markers are fixed */
        if (Marker.getDraggable()) {
            Marker.setMap(null); //just remove new marker
            //alert('wrong');
        } else {
            if (window.confirm("Do you want to delete this Location?")) {
                //Remove saved marker from DB and map using jQuery Ajax
                var mLatLang = Marker.getPosition().toUrlValue(); //get marker position
                //var id = Marker.attr('class');
                //alert(Marker);

                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        latlang: mLatLang,
                        action: 'deletelocation'
                    },
                    success: function (data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        Marker.setMap(null);
                        //alert(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError); //throw any errors
                    }
                });
            }
        }

    }


    $('body').on('click', 'button.pinsave', function () {

        //alert('hallo');
        var id = $(this).closest('div.mapwin').attr('class').replace(/mapwin id/, '');
        //alert(id);

        var name = $(this).closest('div.mapwin').find('input.pinname').val();
        //alert(name);

        var description = $(this).closest('div.mapwin').find('textarea.pintext').val();
        //alert(description);

        var type = $(this).closest('div.mapwin').find('select.pinselect').val();
        //alert(type);

        //var mLatLang = Marker.getPosition().toUrlValue();
        var now = this;

        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                action: 'savelocation',
                id: id,
                name: name,
                description: description,
                type: type
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }

                setTimeout(
                    function () {
                        $(now).css("color", "green");
                    }, 400);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError); //throw any errors
            }
        });

    });


    //re login
    function relogin() {
        //alert('stop');
        $('div#screencover', top.document).css("display", "block");
    };


});
