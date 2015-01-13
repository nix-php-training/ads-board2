<?php

class AdvertisementImages extends Model
{
    protected $table = 'advertisementsImages';

    public function saveAdsImages($data)
    {
        $this->db->insert($this->table, $data);
    }

    function makeThumb($filename)
    {
        $image = new Imagick($filename);

        $temp = explode('/', $filename);
        $imageName = 'preview/thumb_' . end($temp);
        $key = key($temp);
        reset($temp);
//
        $temp[$key] = $imageName;
        $newFileName = implode('/', $temp);

        $image->cropThumbnailImage(150, 150);

        $image->writeImage($newFileName);
        $image->destroy();


    }
}