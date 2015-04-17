<?php
error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__.'/../vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
use ThumbFly\ThumbFly;

Image::configure(array('driver' => 'gd'));

$option = $_GET;
$imagePath = $_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'];

$thumb = new ThumbFly(Image::make($imagePath), $option);
echo $thumb->render();
