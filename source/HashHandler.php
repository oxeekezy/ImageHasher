<?php

namespace HashMachine;

class HashHandler
{
    protected $image;
    protected int $hash;
    protected array $disretePixels;
    protected array $extractedPixels;

    public function __construct()
    {
        return $this;
    }

    public function handle($image): HashHandler
    {
        $this->clearHash();
        $this->setImage($image);
        $this->getDiscreteValues();
        $this->extractPixels();
        $this->createHash();

        return $this;
    }

    public function getHash(): string
    {
        return dechex($this->hash);
    }

    protected function setImage($image)
    {
        $this->image = $image;
    }

    protected function clearHash()
    {
        $this->hash = 0;
        $this->disretePixels = [];
        $this->extractedPixels = [];
    }

    protected function discreteRow($pixelsRow): array
    {
        $transformed = [];
        $size = count($pixelsRow);

        for ($i = 0; $i < $size; $i++)
        {
            $sum = 0;
            for ($j = 0; $j < $size; $j++) {
                $sum += $pixelsRow[$j] * cos($i * pi() * ($j + 0.5) / ($size));
            }

            $sum *= sqrt(2 / $size);

            $transformed[$i] = $sum;
        }

        return $transformed;
    }

    protected function getMiddlePixel($pixelsRow)
    {
        sort($pixelsRow, SORT_NUMERIC);
        $middle = floor(count($pixelsRow)/2);

        return $pixelsRow[$middle];
    }

    protected function getDiscreteValues()
    {
        $size = imagesx($this->image);
        $matrix = [];
        $row = [];
        $rows = [];
        $col = [];
        for ($y = 0;$y<$size;$y++)
        {
            for ($x = 0;$x<$size;$x++){
                $rgb = imagecolorsforindex($this->image, imagecolorat($this->image, $x, $y));
                $row[$x] = floor(($rgb['red'] * 0.299) + ($rgb['green'] * 0.587) + ($rgb['blue'] * 0.114));
            }
            $rows[$y] = $this->discreteRow($row);
        }

        for ($x = 0; $x <$size; $x++) {
            for ($y = 0; $y <$size; $y++) {
                $col[$y] = $rows[$y][$x];
            }
            $matrix[$x] = $this->discreteRow($col);
        }

        $this->disretePixels = $matrix;
    }

    protected function extractPixels()
    {
        $pixels = [];
        for ($y = 0; $y < 8; $y++) {
            for ($x = 0; $x < 8; $x++) {
                $pixels[] = $this->disretePixels[$y][$x];
            }
        }

        $this->extractedPixels = $pixels;
    }

    protected function createHash()
    {
        $middle = $this->getMiddlePixel($this->extractedPixels);

        $one = 1;
        foreach ($this->extractedPixels as $pixel) {
            if ($pixel > $middle)
            {
                $this->hash |= $one;
            }
            $one = $one << 1;
        }
    }
}