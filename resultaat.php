<?php
include('common.php');

$partijRegels = getPartijRegels();

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
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<link rel="shortcut icon" href="//v.fastcdn.co/u/2e79a416/13903153-0-Geenpeil-ring-geente.png" type="image/ico">
    <link rel='stylesheet' id='mmenu-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/css/jquery.mmenu.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='mmenu.positioning-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/extensions/positioning/jquery.mmenu.positioning.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='slick-carousel-css-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/slick-carousel/slick/slick.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesheet-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/style.css?ver=49' type='text/css' media='' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <style>
        @media screen and (max-width: 63.9375em) {
          .header {
            top: 0px;
            position: static;
          }
        }

        .header { background-color: #003399; }
    </style>
    <meta property="og:title" content="<?=$ogTitle?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://mijnstempakket.geenpeil.nl/resultaat.php<?=$checkedURI?>" />
    <meta property="og:image" content="https://mijnstempakket.geenpeil.nl/stempakket.jpg<?=$checkedURI?>" />
    <meta property="og:description" content="<?=$ogDescription?>" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@GeenPeil">
    <meta name="twitter:creator" content="@GeenPeil">
    <meta name="twitter:title" content="<?=$ogTitle?>">
    <meta name="twitter:description" content="<?=$ogDescription?>">
    <meta name="twitter:image" content="https://mijnstempakket.geenpeil.nl/stempakket.jpg<?=$checkedURI?>">
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
                  <div style="text-align: center;" >
                    <a href="http://www.facebook.com/sharer.php?u=<?=urlencode("https://mijnstempakket.geenpeil.nl/resultaat.php".$checkedURI)?>&t=Stel%20je%20eigen%20stempakket%20samen." target="_blank" id="soc_fb"><img src="icon-facebook.png" alt="Deel jouw stempakket op Facebook!" width="64" height="64" /></a>
                    <a style="margin-left: 10px;" href="https://twitter.com/intent/tweet/?url=<?=urlencode("https://mijnstempakket.geenpeil.nl/resultaat.php".$checkedURI)?>&text=Zo%20ziet%20mijn%20stempakket%20eruit." target="_blank" id="soc_tw"><img src="icon-twitter.png" alt="Deel jouw stempakket op Twitter!" width="64" height="64" /></a>
                  </div>
                </div>
                <div style="margin-top: 15px;"  >
                  <h4>Tada! Dit is jouw stempakket</h4>
                  <p>
                    Zo, dat voelt goed! Je hebt nu je eigen politieke partij samengesteld via GeenPeil. 
                    Dit is een voorbeeld van hoe GeenPeil werkt. Als je 15 maart op ons stemt kan je dit écht doen en wij gaan dit écht voor je uitvoeren. 
                    Het mooie is: Je kunt je keuze elk moment wijzigen. Je zit nooit meer vier jaar lang vast aan één partij.
                  </p>
                  <p>
                    Klinkt goed? Dat is directe democratie ook! <a href="https://geenpeil.nl/faq/" target="_blank" >Lees hier hoe het werkt.</a>
                  </p>
                </div>
                <div style="margin-top: 15px; " class="social">
                  <h4>Delen mag, het is gratis:</h4>
                  <div style="text-align: center;" >
                    <a href="http://www.facebook.com/sharer.php?u=<?=urlencode("https://mijnstempakket.geenpeil.nl/resultaat.php".$checkedURI)?>&t=Stel%20je%20eigen%20stempakket%20samen." target="_blank" id="soc_fb"><img src="icon-facebook.png" alt="Deel jouw stempakket op Facebook!" width="64" height="64" /></a>
                    <a style="margin-left: 10px;" href="https://twitter.com/intent/tweet/?url=<?=urlencode("https://mijnstempakket.geenpeil.nl/resultaat.php".$checkedURI)?>&text=Zo%20ziet%20mijn%20stempakket%20eruit." target="_blank" id="soc_tw"><img src="icon-twitter.png" alt="Deel jouw stempakket op Twitter!" width="64" height="64" /></a>
                  </div>
                </div>
                <div style="margin-top: 15px; text-align: center;">
                  <a href="/samenstellen.php" class="button" >Opnieuw invullen</a>
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
