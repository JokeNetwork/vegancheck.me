<?php
  require('vendor/autoload.php');
  $i18n = new i18n('/var/www/virtual/jake/vegancheck.me/l10n/{LANGUAGE}.json', '/var/www/virtual/jake/vegancheck.me/langcache/', 'en');
  $i18n->init();
?>
<!DOCTYPE html>
<!-- VeganCheck.me is Open Source
Check the project out on GitHub: 
https://vegc.net/repo
-->
<html lang="<?php echo L::meta_lang; ?>">
  <head>
    <title><?php echo L::meta_title; ?></title>
    <meta charset="UTF-8">

    <meta name="description" content="<?php echo L::meta_description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="<?php echo L::meta_title;  ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://vegancheck.me">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:image" content="https://vegancheck.me/img/icon-512x512.png?v=2.0.0">
    <meta name="twitter:image:alt" content="VeganCheck.me">

    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="apple-touch-icon" href="../img/icon.png?v=2.0.0">

    <link rel="manifest" href="../img/site.webmanifest?v=1.0.1">

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="msapplication-starturl" content="/">
    <meta name="theme-color" content="#121212">

    <meta name="application-name" content="VeganCheck">
    <meta name="apple-mobile-web-app-title" content="VeganCheck">
    <link rel="apple-touch-startup-image" href="../img/iossplash.png?v=1.0.0">

    <link href="../css/style.min.css?v=3.9.65" rel="stylesheet">
    <link href="../node_modules/pwa-install-prompt/style.css" rel="stylesheet">
  </head>

  <body id="top">
    <div class="rotate">
      <img src="../img/rotatedevice.svg" alt="<?php echo L::other_rotate; ?>">
      <h1><?php echo L::other_rotate; ?></h1>
    </div>

    <div class="modal_view animatedfaster fadeIn" id="nutriscore" style="display:none;">
      <div class="modal_close"><a class="btn-dark">&times;</a></div>
          <h2>Nutriscore</h2>
          <p><?php echo L::modal_nutriscore_desc; ?></p>
    </div>

    <div class="modal_view animatedfaster fadeIn" id="palmoil" style="display:none;">
      <div class="modal_close"><a class="btn-dark">&times;</a></div>
          <h2><?php echo L::modal_palmoil; ?></h2>
          <p><?php echo L::modal_palmoil_desc; ?></p>
    </div>

    <div class="modal_view animatedfaster fadeIn" id="processed" style="display:none;">
      <div class="modal_close"><a class="btn-dark">&times;</a></div>
          <h2><?php echo L::modal_processed; ?></h2>
          <p><?php echo L::modal_processed_desc; ?></p>
    </div>
    <div class="modal_view animatedfaster fadeIn" id="license" style="display:none;">
      <div class="modal_close"><a class="btn-dark">&times;</a></div>
          <h2>Licenses</h2>
          <p>VeganCheck.me uses different databases and APIs to gather information about a product. The information is licensed under the following licenses:</p>
          <p>
            &copy; OpenFoodFacts Contributors, licensed under <a href="https://opendatacommons.org/licenses/odbl/1.0/">Open Database License</a> and <a href="https://opendatacommons.org/licenses/dbcl/1.0/">Database Contents License</a>.<br>
            Brocade.io Contributors, licensed under <a href="https://creativecommons.org/publicdomain/zero/1.0/">Creative-Commons Zero</a>.<br>
            &copy; Open EAN/GTIN Database Contributors, licensed under <a href="https://www.gnu.org/licenses/fdl-1.3.html">GNU FDL</a>.
        </p>
    </div>
    <noscript>
      <div class="noscript">
        <h3>VeganCheck.me only works properly with Javascript enabled. <a href="https://www.enable-javascript.com">Learn how to enable Javascript here</a>.</h3>
      </div>
    </noscript>
    <div class="container">
      <div id="main">
        <img src="../img/VeganCheck.svg" alt="Logo" class="logo" id="resscroll">
        <h1>VeganCheck.me</h1>
        <form action="../script.php">
          <fieldset>
            <legend><?php echo L::form_enterbarcode; ?></legend>
            <span class="btn_scan" onclick="setupLiveReader()" aria-label="<?php echo L::form_scanbarcode; ?>" role="button" tabindex="0"><span class="icon-barcode"></span></span>
            <input type="number" id="barcode" name="barcode" placeholder="<?php echo L::form_enterbarcode; ?>" autofocus>
            <button name="submit" aria-label="<?php echo L::form_submit; ?>" role="button"><span class="icon-right-open"></span></button>
          </fieldset>
        </form>
        <div class="timeout animated fadeIn" style="display:none;"><?php echo L::other_timeout; ?><span>.</span><span>.</span><span>.</span></div>
         <div class="timeout-final animated fadeIn" style="display:none;"><?php echo L::other_timeoutfinal; ?></div>
        <div id="result">&nbsp;</div> 
        <footer>
            <p><?php echo L::footer_credits; ?>
            <br><?php echo L::footer_legal; ?></p>
            <a href="https://github.com/jokenetwork/vegancheck.me"><img src="../img/opensource.svg" alt="Open Source" class="labels"></a>
            <a href="https://www.thegreenwebfoundation.org/green-web-check/?url=https%3A%2F%2Fvegancheck.me"><img src="../img/greenhosted.svg" alt="Hosted Green" class="labels"></a>
            <a href="https://iplantatree.org/user/VeganCheck.me"><img src="../img/treelabel.svg" alt="We plant trees. We're carbon neutral." class="labels"></a>
            <a href="https://philip.media"><img src="../img/pml.svg" alt="philip.media" class="labels"></a>
        </footer>
      </div>
    </div>

 <div id="controls" style="display:none;">
  <span id="close"><span class="btn-dark" id="closebtn">&times; <?php echo L::layover_close; ?></span><span class="btn-dark" id="torch"><span class="icon-flash"></span></span><span class="btn-dark" id="flipbutton"><span class="icon-flipcamera"></span></span></span>
  <span id="barcodeicon"><span class="icon-barcode"></span></span>
  <div id="background"></div>
