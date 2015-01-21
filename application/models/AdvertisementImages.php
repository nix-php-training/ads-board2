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
            return $this->db->query('select id, imageName from ' . $this->table . '
            WHERE advertisementId=' . $id)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseErrorException();
        }
    }

    public function createImagePath($images)
    {
        $path = Config::get('site');
        $userId = explode('_', $images[0]['imageName'])[1];
        $adsId = explode('_', $images[0]['imageName'])[2];
        foreach ($images as &$image)
        {
            $imageTemp = $path['imageLink'].$userId.'/'.$adsId.'/'.$image['imageName'];
            $image['imageName'] = $imageTemp;
        }
        return $images;
    }

    public function createPreviewImagePath($images)
    {
        $path = Config::get('site');

        $userId = explode('_', $images[0]['imageName'])[1];
        $adsId = explode('_', $images[0]['imageName'])[2];
        foreach ($images as &$image)
        {
            $imageTemp = $path['imageLink'].$userId.'/'.$adsId.'/preview/thumb_'.$image['imageName'];
            $image['imageName'] = $imageTemp;
        }
        return $images;

    }

}