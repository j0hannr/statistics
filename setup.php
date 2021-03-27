<!doctype html>
<html>

  <head>

    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, minimum-scale=0.7, maximum-scale=0.7" />
    <title>Statistics v5</title>
    <link rel="stylesheet" type="text/css" href="inc/css/style.css">
    <link rel="stylesheet" href="inc/css/normalize.css">
    <link rel="stylesheet" href="inc/css/skeleton.css">
    <link rel="stylesheet" href="inc/css/icon-font.css">

  </head>

  <body>
  <?php
  echo "<br>Path: ".$_SERVER['DOCUMENT_ROOT'];
  echo "<br>Path: ".$_SERVER['SCRIPT_FILENAME'];
  echo "<br>Path: ".getcwd();

  $rootPath = $_SERVER['DOCUMENT_ROOT'];
$thisPath = dirname($_SERVER['PHP_SELF']);
$onlyPath = str_replace($rootPath, '', $thisPath);


echo "<br>Path: ".$onlyPath;

$url = 'http://google.com/dhasjkdas/sadsdds/sdda/sdads.html';
$url = $_SERVER['DOCUMENT_ROOT'];
$parse = parse_url($url);
echo "<br>".$parse['host'];

  ?>

    <div id="login" class="container">

      <div class="header" class="row">
        <div style="margin-top: 90px;" class="four columns offset-by-four">
          <div class="header">STATISTICS</div>
          <div class="version">v.5</div>
        </div>
      </div>

      <div class="" class="row">
        <div  class="six columns offset-by-three">
        <h4>Setup Database</h4>
        <p>Past the Database parameter and create your diary</p>
          <form method="post" action="setup_init.php" >

            <input id="host" required placeholder="database host" type="text" name="host"/>
            <input id="user" required placeholder="database user" type="text" name="user"/>
            <input id="database" required placeholder="database name" type="text" name="database"/>
            <input id="pass" required placeholder="Password" type="password" name="pass"/>

            <input id="submit" TYPE="submit"  value="Go"/>

          </form>
        </div>
      </div>

      <div class="symbolics" class="row">
        <div id="symbolics" class="four columns offset-by-four">
          <div data-icon="o" class="icon"></div>
          <div data-icon="c" class="icon"></div>
          <div data-icon="f" class="icon"></div>
        </div>
      </div>

  </div>

  </body>
</html>
