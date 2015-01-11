<?php

class AdvertisementImages extends Model
{
    protected $table = 'advertisementsImages';

    public function saveAdsImages($adsId)
    {
       // $this->db->insert($this->table, $data);
    }

    function makeThumb( $filename, $type ) {
        global $max_width, $max_height;
        if ( $type == 'jpg' ) {
            $src = imagecreatefromjpeg($filename);
        } else {
            $src = imagecreatefrompng($filename);
        }
        if ( ($oldW = imagesx($src)) < ($oldH = imagesy($src)) ) {
            $newW = $oldW * ($max_width / $oldH);
            $newH = $max_height;
        } else {
            $newW = $max_width;
            $newH = $oldH * ($max_height / $oldW);
        }
        $new = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($new, $src, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);
        $temp = explode('/',$filename);
        $imageName = 'thumb_'.end($temp);
        array_push(end($temp),$imageName);
        $newFileName = implode('/',$temp);


        if ( $type == 'jpg' ) {
            imagejpeg($new, $newFileName);
        } else {
            imagepng($new, $newFileName);
        }
        imagedestroy($new);
        imagedestroy($src);
    }
}