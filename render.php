<?php
define('IMG_WIDTH', 1200);
define('IMG_MIN_HEIGHT', 925);
define('TEXT_START_Y', 545);
define('TEXT_SPACING_Y', 108);
define('THEME_START_X', 113);
define('PARTY_START_X', 638);
define('PARTY_O_START_Y', 635);
define('FONT_SIZE', 29);
define('IMG_HEAD', 'render_head.jpg');
define('IMG_FOOT_OVERIG_PARTIJ', 'render_foot_overig_partij.jpg');
define('IMG_FOOT_OVERIG_ZELF', 'render_foot_overig_zelf.jpg');
define('IMG_FOOR_OVERIG_HEIGHT', 582);
define('IMG_FOOT_CLEAN', 'render_foot_clean.jpg');
define('IMG_FOOR_CLEAN_HEIGHT', 348);
define('IMG_EEN_PARTIJ', 'render_een_partij.jpg');
define('IMG_ZELF_STEMMEN', 'render_zelf_stemmen.jpg');
define('TEXT_1', 'Ik stem zelf');

$ftL = dirname(__FILE__) . '/helvetica.ttf';
$ftB = dirname(__FILE__). '/helvetica-bold.ttf';

$memcache = new Memcache();
$memcache->connect('localhost', 11211) or die ("Could not connect");

header('Content-type: image/jpeg');

include('pdata.php');
$ip = array();

$image_key = md5(http_build_query($_GET));
if (count($_GET) == 1) {
  $cachedImage = $memcache->get($image_key);
  if ($cachedImage) {
    $image = ImageCreateFromString(base64_decode($cachedImage));
    ImageJpeg($image);
    exit();
  }
}

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

  $ip[$themes[$_GET['thema_'.$id]]] = ($zelfStemmen ? TEXT_1 : $parties[$_GET['keuze_'.$id]]);
}

if(isset($_GET['keuze_overig']) && $_GET['keuze_overig'] != 0) {
  $ip['overig'] = $parties[$_GET['keuze_overig']];
}

if($_GET['keuze_overig'] == 0) {
  $ip['overig'] = 'self';
}

// Altijd zelf stemmen
if(count($ip) == 0) {
  $rd = imagecreatefromjpeg(IMG_ZELF_STEMMEN);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X, PARTY_O_START_Y, imagecolorallocate($rd, 0, 0, 0), $ftB, $p);
  imagejpeg($rd);
  imagedestroy($rd);
  exit;
}

// Altijd op 1 partij stemmen
if(count($ip) == 1 && isset($ip['overig'])) {
  $rd = imagecreatefromjpeg(IMG_EEN_PARTIJ);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X, PARTY_O_START_Y, imagecolorallocate($rd, 0, 0, 0), $ftB, $ip['overig']);
  imagejpeg($rd);
  imagedestroy($rd);
  exit;
}

$p = "";
$a = true;
foreach($ip as $v)
{
  if(empty($p)) $p = $v;
  if($v != $p) $a = false;
}

$numPartijRegels = count($ip);
if (isset($ip['overig'])) {
  $numPartijRegels--;
}

$rdH = IMG_MIN_HEIGHT+$numPartijRegels*TEXT_SPACING_Y+(isset($ip['overig']) ? IMG_FOOR_OVERIG_HEIGHT-IMG_FOOR_CLEAN_HEIGHT : 0);

$rd = imagecreatetruecolor(IMG_WIDTH, $rdH);
$cBl = imagecolorallocate($rd, 0, 0, 0);
$cWh = imagecolorallocate($rd, 255, 255, 255);
imagefilledrectangle($rd,0,0,IMG_WIDTH,$rdH,$cWh);

$rd_hd = imagecreatefromjpeg(IMG_HEAD);
imagecopymerge($rd,$rd_hd,0,0,0,0,imagesx($rd_hd),imagesy($rd_hd),100);

if(isset($ip['overig']) && $ip['overig'] != 'self') {
  $rd_ft1 = imagecreatefromjpeg(IMG_FOOT_OVERIG_PARTIJ);
  imagecopymerge($rd,$rd_ft1,0,$rdH-imagesy($rd_ft1),0,0,imagesx($rd_ft1),imagesy($rd_ft1),100);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X-5, $rdH-400, $cBl, $ftB, $ip['overig']);
} else if(isset($ip['overig']) && $ip['overig'] == 'self') {
  $rd_ft3 = imagecreatefromjpeg(IMG_FOOT_OVERIG_ZELF);
  imagecopymerge($rd,$rd_ft3,0,$rdH-imagesy($rd_ft3),0,0,imagesx($rd_ft3),imagesy($rd_ft3),100);
} else {
  $rd_ft2 = imagecreatefromjpeg(IMG_FOOT_CLEAN);
  imagecopymerge($rd,$rd_ft2,0,$rdH-imagesy($rd_ft2),0,0,imagesx($rd_ft2),imagesy($rd_ft2),100);
}

$i = TEXT_START_Y;
$n = 0;
foreach($ip as $theme => $party)
{
 if($n>6) break; // again? max 6 items?
 if($theme=='overig') continue;
 
 imagettftext($rd, FONT_SIZE, 0, THEME_START_X, $i, $cBl, $ftL, $theme);
 imagettftext($rd, FONT_SIZE, 0, PARTY_START_X, $i, $cBl, $ftB, $party);
 
 $i+= TEXT_SPACING_Y;
 $n++;
}

ob_start();
imagejpeg($rd);
$image = ob_get_clean();
imagedestroy($rd);

memcache_add($memcache, $image_key, base64_encode($image), false, 300);
echo $image;
