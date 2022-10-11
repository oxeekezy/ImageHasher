<?php

use HashMachine\ImageHandler;
use HashMachine\HashHandler;
include 'vendor/autoload.php';

$image = imagecreatefromjpeg('testimage1.jpg');

$handler = new ImageHandler();

$res = $handler->handle($image)->getImage();


//header('Content-Type: image/jpeg');
//imagejpeg($res);

$hashHandler = new HashHandler();
$hash1 = $hashHandler->handle($res)->getHash();

//$hashGenerator = new hash_generator();
//$hash2 = $hashGenerator->hash($image);


var_dump($hash1);
//var_dump($hash2);




//class hash_generator{
//    private function dct1d($pixels){
//        $transformed = [];
//        $size = count($pixels);
//
//        for ($i = 0; $i < $size; $i++) {
//            $sum = 0;
//            for ($j = 0; $j < $size; $j++) {
//                $sum += $pixels[$j] * cos($i * pi() * ($j + 0.5) / ($size));
//            }
//
//            $sum *= sqrt(2 / $size);
//
//            if ($i == 0) {
//                $sum *= 1 / sqrt(2);
//            }
//
//            $transformed[$i] = $sum;
//        }
//        return $transformed;
//    }
//
//    private function median($pixels){
//        sort($pixels, SORT_NUMERIC);
//        $middle = floor(count($pixels) / 2);
//
//        if (count($pixels) % 2) {
//            $median = $pixels[$middle];
//        } else {
//            $low = $pixels[$middle];
//            $high = $pixels[$middle + 1];
//            $median = ($low + $high) / 2;
//        }
//
//        return $median;
//    }
//
//    function hash($resource,$size=64){
//        // Resize the image.
//        $resized = imagecreatetruecolor($size,$size);
//        imagecopyresampled($resized,$resource,0,0,0,0,$size,$size,imagesx($resource),imagesy($resource));
//
//        // Get luma value (YCbCr) from RGB colors and calculate the DCT for each row.
//        $matrix = [];
//        $row = [];
//        $rows = [];
//        $col = [];
//        for ($y = 0;$y<$size;$y++){
//            for ($x = 0;$x<$size;$x++){
//                $rgb = imagecolorsforindex($resized, imagecolorat($resized, $x, $y));
//                $row[$x] = floor(($rgb['red'] * 0.299) + ($rgb['green'] * 0.587) + ($rgb['blue'] * 0.114));
//            }
//            $rows[$y] = $this->dct1d($row);
//        }
//
//        // Free up memory.
//        imagedestroy($resized);
//
//        // Calculate the DCT for each column.
//        for ($x = 0; $x <$size; $x++) {
//            for ($y = 0; $y <$size; $y++) {
//                $col[$y] = $rows[$y][$x];
//            }
//            $matrix[$x] = $this->dct1d($col);
//        }
//
//        // Extract the top 8x8 pixels.
//        $pixels = [];
//        for ($y = 0; $y < 8; $y++) {
//            for ($x = 0; $x < 8; $x++) {
//                $pixels[] = $matrix[$y][$x];
//            }
//        }
//
//        // Calculate the median.
//        $median = $this->median($pixels);
//
//        // Calculate hash.
//        $hash = 0;
//        $one = 1;
//        foreach ($pixels as $pixel) {
//            if ($pixel > $median) {
//                $hash |= $one;
//            }
//            $one = $one << 1;
//        }
//
//        return dechex($hash);
//    }
//}