</div>

<div class="pwa-install-prompt__container">
            <button class="pwa-install-prompt__overlay"><?php echo L::prompt_close; ?></button>
            <div class="pwa-install-prompt">
                <div class="pwa-install-prompt__icon__container">
                    <img class="pwa-install-prompt__icon" src="../img/icon.png" alt="VeganCheck.me">
                </div>
                <div class="pwa-install-prompt__content">
                    <h3 class="pwa-install-prompt__title"><?php echo L::prompt_install; ?></h3>
                    <p class="pwa-install-prompt__text"><?php echo L::prompt_desc; ?></p>
                    <p class="pwa-install-prompt__guide"><?php echo L::prompt_info; ?></p>
                </div>
            </div>
        </div>

<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../js/BarcodeScanner.min.js"></script>
<script src="../js/app.js?v=1.0.16"></script>
<script src="../node_modules/pwa-install-prompt/script.js"></script>
<script>
var prompt = new pwaInstallPrompt();
</script>
<?php 
        if (isset($_COOKIE['log']) && $_COOKIE['log'] == "Yes"){
          print_r('<script async src="https://analytics.vegancheck.me/ackee.js" data-ackee-server="https://analytics.vegancheck.me" data-ackee-domain-id="77898809-adfe-4573-a05f-88cd663f0fb5" data-ackee-opts=\'{ "detailed": true }\'></script>');
        }  
        elseif (isset($_COOKIE['log']) && $_COOKIE['log'] == "No"){
          print_r('<script async src="https://analytics.vegancheck.me/ackee.js" data-ackee-server="https://analytics.vegancheck.me" data-ackee-domain-id="77898809-adfe-4573-a05f-88cd663f0fb5"></script>');
        }  
        else{
          print_r('<script async src="https://analytics.vegancheck.me/ackee.js" data-ackee-server="https://analytics.vegancheck.me" data-ackee-domain-id="77898809-adfe-4573-a05f-88cd663f0fb5" data-ackee-opts=\'{ "detailed": true }\'></script>');
        } 
?>
  </body>
</html>