<?php
include('common.php');
?>
<html>
  <head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
  	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		<link rel="shortcut icon" href="//v.fastcdn.co/u/2e79a416/13903153-0-Geenpeil-ring-geente.png" type="image/ico">
    <title>Stemmen delegeren</title>
    <link rel='stylesheet' id='mmenu-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/css/jquery.mmenu.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='mmenu.positioning-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/extensions/positioning/jquery.mmenu.positioning.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='slick-carousel-css-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/slick-carousel/slick/slick.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesheet-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/style.css?ver=49' type='text/css' media='' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
    var aantalCombinaties = 0;
    
    var voteLine = [
      '<div class="row">',
        '<div class="small-12 medium-6 columns" >',
          '<select name="thema_{{ID}}" id="select_thema_{{ID}}" onChange="keuzeCombinatieUpdate({{ID}});">',
            '<option value="-1">- kies een thema -</option>',
            '<?php foreach($themes as $themeID => $theme) echo "<option value=\"".$themeID."\">".$theme."</option>";?>',
          '</select>',
        '</div>',
        '<div class="small-12 medium-6 columns" >',
          '<select name="keuze_{{ID}}" id="select_keuze_{{ID}}" onChange="keuzeCombinatieUpdate({{ID}});">',
            '<option value="-1">- maak een keuze -</option>',
            '<option value="0">wil ik zelf stemmen</option>',
            '<?php foreach($parties as $partyID => $party) echo "  <option value=\"".$partyID."\">Meestemmen met ".$party."</option>"; ?>',
          '</select>',
        '</div>',
        '<div class="show-for-small-only" >&nbsp;</div>',
      '</div>'].join('\n');

    function loadForm() {
      document.getElementById('table_keuze_combinaties').innerHTML = '';
      addKeuzeCombinatie(0);
    }
    
    function addKeuzeCombinatie(id) {
      $('#table_keuze_combinaties').append(voteLine.replace(/\{\{ID\}\}/g, id));
    }

    function keuzeCombinatieUpdate(combiatieID) {
      updateImage();
      
      if(combiatieID < aantalCombinaties) {
        return; // fast path
      }
      if(aantalCombinaties > 6) { // max 7 combinaties?
        document.getElementById('max_bereikt').style.display = 'inline';
        return;
      }

      if (document.getElementById('select_keuze_'+aantalCombinaties).value >= 0 && document.getElementById('select_thema_'+aantalCombinaties).value >= 0) {
        aantalCombinaties += 1;
        addKeuzeCombinatie(aantalCombinaties);
      }
    }

    function keuzeOverigeUpdate() {
      updateImage();
    }

    function updateImage() {
      if (
        (document.getElementById('select_keuze_0').value >= 0 && document.getElementById('select_thema_0').value >= 0) ||
        document.getElementById('select_keuze_overig').value >= 0 ||
        document.getElementById('checkbox_zelf_alles_kiezen').checked
      ) {
        // document.getElementById('sidebar_stempakket').style.display = "inline";
        // document.getElementById('image_stempakket').src = "stempakket.jpg?"+$('#form_keuzes').serialize();
        document.getElementById('anchor_resultaat').style.display = "inline";
        document.getElementById('anchor_resultaat').href = "resultaat.php?created=yes&"+$('#form_keuzes').serialize();
      }
    }

    function zelfKiezenUpdate() {
      if(document.getElementById('checkbox_zelf_alles_kiezen').checked) {
        document.getElementById('form_keuzes').style.display = "none";
        // document.getElementById('sidebar_stempakket').style.display = "inline";
        // document.getElementById('image_stempakket').src = "stempakket.jpg";
        updateImage();
      } else {
        document.getElementById('form_keuzes').style.display = "inline";
        document.getElementById('sidebar_stempakket').style.display = "none";
      }
    }

    </script>
    <style>
        @media screen and (max-width: 63.9375em) {
          .header {
            top: 0px;
            position: static;
          }
        }
        
        .header { background-color: #003399; }
        
        #anchor_resultaat {
            display: none;
        }
    </style>
    <meta property="og:title" content="<?=$ogTitle?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://mijnstempakket.geenpeil.nl/samenstellen.php" />
    <!-- <meta name="og:image" content="<?=$ogImage?>"> TODO -->
    <meta property="og:description" content="<?=$ogDescription?>" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@GeenPeil">
    <meta name="twitter:creator" content="@GeenPeil">
    <meta name="twitter:title" content="<?=$ogTitle?>">
    <meta name="twitter:description" content="<?=$ogDescription?>">
    <!-- <meta name="twitter:image" content="<?=$ogImage?>"> TODO -->
  </head>
  <body class="page-template-default page page-id-23" onLoad="loadForm();">
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
            <div class="large-8 columns">
              <div class="post-content" style="text-align: center;">
                <div class="page__content">
                   <h3>Mijn politiek pakket</h3><br />
                  <p style="text-align: left; line-height: 140%; font-size: medium;">
                    <label for="checkbox_zelf_alles_kiezen" >
                      <input type="checkbox" id="checkbox_zelf_alles_kiezen" onChange="zelfKiezenUpdate();">
                      Ik wil op alle onderwerpen zelf stemmen
                    </label>
                  </p>
                  <form id="form_keuzes" action="stempakket.jpg" method="POST">
                    <div id="table_keuze_combinaties">
                      <p>Formulier laden...</p>
                    </div>
                    <div id="max_bereikt" style="display: none;" >
                        Je kunt bij deze simulatie slechts 8 thema’s selecteren. Maar geen nood: op ons stemplatform (dat na 15 maart wordt gelanceerd) kun je je stem eindeloos verdelen over andere partijen. Daar geldt dus geen maximum.
                    </div>
                    <div id="keuze_overig">
                      <p><i>en voor alle andere thema's </i></p>
                      <select name="keuze_overig" id="select_keuze_overig" onChange="keuzeOverigeUpdate();" style="width:300px;height:40px;">
                        <option value="-1">- maak een keuze -</option>
                        <option value="0">Ik stem zelf</option>
                        <?php
                        foreach($parties as $partyID => $party)
                        {
                          echo "<option value=\"".$partyID."\">stem ik mee met ".$party."</option>";
                        }
                        ?>
                      </select>
                    </div>
                  </form>
                  <br /><br /><br /><br />
                </div>
                <div>
                  <a id="anchor_resultaat" href="/resultaat.php" class="button button-large" >Verder</a>
                </div>
              </div>
            </div>
            <div class="large-4 columns sticky-element">
              <div style="margin-top: 15px;" >
                Heb je een vraag over Mijn Stempakket? Kijk of je vraag tussen de <a href="https://geenpeil.nl/faq/" target="_blank" >veelgestelde vragen</a> staat.
              </div>
              <!-- <div class="sidebar" id="sidebar_stempakket" style="display:none;">
                <div class="sidebar__item sidebar__item--action-block"  class="shareable-class">
                  <h3>Jouw stempakket</h3>
                  <img id="image_stempakket">
                </div>
              </div> -->
            </div>
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
