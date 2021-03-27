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
//   echo "<br>Path: ".$_SERVER['DOCUMENT_ROOT'];
//   echo "<br>Path: ".$_SERVER['SCRIPT_FILENAME'];
//   echo "<br>Path: ".getcwd();

//   $rootPath = $_SERVER['DOCUMENT_ROOT'];
// $thisPath = dirname($_SERVER['PHP_SELF']);
// $onlyPath = str_replace($rootPath, '', $thisPath);


// echo "<br>Path: ".$onlyPath;

// echo "<br>Path: ".$_SERVER['SERVER_NAME'];

// echo "<br>Path: ".defined('__DIR__');



// $url = 'http://google.com/dhasjkdas/sadsdds/sdda/sdads.html';
// $url = $_SERVER['DOCUMENT_ROOT'];
// $parse = parse_url($url);
// echo "<br>".$parse['host'];

echo "<br>Path: ".$_SERVER['PHP_SELF'];
echo "<br>Path: ".$_SERVER['HTTP_HOST'];
// $dir = 

$indicesServer = array('PHP_SELF', 
'argv', 
'argc', 
'GATEWAY_INTERFACE', 
'SERVER_ADDR', 
'SERVER_NAME', 
'SERVER_SOFTWARE', 
'SERVER_PROTOCOL', 
'REQUEST_METHOD', 
'REQUEST_TIME', 
'REQUEST_TIME_FLOAT', 
'QUERY_STRING', 
'DOCUMENT_ROOT', 
'HTTP_ACCEPT', 
'HTTP_ACCEPT_CHARSET', 
'HTTP_ACCEPT_ENCODING', 
'HTTP_ACCEPT_LANGUAGE', 
'HTTP_CONNECTION', 
'HTTP_HOST', 
'HTTP_REFERER', 
'HTTP_USER_AGENT', 
'HTTPS', 
'REMOTE_ADDR', 
'REMOTE_HOST', 
'REMOTE_PORT', 
'REMOTE_USER', 
'REDIRECT_REMOTE_USER', 
'SCRIPT_FILENAME', 
'SERVER_ADMIN', 
'SERVER_PORT', 
'SERVER_SIGNATURE', 
'PATH_TRANSLATED', 
'SCRIPT_NAME', 
'REQUEST_URI', 
'PHP_AUTH_DIGEST', 
'PHP_AUTH_USER', 
'PHP_AUTH_PW', 
'AUTH_TYPE', 
'PATH_INFO', 
'ORIG_PATH_INFO') ; 

echo '<table cellpadding="10">' ; 
foreach ($indicesServer as $arg) { 
    if (isset($_SERVER[$arg])) { 
        echo '<tr><td>'.$arg.'</td><td>' . $_SERVER[$arg] . '</td></tr>' ; 
    } 
    else { 
        echo '<tr><td>'.$arg.'</td><td>-</td></tr>' ; 
    } 
} 
echo '</table>' ; 

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
