<?php

class AdvertisementImages extends Model
{
    protected $table = 'advertisementsImages';

    public function saveAdsImages($adsId)
    {
        // $this->db->insert($this->table, $data);
    }

    function makeThumb($filename)
    {
        $image = new Imagick($filename);
        $width  = $image->getImageWidth();
        $height = $image->getImageHeight();
        $thumb_width = min($width, $height);

        var_dump($thumb_width);
        $temp = explode('/', $filename);
        var_dump($temp);
        $imageName = 'thumb_' . end($temp);
        var_dump($imageName);

        $key = key($temp);
        reset($temp);

        $temp[$key] = $imageName;
        $newFileName = implode('/', $temp);
        var_dump($newFileName);

        $image->thumbnailImage(150, 150);
        $image->writeImage($newFileName);
        $image->destroy();



    }
}