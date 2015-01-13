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

    public function getImagesByAdsId($id)
    {
        try {
            return $this->db->query('select imageName from ' . $this->table . '
            WHERE advertisementId=' . $id)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseErrorException();
        }
    }

    public function createImagePath($images, $userId, $adsId)
    {
        $path = Config::get('site');
        foreach ($images as &$image)
        {
            $imageTemp = $path['imagePath'].$userId.'/'.$adsId.'/'.$image['imageName'];
            $image['imageName'] = $imageTemp;
        }
        return $images;
    }

    public function createPreviewImagePath($images, $userId, $adsId)
    {
        $path = Config::get('site');
        foreach ($images as &$image)
        {
            $imageTemp = $path['imagePath'].$userId.'/'.$adsId.'/preview/thumb_'.$image['imageName'];
            $image['imageName'] = $imageTemp;
        }
        return $images;

    }

}