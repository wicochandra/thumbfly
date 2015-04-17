<?php

namespace ThumbFly;

use Illuminate\Contracts\Cache\Store;
use Intervention\Image\ImageManager;

class ThumbFlyManager
{
    protected $imageManager;

    protected $cache;

    protected $thumbFly;

    protected $cacheName;

    public function __construct(ImageManager $imageManager, Store $cache, $driver = 'gd')
    {
        $this->imageManager = $imageManager;
        $this->cache = $cache;

        $this->imageManager->configure(['driver' => $driver]);
    }

    public function make($file, $options)
    {
        $image = $this->imageManager->make($file);
        $this->thumbFly = new ThumbFly($image, $options);
        $this->cacheName = $image->basePath().implode(',', $options);
        return $this;
    }

    public function getThumbFly()
    {
        return $this->thumbFly;
    }

    public function render()
    {
        $cached = $this->cache->get($this->cacheName);
        if (is_null($cached) || !is_array($cached)) {
            $cached = [$this->thumbFly->render(), gmdate('D, d M Y H:i:s T', time())];
            $this->cache->put($this->cacheName, $cached , 60);
        }
        if (is_string($cached[0])) {
            header('Content-Type: ' . finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $cached[0]));
            header('Content-Length: ' . strlen($cached[0]));
            header('Last-Modified: ' . $cached[1]);
        }
        return $cached[0];
    }
}
