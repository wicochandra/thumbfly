<?php
require_once __DIR__.'/../vendor/autoload.php';

use Intervention\Image\ImageManager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Cache\FileStore;
use ThumbFly\ThumbFlyManager;

$option = $_GET;
$imagePath = $_SERVER['HTTP_X_REALPATH'];
$manager = new ThumbFlyManager(new ImageManager, new FileStore(new Filesystem, $cachePath), 'gd');
echo $manager->make($imagePath, $option)->render();
