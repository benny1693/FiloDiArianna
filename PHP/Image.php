<?php
/**
 * Created by PhpStorm.
 * User: pincohackerino
 * Date: 03/01/19
 * Time: 12.20
 */

class Image
{
    private $source;

    public function __construct($source) {
        $this->source = $source;
    }

    //anteprima dell'immagine
    public function generateThumbnail() {

    }

    public function getSource() {
        return $source;
    }

}
