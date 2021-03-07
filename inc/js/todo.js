$(document).ready(function () {

    //tracking
    var width = $(window).width();
    var height = $(window).height();

    //tracking
    $.ajax({
        url: "ajax.php",
        type: "POST",
        data: {
            action: 'track',
            width: width,
            height: height,
            site: '3'
        },
        success: function (data) {},
        error: function (data) {}
    });


    var autosave = 20000;

    var last_todo_list;


    $('#todo').masonry({
        // options
        itemSelector: 'ul.todo',
        columnWidth: 375,
        gutter: 20,
        // fitWidth: true
        transitionDuration: '0.2s',
        resize: true
    });

    // boolean editing_todo = false;
    //alert(width + '&' + height);
    //tracking
    //$.ajax({
    //url:"ajax.php",
    //type:"POST",
    //data: {action: 'track', width: width, height: height, site: '3'},
    //success: function(data){ },
    //error: function(data) { }
    //});

    // $("#todo").gridalicious({width: 375});
    // $("#todo").gridalicious({gutter: 20});
    // $("#todo").gridalicious({selector: 'li.todo'});

    //select category on load
    // $('ul.todo').css("display", "none");
    // var precat = $('select#cat').val();
    // $('ul.' + precat).css("display", "block");
    //alert(precat);

    // $('li.category').first().css("background-color", "rgba(0,0,0,0.26)");

    //select category
    // $('select#cat').on('change',function(){
    //   var cat = $(this).val();
    //   //alert(cat);
    //   $('ul').css("display","none");
    //   $('ul.' + cat).css("display","block");
    // });


    //select category from list
    // $('body').on('click', 'li.category', function() {
    //   var cat = $(this).attr('id');
    //   //alert(cat);
    //   $('ul.todo').css("display","none");
    //   $('ul.' + cat).css("display","block");
    //   $('li.category').css("background-color","rgba(0,0,0,0.02)");
    //   $(this).css("background-color","rgba(0,0,0,0.26)");
    // });

    // fade in todo section
    $('section#todo').hide();

    $('section#todo').hide().delay(2).fadeIn(1200);



    //check or uncheck todo
    $('body').on('click', 'img.check', function () {
        var id = $(this).closest('li').attr('id');
        var status = $(this).attr('class').replace(/check /, '');
        //alert(status + '&' + id);
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: status,
                id: id
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                $('li.todo div#' + id + '.check').html(data);

                if (status == 'false') {
                    $('li.todo div#' + id + '.check').parents('li.todo').removeClass('false').addClass('true');

                    // update number on top
                    var num = parseInt($('div#date div.number').text());
                    num = num - 1;
                    //subtrahieren
                    $('div#date div.number').text(num);

                } else {
                    $('li.todo div#' + id + '.check').parents('li.todo').removeClass('true').addClass('false');

                    // update number on top
                    var num = parseInt($('div#date div.number').text());
                    num = num + 1;
                    //addieren
                    $('div#date div.number').text(num);
                }



                // var li = $('li.todo div#' + id + '.check').parents('li.todo').attr('id');
                // alert(li);
                // $(li).css("color","red");


            },
            error: function (data) {
                alert("sorry, couldn't delete post - there might be no connection to the server");
            }
        });

    });





    // edit category name  ---------------------------------------------------------------------------------
    $('body').on('click', 'ul.todo div.catoptions div.edit', function edit() {

        var kind = "category";
        var id = $(this).closest('ul.todo').attr('class').replace(/todo /, '');
        // alert(id);
        var text = $('ul.' + id + ' h1').text();
        $('ul.' + id + ' h1').attr('contenteditable', 'true');

        // $('ul.' + id + ' h1').text('');
        $('ul.' + id + ' h1').focus();
        // $('ul.' + id + ' h1').selected();
        // $('ul.' + id + ' h1').text(text);

        $(document).keypress(function (e) {
            if (e.which == 13) {

                text = $('ul.' + id + ' h1').text();

                // alert('save '+ id + kind + text);

                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'edittodo',
                        id: id,
                        text: text,
                        kind: kind
                    },
                    success: function (data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        $('ul.' + id + ' h1').attr('contenteditable', 'false').text(data);
                    },
                    error: function (data) {
                        alert("sorry, couldn't update category name");
                    }
                });
            }
        });
    });


    // archive category  ---------------------------------------------------------------------------------
    $('body').on('click', 'ul.todo div.catoptions div.archive', function edit() {

        var id = $(this).closest('ul.todo').attr('class').replace(/todo /, '');
        var text = $('ul.' + id + ' h1').text();
        var status = 'true'; // archive status will be set to true

        if (confirm('Do you want to archive the Todo List ' + text + '?')) {
            // alert('archieve it');
            // alert(status);
            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'archivecategory',
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }
                    $('ul.' + id).css("display", "none");

                    setTimeout(function () {
                        $('#todo').masonry();
                    }, 10);
                },
                error: function (data) {
                    alert("sorry, couldn't update category name");
                }
            });

        } else {
            return false;
        }
    });

    // UN archive category  ---------------------------------------------------------------------------------
    $('body').on('click', 'ul.todo div.catoptions div.unarchive', function edit() {


        var id = $(this).closest('ul.todo').attr('class').replace(/archived todo /, '');
        var name = $(this).closest('ul.todo').attr('id');

        var todolistdata = ($(this).closest('ul.todo').html());
        // alert('<ul class="todo '+id+'" id="'+name+'">'+todolistdata+'</ul>');

        // alert(id);
        var text = $('ul.' + id + ' h1').text();
        // alert(text);
        var status = 'false'; // archive status will be set to true

        if (confirm('Do you want to activate the Todo List ' + text + '?')) {
            // alert('archieve it');
            // alert(status);
            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'archivecategory',
                    id: id,
                    status: status
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }

                    $('ul.' + id).css("display", "none");

                    setTimeout(function () {
                        $('#todo').masonry();
                    }, 10);


                    // $('ul.add').prepend('<ul class="todo '+id+'" id="'+name+'">'+todolistdata+'</ul>');

                },
                error: function (data) {
                    alert("sorry, couldn't update category name");
                }
            });

        } else {
            return false;
        }
    });


    // change category color  ---------------------------------------------------------------------------------
    $('body').on('click', 'ul.todo div.catoptions div.color', function edit() {

        var id = $(this).closest('ul.todo').attr('class').replace(/todo /, '');
        var text = $('ul.' + id + ' h1').text();
        var status = 'true'; // archive status will be set to true

        if ($('ul.todo.' + id + ' div.colors').is(":visible")) {
            // alert('hide box');
            $('ul.todo.' + id + ' div.colors').fadeOut("slow", function () {
                // Animation complete
                $('#todo').masonry();
            });


        } else {




            // alert('change color of ' + text + ' id: ' + id);

            $('ul.todo div.colors').fadeOut("slow", function () {
                // Animation complete
            });

            $('ul.todo.' + id + ' div.colors').fadeIn("slow", function () {
                // Animation complete
                $('#todo').masonry();

            });

            $('body').on('click', 'ul.todo.' + id + ' div.colors div', function edit() {
                // alert('click');
                // alert($(this).text());
                var color = $(this).text();


                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'changecategorycolor',
                        id: id,
                        color: color
                    },
                    success: function (data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        // $('ul.todo.'+id).css("backgroundColor",color);

                        color = '#' + color;

                        // $('ul.todo.'+id).animate({backgroundColor:color},'slow');
                        $('ul.todo.' + id).css("backgroundColor", color);
                        // $('ul.todo.'+id).animate({backgroundColor: color}, 'slow');

                        $('ul.todo div.colors').fadeOut("slow", function () {
                            // Animation complete

                            $('#todo').masonry();
                        });

                    },
                    error: function (data) {
                        alert("sorry, couldn't update category name");
                    }
                });



            });

        }


    });


    // add category  ---------------------------------------------------------------------------------
    $('body').on('click', 'ul.add h1', function edit() {

        // alert('adding a new category')

        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'addcat'
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                // $(data).appendTo('ul#list');
                //                $(data).insertBefore('ul.add');
                //                alert(data);

                //                $('#todo').masonry( 'appended', data );



                var $elems = $(data);
                $('#todo').append($elems).masonry('appended', $elems);



                //                $('#todo').append( data )
                //			    // add and lay out newly prepended items
                //			    .masonry( 'appended', data );

                //                $("section#todo").append(data).masonry( 'reload' );


                //				$('#todo').masonry()
                //  .append( data )
                //  .masonry( 'appended', data )
                //  // layout
                //  .masonry();
                //                

                //                setTimeout(function() {
                //                    $('#todo').masonry();
                //                    alert('masory');
                //                }, 100);
                ////               
                //                setTimeout(function() {
                //                    $('#todo').masonry();
                //                    alert('masory 2nd');
                //                }, 1400);
                ////                


            },
            error: function (data) {
                alert("sorry, couldn't delete post - there might be no connection to the server");
            }
        });


    });


    // $('ul').keydown(function(e) {
    //     var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    //     if (key == 13) {
    //         e.preventDefault();
    //         alert('hello');
    //
    //         if ($('li.todo div[contenteditable="true"]').length) {
    //             alert("it exsists");
    //             // do nothing
    //         } else {
    //             alert("new todo! ");
    //             // alert(last_todo_list);
    //
    //             $('li.add#' + last_todo_list).click();
    //
    //         }
    //
    //     }
    // });

    $('ul').keypress(function (e) {
        if (e.which == 13) {

            // mode =
            // alert('hello');

            if ($('li.todo div[contenteditable="true"]').length) {
                // alert("it exsists");
                // do nothing
            } else {
                // alert("new todo! ");
                // alert(last_todo_list);

                $('li.add#' + last_todo_list).click();


            }


        }
    });



    // edit todo
    $('body').on('click', 'img.edit', function edit() {

        //contenteditable="true"
        var id = $(this).closest('li').attr('id');
        var kind = 'todo';
        var text = $('div#' + id + '.text').text();
        //        alert(text);

        // alert("alert 1: " + id + "kind: " + kind + "text: " + text);
        // alert(text);
        // alert(id);
        //alert(kind);

        $('div#' + id + '.text').attr('contenteditable', 'true').text(text).focus();

        $('li#' + id + '.' + kind + ' > div.options > img.edde').css("display", "none");
        // $('li#' + id + '.' + kind + ' > div.options > img.writ').css("display", "block");
        //cencel editing
        // $('body').on('click', 'img.cencel', function() {
        //     $('li.' + kind + ' div#' + id + '.text').attr('contenteditable', 'false').text(text);
        //     $('li#' + id + '.' + kind + ' > div.options > img.edde').css("display", "block");
        //     $('li#' + id + '.' + kind + ' > div.options > img.writ').css("display", "none");
        // });

        $('li').keypress(function (e) {
            if (e.which == 13) {
                // enter pressed
                // alert("HI 2");

                // alert(kind +'  ' + text);

                var text = $('div#' + id + '.text').text();

                //alert("alert 2: " + id + "kind: " + kind + "text: " + text);
                // alert(text);


                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'edittodo',
                        id: id,
                        text: text,
                        kind: kind
                    },
                    success: function (data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        $('div#' + id + '.text').attr('contenteditable', 'false').text(text);
                    },
                    error: function (data) {
                        alert("sorry, couldn't delete post - there might be no connection to the server");
                    }
                });
                $('li#' + id + '.' + kind + ' > div.options > img.edde').css("display", "block");
                $('li#' + id + '.' + kind + ' > div.options > img.writ').css("display", "none");



            }
        });

        // };
        // });


        // var elem = document.getElementByClass(id);
        // var elem = document.getElementByClass(id);
        addEventListener('keypress', function (e) {
            if (e.keyCode == 13) {
                // console.log('You pressed a "enter" key in somewhere');
                // alert("HEELLLOOO");



                var text = $('div#' + id + '.text').text();

                //alert("alert 2: " + id + "kind: " + kind + "text: " + text);
                // alert(text);


                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'edittodo',
                        id: id,
                        text: text,
                        kind: kind
                    },
                    success: function (data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        $('div#' + id + '.text').attr('contenteditable', 'false').text(text);
                    },
                    error: function (data) {
                        alert("sorry, couldn't delete post - there might be no connection to the server");
                    }
                });
                $('li#' + id + '.' + kind + ' > div.options > img.edde').css("display", "block");
                $('li#' + id + '.' + kind + ' > div.options > img.writ').css("display", "none");




            }
        });



        $('div#' + id + '.text').keypress(function (e) {
            if (e.keyCode == 13) {
                event.preventDefault();
                // alert('You pressed enter!');
                // function(save);

                //$( "img.done" ).trigger( "click" );


                var text = $('div#' + id + '.text').text();

                //alert("alert 2: " + id + "kind: " + kind + "text: " + text);
                // alert(text);


                $.ajax({
                    url: "ajax.php",
                    type: "POST",
                    data: {
                        action: 'edittodo',
                        id: id,
                        text: text,
                        kind: kind
                    },
                    success: function (data) {
                        if (data == 'notlogged') {
                            relogin();
                            return false;
                        }
                        $('div#' + id + '.text').attr('contenteditable', 'false').text(text);
                    },
                    error: function (data) {
                        alert("sorry, couldn't delete post - there might be no connection to the server");
                    }
                });
                $('li#' + id + '.' + kind + ' > div.options > img.edde').css("display", "block");
                $('li#' + id + '.' + kind + ' > div.options > img.writ').css("display", "none");



            }

        });

        // auto save
        setTimeout(function () {

            //alert("auto save");
            var text = $('div#' + id + '.text').text();

            //alert("alert 2: " + id + "kind: " + kind + "text: " + text);
            // alert(text);


            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'edittodo',
                    id: id,
                    text: text,
                    kind: kind
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }
                    $('div#' + id + '.text').attr('contenteditable', 'false').text(text);
                },
                error: function (data) {
                    alert("sorry, couldn't delete post - there might be no connection to the server");
                }
            });
            $('li#' + id + '.' + kind + ' > div.options > img.edde').css("display", "block");
            $('li#' + id + '.' + kind + ' > div.options > img.writ').css("display", "none");





        }, autosave);



    });






    //add todo ---------------------------------------------------------------------------------------------
    $('body').on('click', 'li.add', function add_todo() {
        // alert('hello');
        //var status = 'add';

        var id = $(this).closest('ul').attr('class').replace(/todo /, '');

        // alert(id);

        last_todo_list = id;
        // alert(id);
        //$('<li></li>').insertBefore("li#" + id + '.add');
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'addtodo',
                id: id
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                // document.getElementById(id).getElementsByClassName('add').getElementsByTagName('li').insertAdjacentHTML('beforebegin', data);
                // alert("li#" + id + '.add');

                // alert(data);
                $(data).insertBefore("li#" + id + '.add');


                $('#todo').masonry();

                // update number on top
                var num = parseInt($('div#date div.number').text());
                num = num + 1;
                //addieren
                $('div#date div.number').text(num);

                // $grid.masonry();

                setTimeout(example, 300, id);

                // setTimeout(
                function example(id) {

                    // alert(id);
                    // $( "li.third-item" ).prev().css( "background-color", "red" );
                    var id = $("li#" + id + '.add').prev().attr('id');
                    // alert(id);
                    // alert(idx);
                    // var id = $('li.add:visible').prev().attr('id');
                    // alert(id);

                    var text = $('div#' + id + '.text').text();
                    $('li.todo div#' + id + '.text').attr('contenteditable', 'true').text('').focus();
                    $('li#' + id + '.todo > div.options > img.edde').css("display", "none");
                    // $('li#' + id + '.todo > div.options > img.writ').css("display", "block");
                    //cencel editing
                    $('body').on('click', 'img.cencel', function () {
                        $('li.todo div#' + id + '.text').attr('contenteditable', 'false').text(text);
                        $('li#' + id + '.todo > div.options > img.edde').css("display", "block");
                        $('li#' + id + '.todo > div.options > img.writ').css("display", "none");
                    });

                    //save edition ----------------------------------------------------------------------------------------------------------
                    // $('body').on('click', 'img.done', function(save) {


                    $(document).keypress(function (e) {
                        if (e.which == 13) {


                            //var status = 'edit';
                            var text = $('div#' + id + '.text').text();
                            //alert(text);
                            //alert(id);
                            $.ajax({
                                url: "ajax.php",
                                type: "POST",
                                data: {
                                    action: 'edittodo',
                                    id: id,
                                    text: text,
                                    kind: 'todo'
                                },
                                success: function (data) {
                                    if (data == 'notlogged') {
                                        relogin();
                                        return false;
                                    }
                                    $('div#' + id + '.text').attr('contenteditable', 'false').text(text);

                                    // },
                                },
                                error: function (data) {
                                    alert("sorry, couldn't delete post - there might be no connection to the server");
                                }
                            });
                            $('li#' + id + '.todo > div.options > img.edde').css("display", "block");
                            $('li#' + id + '.todo > div.options > img.writ').css("display", "none");
                        }
                    });




                    //                    setTimeout(function () {
                    //
                    //                        //alert("auto save");
                    //                        var text = $('div#' + id + '.text').text();
                    //
                    //
                    //                        //var status = 'edit';
                    //                        var text = $('div#' + id + '.text').text();
                    //                        //alert(text);
                    //                        //alert(id);
                    //                        $.ajax({
                    //                            url: "ajax.php",
                    //                            type: "POST",
                    //                            data: {
                    //                                action: 'edittodo',
                    //                                id: id,
                    //                                text: text,
                    //                                kind: 'todo'
                    //                            },
                    //                            success: function (data) {
                    //                                if (data == 'notlogged') {
                    //                                    relogin();
                    //                                    return false;
                    //                                }
                    //                                $('div#' + id + '.text').attr('contenteditable', 'false').text(data);
                    //
                    //
                    //                            },
                    //                            error: function (data) {
                    //                                alert("sorry, couldn't delete post - there might be no connection to the server");
                    //                            }
                    //                        });
                    //                        $('li#' + id + '.todo > div.options > img.edde').css("display", "block");
                    //                        $('li#' + id + '.todo > div.options > img.writ').css("display", "none");
                    //
                    //
                    //
                    //
                    //                    }, autosave);


                };


            },
            error: function (data) {
                alert("sorry, couldn't delete post - there might be no connection to the server");
            }
        });
    });

    // delete todo
    $('body').on('click', 'img.delete', function () {
        var id = $(this).closest('li').attr('id');
        var kind = 'todo';
        //alert(id);
        //alert(kind);
        //alert('li#' + id + '.' + kind);
        //$('li#' + id + '.' + kind).css("color","red");
        $.ajax({
            url: "ajax.php",
            type: "POST",
            data: {
                action: 'deletetodo',
                id: id,
                kind: kind
            },
            success: function (data) {
                if (data == 'notlogged') {
                    relogin();
                    return false;
                }
                $('li#' + id + '.' + kind).fadeOut();


                setTimeout(function () {
                    $('#todo').masonry();
                }, 500);


            },
            error: function (data) {
                alert("sorry, couldn't delete post - there might be no connection to the server");
            }
        });



    });

    // delete archieved category (todo list)
    $('body').on('click', 'ul.todo div.catoptions div.delete', function edit() {

        var id = $(this).closest('ul.todo').attr('class').replace(/archived todo /, '');
        var name = $(this).closest('ul.todo').attr('id');
        //        alert(id);
        //        alert(name);

        //        var todolistdata = ($(this).closest('ul.todo').html());
        // alert('<ul class="todo '+id+'" id="'+name+'">'+todolistdata+'</ul>');

        // alert(id);
        var text = $('ul.' + id + ' h1').text();
        // alert(text);
        //        var status = 'false'; // archive status will be set to true

        if (confirm('Do you want to delete the Todo List ' + text + '?')) {
            // alert('archieve it');
            // alert(status);
            $.ajax({
                url: "ajax.php",
                type: "POST",
                data: {
                    action: 'deletecategory',
                    id: id
                },
                success: function (data) {
                    if (data == 'notlogged') {
                        relogin();
                        return false;
                    }

                    $('ul.' + id).css("display", "none");

                    //                    setTimeout(function () {
                    //                        $('#todo').masonry();
                    //                    }, 10);

                    // $('ul.add').prepend('<ul class="todo '+id+'" id="'+name+'">'+todolistdata+'</ul>');

                },
                error: function (data) {
                    alert("sorry, couldn't update category name");
                }
            });

        } else {
            return false;
        }

    });



    //add category
    // $('img#addcat').click(function() {
    //     //alert('helo');
    //     //var status = 'addcat';
    //     //var id = $(this).closest('ul').attr('class').replace(/todo /,'')
    //     //alert(id);
    //     //$('<li></li>').insertBefore("li#" + id + '.add');
    //     $.ajax({
    //         url: "ajax.php",
    //         type: "POST",
    //         data: {
    //             action: 'addcat'
    //         },
    //         success: function(data) {
    //             if (data == 'notlogged') {
    //                 relogin();
    //                 return false;
    //             }
    //             $(data).appendTo('ul#list');
    //
    //             //delayed 300ms
    //             setTimeout(
    //                 function() {
    //                     var id = $('li.category:visible').last().attr('id');
    //                     //alert(id);
    //                     var text = $('div#' + id + '.text').text();
    //                     //alert(text);
    //                     $('li.category div#' + id + '.text').attr('contenteditable', 'true').text('').focus();
    //                     $('li#' + id + '.category > div.options > img.edde').css("display", "none");
    //                     // $('li#' + id + '.category > div.options > img.writ').css("display", "block");
    //                     //cencel editing
    //                     $('body').on('click', 'img.cencel', function() {
    //                         $('li.category div#' + id + '.text').attr('contenteditable', 'false').text(text);
    //                         $('li#' + id + '.category > div.options > img.edde').css("display", "block");
    //                         $('li#' + id + '.category > div.options > img.writ').css("display", "none");
    //                     });
    //
    //                     //save edition ------------------------------------------------------------------------------------------------------------
    //                     $('body').on('click', 'img.done', function(save) {
    //                         //var status = 'edit';
    //                         var text = $('div#' + id + '.text').text();
    //                         //alert(text);
    //                         $.ajax({
    //                             url: "ajax.php",
    //                             type: "POST",
    //                             data: {
    //                                 action: 'edittodo',
    //                                 id: id,
    //                                 text: text,
    //                                 kind: 'category'
    //                             },
    //                             success: function(data) {
    //                                 if (data == 'notlogged') {
    //                                     relogin();
    //                                     return false;
    //                                 }
    //                                 $('li.category div#' + id + '.text').attr('contenteditable', 'false').text(data);
    //                             },
    //                             error: function(data) {
    //                                 alert("sorry, couldn't delete post - there might be no connection to the server");
    //                             }
    //                         });
    //                         $('li#' + id + '.category > div.options > img.edde').css("display", "block");
    //                         $('li#' + id + '.category > div.options > img.writ').css("display", "none");
    //                     });
    //                 }, 400);
    //
    //
    //         },
    //         error: function(data) {
    //             alert("sorry, couldn't delete post - there might be no connection to the server");
    //         }
    //     });
    //
    // });

    //re login
    function relogin() {
        //alert('stop');
        $('div#screencover', top.document).css("display", "block");
    };

});
