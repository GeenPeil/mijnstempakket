<?php
define('IMG_WIDTH', 1200);
define('IMG_MIN_HEIGHT', 925);
define('TEXT_START_Y', 545);
define('TEXT_SPACING_Y', 108);
define('THEME_START_X', 113);
define('PARTY_START_X', 638);
define('PARTY_O_START_Y', 635);
define('FONT_SIZE', 29);
define('IMG_HEAD', 'render_hd.jpg');
define('IMG_FOOT_1', 'render_ft1.jpg');
define('IMG_FOOT_2', 'render_ft2.jpg');
define('IMG_ALT_1', 'render_o1.jpg');
define('IMG_ALT_2', 'render_o2.jpg');
define('TEXT_1', 'Ik stem zelf');

header('Content-type: image/jpeg');
if($_SERVER['REQUEST_METHOD'] == "GET" && empty($_GET))
{
  $rd = imagecreatefromjpeg(IMG_ALT_2);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X, PARTY_O_START_Y, $cBl, $ftB, $p);
  imagejpeg($rd);
  imagedestroy($rd);
  exit;
}

include('pdata.php');
$ip = array();

if(count($_GET) == 1) parse_str(base64_decode(key($_GET)), $_POST);

foreach($_POST as $key => $value) {
  if($value < 0) continue;
  
  $sz = false;
  $type = substr($key,0,1); $no = substr($key,1);
  
  if(!is_numeric($no)) continue;
  if(!isset($_POST['s'.$no])) continue;
  if(!is_numeric($_POST['s'.$no])) continue;
  if(!$_POST['s'.$no]) $sz = true;
  if($_POST['s'.$no] < 0) continue;
  
  if($type == "t") $ip[$themes[$_POST['t'.$no]]] = ($sz ? TEXT_1 : $parties[$_POST['s'.$no]]);
}

if(isset($_POST['x0']) && $_POST['x0'] != 0) $ip[0] = $parties[$_POST['x0']];

$p = "";
$a = 1;
foreach($ip as $v)
{
  if(empty($p)) $p = $v;
  if($v != $p) $a = false;
}

$ri = count($ip); if(isset($ip[0])) $ri--;

$ftL = dirname(__FILE__) . '/helvetica.ttf';
$ftB = dirname(__FILE__). '/helvetica-bold.ttf';

$rd_hd = imagecreatefromjpeg(IMG_HEAD);
$rd_ft1 = imagecreatefromjpeg(IMG_FOOT_1);
$rd_ft2 = imagecreatefromjpeg(IMG_FOOT_2);

$rdH = IMG_MIN_HEIGHT+$ri*TEXT_SPACING_Y+(isset($ip[0]) ? imagesy($rd_ft1)-imagesy($rd_ft2) : 0);

$rd = imagecreatetruecolor(IMG_WIDTH, $rdH);
$cBl = imagecolorallocate($rd, 0, 0, 0);
$cWh = imagecolorallocate($rd, 255, 255, 255);
imagefilledrectangle($rd,0,0,IMG_WIDTH,$rdH,$cWh);

if($a)
{
  $rd = imagecreatefromjpeg(IMG_ALT_1);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X, PARTY_O_START_Y, $cBl, $ftB, $p);
  imagejpeg($rd);
  imagedestroy($rd);
  exit;
}

imagecopymerge($rd,$rd_hd,0,0,0,0,imagesx($rd_hd),imagesy($rd_hd),100);

if(isset($ip[0]))
{
  imagecopymerge($rd,$rd_ft1,0,$rdH-imagesy($rd_ft1),0,0,imagesx($rd_ft1),imagesy($rd_ft1),100);
  imagettftext($rd, FONT_SIZE, 0, THEME_START_X-5, $rdH-400, $cBl, $ftB, $ip[0]);
}
else
{
  imagecopymerge($rd,$rd_ft2,0,$rdH-imagesy($rd_ft2),0,0,imagesx($rd_ft2),imagesy($rd_ft2),100);
}

$i = TEXT_START_Y;
$n = 0;
foreach($ip as $theme => $party)
{
 if($n>6) break;
 if(!$theme) continue;
 
 imagettftext($rd, FONT_SIZE, 0, THEME_START_X, $i, $cBl, $ftL, $theme);
 imagettftext($rd, FONT_SIZE, 0, PARTY_START_X, $i, $cBl, $ftB, $party);
 
 $i+= TEXT_SPACING_Y;
 $n++;
}

imagejpeg($rd);
imagedestroy($rd);
?> 