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
    <script type="text/javascript">
    var cur = 0;
    
    function ln(sId)
    {
      if(sId < cur) return;
      
      cur+=1;
      document.getElementById('tr'+cur).style.display = "inline";
      document.getElementById('tr0').style.display = "inline";
      document.getElementById('x0').style.display = "inline";
    }
    </script>
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
                  <div class="addthis_toolbox addthis_default_style" addthis:url='https://geenpeil.nl/contact/' addthis:title='Contact'>
                    <a class="addthis_button_facebook_like"></a><a class="addthis_button_tweet"></a>
                  </div>
                  <h3 style="text-align: left;">Stel je eigen pakket samen!</h3>
<p style="text-align: left; line-height: 140%; font-size: medium;">Elke politieke partij heeft wel standpunten waar je het grondig mee eens bent. Of juist oneens.</p>
<p style="text-align: left; line-height: 140%; font-size: medium;">Daarom kun je bij GeenPeil na de verkiezingen je eigen persoonlijke pakket van politieke standpunten samenstellen. Je kiest dus het allerbeste van alle partijen!</p>
<p style="text-align: left; line-height: 140%; font-size: medium;">Je vindt bijvoorbeeld dat privacy het veiligst is bij de Piratenpartij, maar veiligheid laat je liever over aan de PVV. Op het gebied van zorg gaat je voorkeur naar de SP. Maar als het op belastingen aankomt, heb je liever geen SP, maar wil je doen wat de VVD doet.</p>
<p style="text-align: left; line-height: 140%; font-size: medium;">Natuurlijk kun je ook altijd zelf per onderwerp stemmen, wanneer je dat wilt en op wat je maar wilt.</p>
<hr />
<form action="render.php" method="POST">
&nbsp;
 <h3>Mijn politiek pakket</h3>&nbsp;
                    <table>
                      <?php
                      $x = 0;
                      $i = 0;
                      foreach($themes as $tno => $theme)
                      {
                        echo "<tr id=\"tr".$i."\" ".($x ? " style=\"display:none;\"" : "")."><td style=\"min-width:150px;\"><p>".$theme."</p></td><td><select name=\"".$tno."\" onChange=\"ln(".$i.");\"><option value=\"0\">Ik stem zelf</option>";
                        foreach($parties as $listno => $party)
                        {
                          echo "<option value=\"".$listno."\">Meestemmen met ".$party."</option>";
                        }
                        echo "</select></td></tr>";
                        if(!$x) $x=1;$i++;
                      }
                      ?>
                    </table>
                    <div style="display:none;" id="x0"><p><i>en voor alle andere thema's </i></p>
                      <select name="x0" style="width:35%;height:40px;"><option value="0">stem ik zelf</option>
                      <?php
                      foreach($parties as $listno => $party)
                      {
                        echo "<option value=\"".$listno."\">stem ik mee met ".$party."</option>";
                      }
                      ?>
                      </select>
                      <input type="submit" value="Delen!" style="height:40px;">
                    </div>
                  </form>
                </div>
              </div>
            </div>
<div class="large-4 columns sticky-element">
<div class="sidebar">
<div class="sidebar__item sidebar__item--action-block">
<h3>Stemmen delegeren</h3>
<p style="line-height: 140%; font-size: medium;">Helaas is dit maar een demo, maar zou het niet geweldig zijn als we het beste uit alle politieke partijprogramma's kunnen nemen? Wij denken van wel. Check de animatie voor meer tekst en uitleg: </p>
<p><div class="video-container active"><iframe src="https://www.youtube.com/embed/z_dO3igQMA?rel=0&amp;controls=0&amp;showinfo=0" width="560" height="300" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div></p>
</div>
</div>
</div>
          </div>
        </div>
      </section>
    </main>
  </body>
</html>