<?php

session_start();
require_once 'config.php';
if (!isset($_SESSION['login'])) {

?>

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

    <div id="login" class="container">

      <div class="header" class="row">
        <div style="margin-top: 90px;" class="four columns offset-by-four">
          <div class="header">STATISTICS</div>
          <div class="version">v.5</div>
        </div>
      </div>

      <div class="" class="row">
        <div  class="six columns offset-by-three">
          <form method="post" action="check_login.php" >
            <input id="mail" placeholder="Email" type="mail" name="name"/>
            <input id="passwd" placeholder="Password" type="password" name="pw"/>
            <input id="submit_login" TYPE="submit"  value="Go"/>
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
<?php

} 
else {
    header('Location: http://'.$host.'/today.php');
}

?>
