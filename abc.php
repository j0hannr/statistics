<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>droppable demo</title>
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
  <style>

  .draggable {
    width: 90px;
    height: 80px;
    padding: 5px;
    float: left;
    margin: 0 10px 10px 0;
    font-size: .9em;
}

.snap {
    width: 300px;
    height: 100px;
    margin-bottom: 25px;
}
  </style>

</head>
<body>


<script>

$(".draggable").draggable({
    // snapMode: ".dateline",
    // snapTolerance: 30
});

</script>


<div id="" class="snap ui-widget-header">Snap 1</div>
<div id="" class="snap ui-widget-header">Snap 2</div>

<div class="demo">
    <br clear="both" />

    <div id="draggable" class="draggable ui-widget-content">
        <p>Oh Snap!</p>
    </div>
    <div id="results"></div>
</div>


</body>
</html>
