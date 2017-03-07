<?php
$parties = array(
  1 => "VVD",
    "PvdA",
    "PVV",
    "SP",
    "CDA",
    "D66",
    "ChristenUnie",
    "GroenLinks",
    "SGP",
    "Partij voor de Dieren",
    "50PLUS",
    "OndernemersPartij",
    "VNL",
    "DENK",
    "Nieuwe Wegen",
    "Forum voor Democratie",
    "De Burger Beweging",
    "Vrijzinnige Partij",
  20 => "Piratenpartij",
    "Artikel 1",
    "Niet Stemmers",
    "LP",
    "Lokaal in de Kamer",
    "JEZUS LEEFT",
    "StemNL",
    "MenS en Spirit",
    "VDP");

$themes = array(
  "Binnenlandse Zaken",
  "Buitenlandse Zaken",
  "Cultuur",
  "Defensie",
  "Economische Zaken",
  "Europese Unie",
  "Financiën",
  "Infrastructuur",
  "Migratie",
  "Milieu",
  "Onderwijs",
  "Sociale Zaken",
  "Sport",
  "Veiligheid",
  "Zorg");
  
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

?>