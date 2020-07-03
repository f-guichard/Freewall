<?php
  if(isset($_ENV['HOSTNAME'])) {
    $XFROM = "X-From: MetallikaaS";
    $XHOST = "X-Hostname: ".$_ENV['HOSTNAME'];
  }
  if(isset($_ENV['CF_INSTANCE_GUID'])) {
    $XFROM = "X-From: Aerofoundry";
    $XHOST = "X-Hostname: ".$_ENV['CF_INSTANCE_GUID'];
  }
  header($XFROM);
  header($XHOST);
?>
<html lang="fr">
    <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Free Wall</title>
            <link rel="stylesheet" type="text/css" href="css/log-gen.css" />
            <link rel="shortcut icon" href="images/favicon.ico" />
    </head> 
    <body onload="getCurrentComments()">
      <section class="input-comment">
        <div class="freewall-input-comment">
            <div class="freewall-show-logo"></div>
            <div class="input-text-bar">
                <input type="text" id="input-text-value" placeholder="Ecrivez votre message içi..." size=35>
            </div>
            <div class="save-button">
                <button type="submit" onclick="saveComment(callBack)" id="button-save"><img src="../images/download.svg"></button>
            </div>
        </div>
      </section>
      <section class="show-comments">
        <div>
          <span class="table-comments" id="icomments"></span>
        </div>
      </section>
    </body>
    <footer>
      <script type="text/javascript" src="js/custo.js"></script>
    </footer>
</html>