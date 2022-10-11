<?php

namespace HashMachine;

class ImageHandler
{
    protected $image;
    protected $handledImage;

    public function __construct()
    {
        return $this;
    }

    public function handle($originalImage): ImageHandler
    {
        $this->setImage($originalImage);
        //$this->translateImage();
        $this->resizeImage();


        return $this;
    }

    protected function setImage($originalImage)
    {
        $this->image = $originalImage;
        $this->handledImage = $originalImage;
    }

    public function getImage()
    {
        return $this->handledImage;
    }

    protected function resizeImage()
    {
        $this->handledImage = imagescale($this->image,32,32);
    }

    protected function translateImage()
    {
        if(imagefilter($this->image, IMG_FILTER_GRAYSCALE))
        {
            $this->handledImage = $this->image;
        }

    }
}