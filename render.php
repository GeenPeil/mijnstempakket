<?php
include('common.php');

$memcache = new Memcache();
$memcache->connect('localhost', 11211) or die ("Could not connect");

header('Content-type: image/jpeg');

$partijRegels = getPartijRegels();

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

$rdH = IMG_MIN_HEIGHT+min($numPartijRegels, MAX_LINES)*TEXT_SPACING_Y+(isset($partijRegels['overig']) ? IMG_FOOT_OVERIG_HEIGHT-IMG_FOOT_CLEAN_HEIGHT : 0);

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
