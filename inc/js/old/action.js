$(document).ready(function()
  {
  //user pre loggedin
  //var user = "1";
  var smstime;
  var entry;
  var host = "localhost";

  //get day on load

  //tracking
  var width = $( window ).width();
  var height = $( window ).height();
  //alert(width + '&' + height);
  //tracking
  $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: 'track', width: width, height: height, site: '2'},
	  success: function(data){ },
	  error: function(data) { }
  });

  //pickadate
   $( '#input_date' ).pickadate()
  //gridster
    var gridster;
  $(function(){
    gridster = $(".gridster > ul").gridster({
        widget_margins: [10, 10],
        widget_base_dimensions: [170, 170],
        min_cols: 6,
        resize: {
            enabled: true
        }
    }).data('gridster');
  });

  ////initalise google map
  var map;
  var chicago = new google.maps.LatLng(50.931444, 6.99050);
  function initialize() {
  var roadAtlasStyles = [{"stylers":[{"visibility":"off"}]},{"featureType": "administrative.locality","elementType": "labels.text.fill","stylers": [{ "visibility": "on" },{ "color": "#808080" },{ "gamma": 2.09 }]},{"featureType": "administrative.country","elementType": "labels.text","stylers": [{ "visibility": "on" },{ "gamma": 4.02 }]},{"featureType":"road","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"road.arterial","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"road.highway","stylers":[{"visibility":"on"},{"color":"#fee379"}]},{"featureType":"landscape","stylers":[{"visibility":"on"},{"color":"#ffffff"}]},{"featureType":"water","stylers":[{"visibility":"on"},{"color":"#7fc8ed"}]},{},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#83cead"}]},{"elementType":"labels","stylers":[{"visibility":"on","color":"#8d8d8d"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"weight":0.9},{"visibility":"off"}]}  ];
  var mapOptions = {zoom: 12,center: chicago,mapTypeControl: false,mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,position: google.maps.ControlPosition.BOTTOM_CENTER},panControl: false,panControlOptions: {position: google.maps.ControlPosition.TOP_RIGHT},zoomControl: false,zoomControlOptions: {style: google.maps.ZoomControlStyle.LARGE,position: google.maps.ControlPosition.LEFT_CENTER},scaleControl: false,streetViewControl: false,streetViewControlOptions: {position: google.maps.ControlPosition.LEFT_TOP},mapTypeControlOptions: {mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'Statistics']}};map = new google.maps.Map(document.getElementById('gmap'),mapOptions);var styledMapOptions = {name: 'Statistics'};var usRoadMapType = new google.maps.StyledMapType(roadAtlasStyles, styledMapOptions);map.mapTypes.set('Statistics', usRoadMapType);map.setMapTypeId('Statistics');}google.maps.event.addDomListener(window, 'load', initialize);

  //get current date
  var day = moment().format('dddd');
  var date = moment().format('D. of MMMM');
  var smstime = moment().format('YYYY-MM-DD');
  //alert(smstime);
  $('p#day').text(day);
  $('p#date').text(date);
  $('#input_date').val(smstime);
  //alert(dayinput);

  //change date
  $('#input_date').on('change',function(){
    //save text before
    savestory();

    dates();
    //alert('hello');
  });

  dates();

  //set date header
  function dates() {
    var dayinput = $('#input_date').val();
    //alert(dayinput);
    var day = moment(dayinput).format('dddd');
    var date = moment(dayinput).format('D. of MMMM');
    smstime = moment(dayinput).format('YYYY-MM-DD');
    //alert(det + '&' + dete);
    $('p#day').text(day);
    $('p#date').text(date);
    //selcted date
    //alert(smstime);

    //get data

    $.getJSON( "http://".host."/statistics/data.php?id=" + smstime, function( data ) {
    //$.getJSON( "http://localhost:8888/6/data.php?id=" + smstime, function( data ) {

    if (data == 'notlogged') { alert('you are not logged in'); }

      $('p#location').text(data[10]);
      if (!data[4]) { $('textarea#story').val(''); }else{$('textarea#story').val(data[4]);}
      //$('p#story').text(data[4]);
      $('div#quotesquare').remove();
      if (!data[5]) { }else{
	$('<div class="double square" id="quotesquare"><p id="quote">' + data[5] + '</p><img src="inc/img/delete_2.png" id="deletequote"><img src="inc/img/edit_2.png" id="editquote"><img src="inc/img/done.png" id="savequote"></div>').appendTo('section#squares');
      }

      //if (!data[3]) {$('div#milestone').css("opacity","0.5");}else{$('div#milestone').css("opacity","1")}

      var temp = data[9];
      $('p#temperature').html(Math.round(temp)+ "&deg;");
      $('div#weathericon').css("background-image", "url(inc/img/" + data[8] + ".png)");

      //center map
	var lat = data[11];
        var lon = data[12];
        //alert(lat + lon);
	//////map
        chicago = new google.maps.LatLng(lat,lon);
        map.setCenter(chicago);

	$('p#location_name').text(data[10]);
	$('p#coor').text(data[11] + ' / ' + data[12]);
	$('select#location').val(data[6]);


      //alert[6];
      entry = data[1];
      //alert(entry);

       //tags
       $('span.t').remove();
       $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: 'get', day: entry},
	  success: function(data){
		if (data == 'notlogged') { relogin(); return false; }
		$('div#tags').prepend(data);
	   },
    	  error: function(data) { alert("sorry, couldn't delete post 8");}
       });


       //fields
       $.getJSON( "http://".host."/statistics/field.php?id=" + entry, function( field ) {
       //$.getJSON( "http://localhost:8888/6/field.php?id=" + entry, function( field ) {

	$.each(field, function(index, value){
	    //console.log(value);
	var id = value.id;
	var fid = value.fid;
	var name = value.name;
	var symbol = value.symbol;
	var values = value.value;
	//alert(fid);
	//alert(value.value);
	if (values == null) { var values = '0';}
	if (id == null) { var id = '';}
	if (fid == null) { var fid = '';}
	//alert(values);

	if ($('li.field div#' + name).is('*')) {
		//alert(name);
		//alert(values);
		$('li.field div#' + name).removeAttr('class').addClass('field ' + fid);
		$('div#' + name + '.field p.number').removeAttr('class').addClass('number ' + id);
		$('div.field#' + name + ' span.value').text(values);
	}
	else {
		gridster.add_widget("<li class='field' data-row='2' data-col='1' data-sizex='1' data-sizey='1' data-max-sizex='1' data-max-sizey='1' ><div id='" + name + "' class='field " + fid + "'><img class='buttons plus' src='inc/img/plus_2.png'/><img class='buttons minus' src='inc/img/minus_2.png'/><p class='number " + id + "' id='" + name + "'><span class='value'>" + values + "</span><span class='lable' style='font-size: 14px;'>" + symbol + "</span></p><p class='name'>" + name + "</p></div></li>", 1, 1);
	}


	});

       });

       //pictures
       //$.getJSON( "http://one-squared.com/statistics/picture.php?id=" + entry, function( field ) {
       ////$.getJSON( "http://localhost:8888/6/picture.php?id=" + entry, function( field ) {

	////delete all slides


	//$( "li.slide" ).each(function( index ) {
		////console.log( index + ": " + $( this ).text() );
		////var id = $(this).find('div.slide').attr('class').replace(/slide /, '');
		////alert(id);
		//gridster.remove_widget( $(this) );
	//});


	//setTimeout(function () {
	//
	////should be delayed
	//$.each(field, function(index, value){
	//    console.log(value);
	//var id = value.id;
	//var name = value.name;
	////alert(name);
	//var path = 'inc/images/' + entry + '/' + name;
	////alert(path);
	//gridster.add_widget("<li class='slide'><div class='slide " + id + "'></div></li>", 2, 1);
	//
	//$('div.' + id + '.slide').css("background-image","url('" + path + "')");
	//
	//});
	//
	//}, 500);

       //});


    })
    .success(function() { })
    //creating day if not there
    .error(function() {
      //alert("error");
      //alert(smstime);
      var location = $('select#location').val();
      //alert(location);

      $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: 'addday', date: smstime,location: location},
	  success: function(data){ if (data == 'notlogged') { relogin(); } },
	  error: function(data) { alert("sorry, couldn't upload post 6");}
	});
    });

  };


  //rest of tag function
  $(function(){
    $("#write").keypress(function (e) {
      if (e.keyCode == 13) {
        var value = "";
        var value = $('#write').text();
	//alert(value);
        if (!value) {return false}
        $('#write').empty();

	$.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: 'add', date: entry,value: value},
	  success: function(data){
		if (data == 'notlogged') { relogin(); return false; }
		$(data).insertBefore("#write");
	  },
	  error: function(data) { alert("sorry, couldn't upload post 5");}
	});
      }
    });
  });

  //auto select tag
  $('li#tagsquare').click(function() {
    $('span#write').focus();
  });

  //delete any fucking tag
  $('body').on('click', 'img.remove', function() {
    var action = "delete";

    var id = $(this).closest('span').attr("class").replace(/t tag id/, '');
    //alert(id);
    $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: action, id: id},
	  success: function(data){
		if (data == 'notlogged') { relogin(); return false; }
		$('span.id' + id).closest('span').fadeOut();
	  },
	  error: function(data) { alert("sorry, couldn't delete tag");}
    });
  });



  //field plus minus
  $('body').on('click', 'img.buttons', function() {
    alert('hello world');
    console.log('fields in action <----');
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
    if (! id) {
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
    }
    else {
      var vale = +vale - 1;
    }

    //alert(vale);
    //$('div.field#' + type + ' span.value').text(vale)
    //alert(action);
    $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: action, id: id, value: vale, entry: entry},
	  success: function(data){

      alert("success");

		if (data == 'notlogged') { relogin(); return false; }
	    if (action == 'changevalue') {
	      $('div.field#' + type + ' span.value').text(vale);

        alert("changed value");

	    }
	    else if (action == 'addfield') {
	      $('div.field#' + type + ' span.value').text(vale);

	      alert(data);
        alert("finished");
	      //alert(name);

        $('li.field div#' + name).removeAttr('class').addClass('field ' + data);
	    }

	  },
	  error: function(data) { alert("sorry, couldn't delete post 3");}
    });


  });


  //change location
  $('select#location').on('change',function(){
    var id = $(this).val();
    //alert(id);
    //alert(entry);
    //alert(smstime);
    $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: 'changelocation', id: id, entry: entry, date: smstime},
	  success: function(data){
		if (data == 'notlogged') { relogin(); return false; }
		dates(); /*alert(data);*/
	  },
	  error: function(data) { alert("sorry, couldn't delete post 2");}
    });

  });

  //change on db click story
  $('img#editstory').click(function() {
    $('textarea#story').focus();
    //$(this).focus();
    $(this).css("display","none");
    $('img#savestory').css("display","block");
    $('div#textshield').css("display","none");
  });

  //save story
  $('body').on('click', 'img#savestory', function() {
      savestory();
  });

  //save story function
  function savestory() {
    $('img#savestory').css("display","none");
    $('img#editstory').css("display","block");
    //$('textarea#story').attr("contentEditable",false);
    var text = $('textarea#story').val();
    $('div#textshield').css("display","block");
    $('textarea#story').focusout().blur();
    $.ajax({
  	  url:"ajax.php",
  	  type:"POST",
  	  data: {action: 'updatetext', kind: 'story', entry: entry, text: text},
  	  success: function(data){
		if (data == 'notlogged') { relogin(); return false; }
	  },
	  error: function(data) { alert("sorry, couldn't upload text");}
    });
  };


  //add quote onclick
  $('li#quote').click(function() {
    alert('clicked');
    $(this).css("background-image","");


  });


  //change on db click quote
  $('img#editquote').click(function() {
    $('p#quote').attr("contentEditable",true).focus();
    $(this).css("display","none");
    $('img#savequote').css("display","block");

  });

  //save quote
  $('body').on('click', 'img#savequote', function() {
    $(this).css("display","none");
    $('img#editquote').css("display","block");
    $('p#quote').attr("contentEditable",false);
    var text = $('p#quote').text();
    $.ajax({
  	  url:"ajax.php",
  	  type:"POST",
  	  data: {action: 'updatetext', kind: 'quote', entry: entry, text: text},
  	  success: function(data){
		if (data == 'notlogged') { relogin(); return false; }
	  },
	  error: function(data) { alert("sorry, couldn't upload quote");}
    });

  });

  //picture upload
  //$("#uploadForm").change('input',(function(e) {
	//e.preventDefault();
	//var path = "inc/images/" + entry;
	////alert(path);
	//$.ajax({
		//url: "upload.php?entry=" + entry,
		//type: "POST",
		//data:  new FormData(this),
		//contentType: false,
		//cache: false,
		//processData:false,
		//success: function(data)
		//{
			//gridster.add_widget("<li class='slide'>" + data + "</li>", 1, 1);
			//alert(data);
		//},
	  	//error: function()
		//{
			//alert("didn't work");

	 	//}
	//});
   //}));


  //delay iframes
  setTimeout(function() {
    var width = $( window ).width();
    var width = -width;
    //alert(width);
    $('<iframe class="frame" id="todoframe" src="todo.php"></iframe><iframe class="frame" id="mapframe" src="map.php"></iframe>').appendTo('html');
    $('iframe.frame').css("left", width);
  }, 1000);

  window.location.hash = '';

  //redirect user to todos no page load
  $('div#todo').click(function() {
    //window.location.href = "todo.php";
    //alert(width);
    $('iframe.frame').css("opacity", "1").animate({left: '-'+width}, 300);
    $('iframe#todoframe').css("opacity", "1").animate({left: "0px"}, 300);
    $('div.button').css("background","");
    setTimeout(function() {
	$('div.button').css("background","white");
    }, 500);
    window.location.hash = 'todo';
  });

  $('div#logout, p#loginreminder').click(function() {
   $('.frame, .gridster, #header').fadeOut('slow');
   setTimeout(function() {
    window.location.href = "logout.php";
   }, 500);
  });

  $('div#map').click(function() {
    //window.location.href = "map.php";
    $('iframe.frame').css("opacity", "1").animate({left: '-'+width}, 300);
    $('iframe#mapframe').css("opacity", "1").animate({left: "0px"}, 300);
    setTimeout(function() {
	$('div.button').css("background","white");
    }, 380);
    window.location.hash = 'map';
  });

  $('div#day').click(function() {
    $('iframe.frame').css("opacity", "1").animate({left: '-'+width}, 300);
    $('div.button').css("background","");
    window.location.hash = 'day';
  });

  function relogin() {
	$('div#screencover').css("display","block");
  };



});
