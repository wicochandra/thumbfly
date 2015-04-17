<?php

namespace ThumbFly;

use \Intervention\Image\Image;

class ThumbFly
{
    /**
     * Image
     * @var \Intervention\Image\Image;
     */
    protected $image;

    /**
     * Image option operation
     * @var array
     */
    protected $options;

    protected $validOperation = [
        'resize',
        'fit',
        'heighten',
        'widen',
        'greyscale',
        'crop'
    ];

    /**
     * Create object
     * @param \Intervention\Image\ImageManager $image
     * @param array       $options
     */
    public function __construct(Image $image, $options = [])
    {
        $this->image = $image;
        $this->options = $options;
    }

    public function render()
    {
        foreach ($this->options as $operation => $param) {
            if ($this->validOperation($operation)) {
                $this->processImage($operation, $param);
            }
        }
        return $this->image->response();
    }

    protected function processImage($operation, $param)
    {
        $param = explode(':', $param);
        switch ($operation) {
            case 'resize':
                if (count($param) < 2) break;
                $this->image->resize($param[0], $param[1]);
                break;
            case 'heighten':
                if (count($param) < 1) break;
                $this->image->heighten($param[0]);
                break;
            case 'widen':
                if (count($param) < 1) break;
                $this->image->widen($param[0]);
                break;
            case 'greyscale':
                $this->image->greyscale();
                break;
            case 'crop':
                if (count($param) < 2) break;
                if (count($param) < 4) {
                    $param[2] = null;
                    $param[3] = null;
                }
                $this->image->crop($param[0], $param[1], $param[2], $param[3]);
                break;
            case 'fit':
                if (count($param) < 2) break;
                if (!isset($param[2])) {
                    $param[2] = null;
                }
                $this->image->fit($param[0], $param[1], null, $param[2]);
                break;
        }
    }

    protected function validOperation($operation)
    {
        return in_array($operation, $this->validOperation);
    }

}
