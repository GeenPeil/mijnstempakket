<?php
include('pdata.php');
$partijRegels = array();
foreach($_GET as $key => $value) {
  if (
    substr($key, 0, 6) != "thema_" || 
    $value < 0
  ) {
    continue;
  }

  $id = explode("_", $key)[1];
  if (
    !is_numeric($id) ||
    !isset($_GET['keuze_'.$id]) ||
    !is_numeric($_GET['keuze_'.$id]) || 
    $_GET['keuze_'.$id] < 0
  ) {
    continue;
  }
  
  $zelfStemmen = false;
  if($_GET['keuze_'.$id] == 0) {
    $zelfStemmen = true;
  }

  $partijRegels[$themes[$_GET['thema_'.$id]]] = ($zelfStemmen ? TEXT_STEM_ZELF : $parties[$_GET['keuze_'.$id]]);
}

if(isset($_GET['keuze_overig']) && $_GET['keuze_overig'] != 0) {
  $partijRegels['overig'] = $parties[$_GET['keuze_overig']];
}

if($_GET['keuze_overig'] == 0) {
  $partijRegels['overig'] = 'self';
}

$partiesReverse = array_flip($parties);
$themesReverse = array_flip($themes);

$checkedURI = "?";
$i = 0;
foreach($partijRegels as $key => $value) {
  switch($key) {
    case 'overig':
      $checkedURI .= "&keuze_overig=".($value=="self"?"0":$partiesReverse[$value]);
      break;
    default:
      $checkedURI .= "&keuze_$i=".($value==TEXT_STEM_ZELF?0:$partiesReverse[$value])."&thema_$i=".$themesReverse[$key];
      $i++;
      break;
  }
}

?>
<html>
  <head>
    <title>Stemmen delegeren</title>
    <link rel='stylesheet' id='mmenu-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/css/jquery.mmenu.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='mmenu.positioning-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/extensions/positioning/jquery.mmenu.positioning.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='slick-carousel-css-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/slick-carousel/slick/slick.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesheet-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/style.css?ver=49' type='text/css' media='' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        @media screen and (max-width: 63.9375em) {
          .header { top: 0px; }
        }
    </style>
    <?php 
      $ogDescription = "Elke politieke partij heeft wel standpunten waar je het grondig mee eens bent. Of juist oneens. Daarom kun je bij GeenPeil na de verkiezingen je eigen persoonlijke pakket van politieke standpunten samenstellen. Zo maak je eigenlijk de ideale partij voor jou.";
    ?>
    <meta property="og:title" content="Mijn Stempakket" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://mijnstempakket.geenpeil.nl/uitslag.php<?=$checkedURI?>" />
    <meta property="og:image" content="https://mijnstempakket.geenpeil.nl/stempakket.jpg<?=$checkedURI?>" />
    <meta property="og:description" content="<?=$ogDescription?>" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@GeenPeil">
    <meta name="twitter:creator" content="@GeenPeil">
    <meta name="twitter:title" content="Mijn Stempakket">
    <meta name="twitter:description" content="<?=$ogDescription?>">
    <meta name="twitter:image" content="ttps://mijnstempakket.geenpeil.nl/stempakket.jpg<?=$checkedURI?>">
  </head>
  <body class="page-template-default page page-id-23">
    <div class="navigation navigation--mobile">
      <div class="nav-wrap">
        <img class="logo" src="https://geenpeil.nl/wp-content/themes/geenpeil/assets/images/geenpeil.svg" alt="GeenPeil">
      </div>
    </div>
    <main class="container container--page">
      <header class="header header--page">
        <div class="row">
          <a href="https://geenpeil.nl">
              <img src="https://geenpeil.nl/wp-content/themes/geenpeil/assets/images/geenpeil.png" alt="GeenPeil" class="logo">
          </a>                             
        </div>
      </header>
      <section class="container container--content">
        <div class="default-page">
          <div class="row">
            <div class="large-offset-1 large-6 columns">
              <div class="post-content">
                <div class="page__content">
                  <img id="image_stempakket" src="stempakket.jpg<?=$checkedURI?>" >
                </div>
              </div>
            </div>
            <div class="large-4 columns" style="margin-top: 40px;">
              <?php if($_GET['created']=='yes'): ?>
                <div class="social">
                  <h4>Jouw Stempakket</h4>
                  <p>Zo. Voelt dat even goed. Je kunt nu de beste standpunten uit alle partijprogramma's kiezen. Zo creëer je als het ware je eigen, ideale partij. En het mooie eraan is: je kunt deze keuze op elk moment wijzigen. Je zit dus niet langer 4 jaar lang vast aan de stem die je uitbrengt op 15 maart.
                    Klinkt goed toch? Dat is het ook. <a href="https://geenpeil.nl/standpunten/" target="_blank" >Lees hier hoe het werkt.</a></p>
                  <h4>Delen mag, het is gratis:</h4>
                  <a href="http://www.facebook.com/sharer.php?u=<?=urlencode("https://mijnstempakket.geenpeil.nl/uitslag.php".$checkedURI)?>&t=Stel%20je%20eigen%20stempakket%20samen." target="_blank" id="soc_fb"><img src="icon-facebook.png" alt="Deel jouw stempakket op Facebook!" width="64" height="64" /></a>
                  <a href="https://twitter.com/intent/tweet/?url=<?=urlencode("https://mijnstempakket.geenpeil.nl/uitslag.php".$checkedURI)?>&text=Zo%20ziet%20mijn%20stempakket%20eruit." target="_blank" id="soc_tw"><img src="icon-twitter.png" alt="Deel jouw stempakket op Twitter!" width="64" height="64" /></a>
                </div>
              <?php else: ?>
                <div>
                  <p>Wat je hier ziet is een persoonlijk stempakket dat door een voorganger van jou is samengesteld. 
                    Via GeenPeil heeft deze persoon dus als het ware zijn eigen, ideale partij met stemrecht in de Tweede Kamer gecreëerd.</p>
                  <p>Klinkt vaag?</p>
                  <p>Probeer het anders zelf eens en ervaar hoe geniaal dit is.</p>
                  <a href="/" class="button" >Stel je eigen stempakket samen</a>
                </div>
              <?php endif; ?>
            </div>
            <div class="large-1 columns">&nbsp;</div>
          </div>
        </div>
      </section>
    </main>
    <script type="text/javascript">
      var _paq = _paq || [];
      _paq.push(['trackPageView']);
      _paq.push(['enableLinkTracking']);
      (function() {
        var u="//ap.geenpeil.nl/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '5']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
      })();
    </script>
  </body>
</html>
