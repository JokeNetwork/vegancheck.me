<!DOCTYPE html>
<!-- VeganCheck.me is Open Source
Check the project out on GitHub: 
https://github.com/jokenetwork/vegancheck.me
-->
<html lang="de">
  <head>
    <title>Ist es Vegan? - VeganCheck.me</title>
    <meta charset="UTF-8">

    <meta name="description" content="Überprüfe ob ein Produkt Vegan ist oder nicht mit VeganCheck.me">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="Ist es Vegan? - VeganCheck.me">
    <meta property="og:type" content="">
    <meta property="og:url" content="https://vegancheck.me">

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="manifest" href="img/site.webmanifest">
    <link rel="apple-touch-icon" href="img/icon.png">

    <link href="css/style.min.css?v=3" rel="stylesheet">
  </head>

  <body>
    <div class="container animated zoomIn">
      <div id="main">
        <img src="img/VeganCheck.svg" alt="Logo">
        <h1>VeganCheck.me</h1>
        <p id="code"></p>

        <form action="script.php">
          <fieldset>
            <span class="btn_scan" onclick="setupLiveReader()"><i class="icon-barcode"></i></span>
            <input type="text" id="barcode" name="barcode" placeholder="Barcode eingeben"> 
            <input type="hidden" id="lang" name="lang" value="de">
            <button name="submit"><i class="icon-right-open"></i></button>
          </fieldset>
        </form>
        <div id="result">&nbsp;</div>
        <footer>
          <p>Mit <i class="icon-love"></i> erstellt von <a href="https://philipbrembeck.com">Philip Brembeck</a> &amp; <a href="https://jokenetwork.de">JokeNetwork</a>
            <br><a href="privacy-policy">Datenschutzerklärung</a> / <a href="impressum">Impressum</a> / <a href="//github.com/sponsors/philipbrembeck/">Sponsor werden</a></p>
            <a href="https://github.com/philipbrembeck/vegancheck.me"><img src="img/opensource.svg" alt="Open Source" class="labels"></a>
            <a href="https://www.thegreenwebfoundation.org/green-web-check/?url=https%3A%2F%2Fvegancheck.me"><img src="img/greenhosted.svg" alt="Hosted Green" class="labels"></a>
        </footer>
      </div>
    </div>

 
  <script src="js/jquery.min.js"></script>
  <script src="js/BarcodeScanner.js"></script>
  <script src="js/app.js"></script>
  <script>
  $(function() {      
    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;
    if (isMobile) {
      var resultElement = document.getElementById('code')
      }
   });
  </script>
  <script src="js/submit.js"></script>
<?php 
        header('Access-Control-Allow-Origin: https://analytics.vegancheck.me'); 
        if (isset($_COOKIE['log']) && $_COOKIE['log'] == "Yes"){echo '<script async src="https://analytics.vegancheck.me/tracker.js" data-ackee-server="https://analytics.vegancheck.me" data-ackee-domain-id="77898809-adfe-4573-a05f-88cd663f0fb5" data-ackee-opts=\'{ "detailed": true }\'></script>';}  
        elseif (isset($_COOKIE['log']) && $_COOKIE['log'] == "No"){echo '<script async src="https://analytics.vegancheck.me/tracker.js" data-ackee-server="https://analytics.vegancheck.me" data-ackee-domain-id="77898809-adfe-4573-a05f-88cd663f0fb5"></script>';}  
        else{echo '<script async src="https://analytics.vegancheck.me/tracker.js" data-ackee-server="https://analytics.vegancheck.me" data-ackee-domain-id="77898809-adfe-4573-a05f-88cd663f0fb5" data-ackee-opts=\'{ "detailed": true }\'></script>';} 
?>
  </body>
</html>