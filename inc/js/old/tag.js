$(document).ready(function()
  {
    //get tags for certain day initially
    var day = $('select#day').val();
    //alert(day);
    //var action = "get";
    $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: "get", day: day},
	  success: function(data){ $('div#tags').prepend(data); },
	  error: function(data) { alert("sorry, couldn't delete post");}
    });
    
  //get tags onclick  
  $('select#day').change(function() {
    
    $('span.t').css("display","none");
    
    var day = $('select#day').val();
    //alert(day);
    var action = "get";
    $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: action, day: day},
	  success: function(data){ $('div#tags').prepend(data); },
	  error: function(data) { alert("sorry, couldn't delete post");}
    });
  });
  
  $(function(){
    $("#write").keypress(function (e) {
      if (e.keyCode == 13) {
        var action = "add";
        var value = "";
	var user = "1";
	var date = $('select#day').val();

        var value = $('#write').text();
	
        if (!value) {return false}
        $('#write').empty();
	//alert(value);
	$.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: action, user: user,date: date,value: value},
	  success: function(data){ $(data).insertBefore("#write");},     
	  error: function(data) { alert("sorry, couldn't upload post");}
	});
      }
    });
  });


  $('body').on('click', 'img.remove', function() {
    var action = "delete";
    
    var id = $(this).closest('span').attr("class").replace(/t tag id/, '');
    
    $.ajax({
	  url:"ajax.php",
	  type:"POST",
	  data: {action: action, id: id},
	  success: function(data){ $('span.id' + id).closest('span').fadeOut(); },
	  error: function(data) { alert("sorry, couldn't delete post");}
    });
  });

});