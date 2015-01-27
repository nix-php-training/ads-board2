<?php

/**
 * Class AdvertisementImages
 *
 * Provides functions for works with advertisement image:
 * - retrieve and create rows at table `advertisementImages`;
 * - create link to image's host;
 * - change image size (crop).
 */
class AdvertisementImages extends Model
{
    /**
     * Table name by default
     *
     * @var string
     */
    protected $table = 'advertisementsImages';

    /**
     * Save image name into database
     *
     * @param $data
     */
    public function saveAdsImages($data)
    {
        $this->db->insert($this->table, $data);
    }

    /**
     * Crop image for preview
     *
     * @param $filename
     */
    function makeThumb($filename)
    {
        $image = new Imagick($filename);

        $temp = explode('/', $filename);
        $imageName = 'preview/thumb_' . end($temp);
        $key = key($temp);
        reset($temp);

        $temp[$key] = $imageName;
        $newFileName = implode('/', $temp);

        $image->cropThumbnailImage(150, 150);

        $image->writeImage($newFileName);
        $image->destroy();


    }

    /**
     * Attach images with previews to advertisement list
     *
     * @param $advertisementList Array -- linked parameter
     * @throws DatabaseErrorException
     */
    public function attachImagesToAdsList(&$advertisementList)
    {
        // attach images to list
        foreach ($advertisementList as &$advertisement) {

            // memorize unconverted date for work with js
            $advertisement['unconvertedDate'] = $advertisement['creationDate'];
            $convertedDate = strtotime($advertisement['creationDate']);
            $advertisement['creationDate'] = $convertedDate;

            //get images from DB
            $imagesArray = $this->getImagesByAdsId($advertisement['id']);

            if (!is_null($imagesArray) && !empty($imagesArray)) {
                $advertisement['images'] = $this->createImagePath($imagesArray);
                $advertisement['imagesPreview'] = $this->createPreviewImagePath($imagesArray);
            } else {
                $advertisement['images'] = [];
                $advertisement['imagesPreview'] = [];
            }
        }
    }

    /**
     * Retrieve image from db by id
     *
     * @param $id
     * @return Array
     * @throws DatabaseErrorException
     */
    public function getImagesByAdsId($id)
    {
        try {
            return $this->db->query('select id, imageName from ' . $this->table . '
            WHERE advertisementId=' . $id)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseErrorException();
        }
    }

    /**
     * Create link for origin image
     *
     * @uses AdvertisementImages to create link for image preview
     * @param $images
     * @return Array
     */
    public function createImagePath($images)
    {
        $path = Config::get('site');
        $explodeArr = explode('_', $images[0]['imageName']);
        $userId = $explodeArr[1];
        $adsId = $explodeArr[2];
        foreach ($images as &$image) {
            $imageTemp = $path['imageLink'] . $userId . '/' . $adsId . '/' . $image['imageName'];
            $image['imageName'] = $imageTemp;
        }
        return $images;
    }

    /**
     * Create link for image preview
     *
     * @uses AdvertisementImages to create link for image preview
     * @param $images
     * @return Array
     */
    public function createPreviewImagePath($images)
    {
        $path = Config::get('site');
        $userId = explode('_', $images[0]['imageName'])[1];
        $adsId = explode('_', $images[0]['imageName'])[2];
        foreach ($images as &$image) {
            $imageTemp = $path['imageLink'] . $userId . '/' . $adsId . '/preview/thumb_' . $image['imageName'];
            $image['imageName'] = $imageTemp;
        }
        return $images;
    }

}