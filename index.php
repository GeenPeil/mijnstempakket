<?php
include('pdata.php');
?>
<html>
  <head>
    <title>Stemmen delegeren</title>
    <link rel='stylesheet' id='mmenu-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/css/jquery.mmenu.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='mmenu.positioning-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/jQuery.mmenu/dist/extensions/positioning/jquery.mmenu.positioning.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='slick-carousel-css-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/assets/components/slick-carousel/slick/slick.css?ver=4.7.2' type='text/css' media='all' />
    <link rel='stylesheet' id='stylesheet-css'  href='https://geenpeil.nl/wp-content/themes/geenpeil/style.css?ver=49' type='text/css' media='' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
    var cur = 0;
    var voteLine = '<td style="min-width:150px;"><select name="tXID" id="tXID" onChange="ln(XMID);"><option value="-1">- kies een thema -</option><?php foreach($themes as $npo => $theme) echo "<option value=\"".$npo."\">".$theme."</option>";?></select></td><td style="width:20px;"><td><select name="sXID" id="sXID" onChange="ln(XID);"><option value="-1">- maak een keuze -</option><option value="0">Ik stem zelf</option><?php foreach($parties as $listno => $party) echo "  <option value=\"".$listno."\">Meestemmen met ".$party."</option>"; ?></select></td>';
    function ln(sId)
    {
      if(document.getElementById('t0').value > 0)
      {
        if(document.getElementById('s0').value >= 0)
        {
          document.getElementById('sbi').style.display = "inline";
          document.getElementById('genimg').src = "stempakket.jpg?"+encodeURI(window.btoa($('#vttx').serialize()));
        }
      }
      
      if(sId < cur) return;
      if(cur > 6) return;
      cur+=1;
      
      row = document.getElementById('vt').insertRow();
      row.innerHTML = voteLine.replace(/XID/g, cur).replace("XMID", (cur - 1));
      
      if(cur == 1)
        document.getElementById('x0').style.display = "inline";
    }
    
    function loadForm()
    {
      document.getElementById('vt').deleteRow(0);
      row = document.getElementById('vt').insertRow();
      row.innerHTML = voteLine.replace(/XID/g, 0).replace("XMID", (cur - 1));
    }
    
    function cB()
    {
      if(document.getElementById('cc').checked)
      {
        document.getElementById('sbi').style.display = "inline";
        document.getElementById('genimg').src = "stempakket.jpg";
        document.getElementById('vttx').style.display = "none";
      }
      else
      {
        document.getElementById('vttx').style.display = "inline";
        document.getElementById('sbi').style.display = "none";
        ln(0);
      }
    }
    
    </script>
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
        <div class="page-title-container">
          <div class="row">
            <h1>Mijn stem delegeren</h1>
          </div>
        </div>
        <div class="default-page">
          <div class="row">
            <div class="large-8 columns">
              <div class="post-content" style="text-align: center;">
                <header class="page__header">
                
                </header>
                <div class="page__content">
                  <div class="addthis_toolbox addthis_default_style" addthis:url='http://mijnstempakket.nl/' addthis:title='Mijn stempakket'>
                    <a class="addthis_button_facebook_like"></a><a class="addthis_button_tweet"></a>
                  </div>
                  <h3 style="text-align: left;">Stel je eigen pakket samen!</h3>
                  <p style="text-align: left; line-height: 140%; font-size: medium;">Elke politieke partij heeft wel standpunten waar je het grondig mee eens bent. Of juist oneens.</p>
                  <p style="text-align: left; line-height: 140%; font-size: medium;">Daarom kun je bij GeenPeil na de verkiezingen je eigen persoonlijke pakket van politieke standpunten samenstellen. Je kiest dus het allerbeste van alle partijen!</p>
                  <p style="text-align: left; line-height: 140%; font-size: medium;">Je vindt bijvoorbeeld dat privacy het veiligst is bij de Piratenpartij, maar veiligheid laat je liever over aan de PVV. Op het gebied van zorg gaat je voorkeur naar de SP. Maar als het op belastingen aankomt, heb je liever geen SP, maar wil je doen wat de VVD doet.</p>
                  <p style="text-align: left; line-height: 140%; font-size: medium;">Natuurlijk kun je ook altijd zelf per onderwerp stemmen, wanneer je dat wilt en op wat je maar wilt.</p>
                  <hr />
                   <h3>Mijn politiek pakket</h3><br />
                  <p style="text-align: left; line-height: 140%; font-size: medium;"><input type="checkbox" id="cc" onChange="cB();"> Ik wil op alle onderwerpen zelf stemmen</p>
                  <form id="vttx" action="stempakket.jpg" method="POST">
                    <table id="vt"><tr><td><p>Formulier laden...</p></td></tr></table>
                    <div style="display:none;" id="x0"><p><i>en voor alle andere thema's </i></p>
                      <select name="x0" onChange="ln(0);" style="width:35%;height:40px;"><option value="0">stem ik zelf</option>
                      <?php
                      foreach($parties as $listno => $party)
                      {
                        echo "<option value=\"".$listno."\">stem ik mee met ".$party."</option>";
                      }
                      ?>
                      </select>
                    </div>
                  </form>
                  <br /><br /><br /><br />
                </div>
              </div>
            </div>
            <div class="large-4 columns sticky-element">
              <div class="sidebar" id="sbi" style="display:none;">
                <div class="sidebar__item sidebar__item--action-block"  class="shareable-class">
                  <h3>Jouw stempakket</h3>
                  <img id="genimg">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58bd353b234f4b1c"></script> 
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