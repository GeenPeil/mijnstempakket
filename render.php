<?php
define('TEXT_START_Y', 307);
define('TEXT_SPACING_Y', 91);
define('THEME_START_X', 171);
define('TEXT_2_START_X', 604);
define('PARTY_START_X', 947);
define('FONT_SIZE_1', 29);
define('FONT_SIZE_2', 28);
define('FONT_SIZE_3', 23);
define('TEXT_1', "meestemmen met");
define('TEXT_2', "... en bij alle andere thema's wil ik meestemmen met");

header('Content-type: image/jpeg');

include('pdata.php');
$ip = array();

foreach($_POST as $tno => $lno) {
  if(!is_numeric($tno)) continue;
  if(!$lno) continue;
  $ip[$themes[$tno]] = $parties[$lno];
}

if(isset($_POST['x0']) && $_POST['x0'] != 0) $ip[0] = $parties[$_POST['x0']];

$rd = imagecreatefromjpeg('render.jpg');
$cBl = imagecolorallocate($rd, 0, 0, 0);
$ftL = 'helvetica.ttf';
$ftB = 'helvetica-bold.ttf';

$i = TEXT_START_Y;
foreach($ip as $theme => $party)
{
 if(!$theme) continue;
 if($i>750) break;
 
 imagettftext($rd, FONT_SIZE_1, 0, THEME_START_X, $i, $cBl, $ftL, $theme);
 imagettftext($rd, FONT_SIZE_2, 0, TEXT_2_START_X, $i, $cBl, $ftL, TEXT_1);
 imagettftext($rd, FONT_SIZE_1, 0, PARTY_START_X, $i, $cBl, $ftB, $party);
 
 $i+= TEXT_SPACING_Y;
}

if(isset($ip[0]))
{
  $aI = 45;
  if(count($ip) < 5) $aI+=25;
  if(count($ip) > 5) $aI-=45;
  
  imagettftext($rd, FONT_SIZE_3, 0, THEME_START_X, $i+$aI, $cBl, $ftL, TEXT_2);
  imagettftext($rd, FONT_SIZE_3, 0, PARTY_START_X, $i+$aI, $cBl, $ftB, $ip[0]);
}

imagejpeg($rd);
imagedestroy($rd);
?> 