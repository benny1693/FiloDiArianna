<?php
/**
 * Created by PhpStorm.
 * User: pincohackerino
 * Date: 03/01/19
 * Time: 12.20
 */

class Image
{
	private $source = null;

    public function __construct($source) {
        $this->source = $source;
    }

const IMAGE_HANDLERS = [
    IMAGETYPE_JPEG => [
        'load' => 'imagecreatefromjpeg',
        'save' => 'imagejpeg',
        'quality' => 100
    ],
    IMAGETYPE_PNG => [
        'load' => 'imagecreatefrompng',
        'save' => 'imagepng',
        'quality' => 0
    ],
    IMAGETYPE_GIF => [
        'load' => 'imagecreatefromgif',
        'save' => 'imagegif'
    ]
];


    //anteprima dell'immagine
    public function generateThumbnail($src, $dest, $targetWidth, $targetHeight = null) {

            // 1. Load the image from the given $src

            // get the type of the image
            // we need the type to determine the correct loader
            $type = exif_imagetype($src);

            // if no valid type or no handler found -> exit
            if (!$type || !IMAGE_HANDLERS[$type]) {
                return null;
            }

            // load the image with the correct loader
            $image = call_user_func(IMAGE_HANDLERS[$type]['load'], $src);

            // no image found at supplied location -> exit
            if (!$image) {
                return null;
            }


            // 2. Create a thumbnail and resize the loaded $image

            // get original image width and height
            $width = imagesx($image);
            $height = imagesy($image);

            // maintain aspect ratio when no height set
            if ($targetHeight == null) {

                // get width to height ratio
                $ratio = $width / $height;

                // if is portrait
                // use ratio to scale height to fit in square
                if ($width > $height) {
                    $targetHeight = floor($targetWidth / $ratio);
                }
                // if is landscape
                // use ratio to scale width to fit in square
                else {
                    $targetHeight = $targetWidth;
                    $targetWidth = floor($targetWidth * $ratio);
                }
            }

            // create duplicate image based on calculated target size
            $thumbnail = imagecreatetruecolor($targetWidth, $targetHeight);

            // set transparency options for GIFs and PNGs
            if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_PNG) {

                // make image transparent
                imagecolortransparent(
                    $thumbnail,
                    imagecolorallocate($thumbnail, 0, 0, 0)
                );

                // additional settings for PNGs
                if ($type == IMAGETYPE_PNG) {
                    imagealphablending($thumbnail, false);
                    imagesavealpha($thumbnail, true);
                }
            }

            // copy entire source image to duplicate image and resize
            imagecopyresampled(
                $thumbnail,
                $image,
                0, 0, 0, 0,
                $targetWidth, $targetHeight,
                $width, $height
            );


            // 3. Save the $thumbnail t

            // save the duplicate version of the image to disk
            return call_user_func(
                IMAGE_HANDLERS[$type]['save'],
                $thumbnail,
                $dest,
                IMAGE_HANDLERS[$type]['quality']
            );

    }

    public function getSource() {
        return $this->source;
    }
}
