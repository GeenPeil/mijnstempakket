<?php
define('IMG_WIDTH', 1200);
define('IMG_MIN_HEIGHT', 925);
define('TEXT_START_Y', 545);
define('TEXT_SPACING_Y', 108);
define('THEME_START_X', 113);
define('PARTY_START_X', 638);
define('PARTY_O_START_Y', 635);
define('FONT_SIZE', 29);
define('MAX_LINES', 6);
define('IMG_HEAD', 'render_head.jpg');
define('IMG_FOOT_OVERIG_PARTIJ', 'render_foot_overig_partij.jpg');
define('IMG_FOOT_OVERIG_ZELF', 'render_foot_overig_zelf.jpg');
define('IMG_FOOT_OVERIG_HEIGHT', 582);
define('IMG_FOOT_CLEAN', 'render_foot_clean.jpg');
define('IMG_FOOT_CLEAN_HEIGHT', 348);
define('IMG_EEN_PARTIJ', 'render_een_partij.jpg');
define('IMG_ZELF_STEMMEN', 'render_zelf_stemmen.jpg');
define('TEXT_STEM_ZELF', 'Ik stem zelf');

$font_light = dirname(__FILE__) . '/helvetica.ttf';
$font_bold = dirname(__FILE__). '/helvetica-bold.ttf';

$memcache = new Memcache();
$memcache->connect('localhost', 11211) or die ("Could not connect");

header('Content-type: image/jpeg');

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


// Show cached image if it exists
$image_key = md5(http_build_query($partijRegels));
$cachedImage = $memcache->get($image_key);
if ($cachedImage) {
  $image = ImageCreateFromString(base64_decode($cachedImage));
  ImageJpeg($image);
  exit();
}


$numPartijRegels = count($partijRegels);

// Altijd zelf stemmen
if($numPartijRegels == 0) {
  $rd = imagecreatefromjpeg(IMG_ZELF_STEMMEN);
  imagejpeg($rd);
  imagedestroy($rd);
  exit;
}

// Altijd op 1 partij stemmen
if($numPartijRegels == 1 && isset($partijRegels['overig'])) {
  $rd = imagecreatefromjpeg(IMG_EEN_PARTIJ);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X, PARTY_O_START_Y, imagecolorallocate($rd, 0, 0, 0), $ftB, $partijRegels['overig']);
  imagejpeg($rd);
  imagedestroy($rd);
  exit;
}

// Wat doet dit?!
/*
$p = "";
$a = true;
foreach($partijRegels as $v)
{
  if(empty($p)) $p = $v;
  if($v != $p) $a = false;
}
*/

if (isset($partijRegels['overig'])) {
  $numPartijRegels--;
}

$rdH = IMG_MIN_HEIGHT+max($numPartijRegels, MAX_LINES)*TEXT_SPACING_Y+(isset($partijRegels['overig']) ? IMG_FOOT_OVERIG_HEIGHT-IMG_FOOT_CLEAN_HEIGHT : 0);

$rd = imagecreatetruecolor(IMG_WIDTH, $rdH);
$colorBlack = imagecolorallocate($rd, 0, 0, 0);
$colorWhite = imagecolorallocate($rd, 255, 255, 255);
imagefilledrectangle($rd,0,0,IMG_WIDTH,$rdH,$colorWhite);

$rd_hd = imagecreatefromjpeg(IMG_HEAD);
imagecopymerge($rd,$rd_hd,0,0,0,0,imagesx($rd_hd),imagesy($rd_hd),100);

if(isset($partijRegels['overig']) && $partijRegels['overig'] != 'self') {
  $rd_ft1 = imagecreatefromjpeg(IMG_FOOT_OVERIG_PARTIJ);
  imagecopymerge($rd,$rd_ft1,0,$rdH-imagesy($rd_ft1),0,0,imagesx($rd_ft1),imagesy($rd_ft1),100);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X-5, $rdH-400, $colorBlack, $font_bold, $partijRegels['overig']);
} else if(isset($partijRegels['overig']) && $partijRegels['overig'] == 'self') {
  $rd_ft3 = imagecreatefromjpeg(IMG_FOOT_OVERIG_ZELF);
  imagecopymerge($rd,$rd_ft3,0,$rdH-imagesy($rd_ft3),0,0,imagesx($rd_ft3),imagesy($rd_ft3),100);
} else {
  $rd_ft2 = imagecreatefromjpeg(IMG_FOOT_CLEAN);
  imagecopymerge($rd,$rd_ft2,0,$rdH-imagesy($rd_ft2),0,0,imagesx($rd_ft2),imagesy($rd_ft2),100);
}

$pos_Y = TEXT_START_Y;
$rulesPrinted = 0;
foreach($partijRegels as $theme => $party)
{
 if($rulesPrinted>MAX_LINES) break; // again? max 6 items?
 if($theme=='overig') continue;
 
 imagettftext($rd, FONT_SIZE, 0, THEME_START_X, $pos_Y, $colorBlack, $font_light, $theme);
 imagettftext($rd, FONT_SIZE, 0, PARTY_START_X, $pos_Y, $colorBlack, $font_bold, $party);
 
 $pos_Y+= TEXT_SPACING_Y;
 $rulesPrinted++;
}

ob_start();
imagejpeg($rd);
$image = ob_get_clean();
imagedestroy($rd);

memcache_add($memcache, $image_key, base64_encode($image), false, 300);
echo $image;
