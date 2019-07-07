<?php


namespace app\models;


use function explode;
use Imagick;
use function is_dir;
use function mkdir;
use yii\web\UploadedFile;

class ThumbGenerator extends UploadedFile
{
    private $ds = DIRECTORY_SEPARATOR;
    public $sizes = [
        'full' => '800x600',
        'medium' => '360x270',
        'small' => '120x90',
        ];

    public function saveAs($file, $deleteTempFile = true)
    {
        $result = false;

        if (!exif_imagetype($this->tempName)) {
            return false;
        }

        $pathParts = pathinfo($file);
        $imagick = new Imagick($this->tempName);

        foreach ($this->sizes as $sizes) {
            list($width, $height) = explode('x', $sizes);
            $imagick->resizeImage($width, $height, imagick::FILTER_LANCZOS, 1, true);
            $imagick->setSamplingFactors(array('4', '2', '0'));
            $imagick->stripImage();
            $imagick->setImageCompressionQuality(85);
            $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
            $imagick->transformImageColorspace(Imagick::COLORSPACE_SRGB);
            $imagick->setImageFormat("jpeg");
            $thumbDir = $pathParts['dirname'] . $this->ds . $sizes;
            if (!is_dir($thumbDir)) {
                mkdir($thumbDir);
            }
            $result = $result && $imagick->writeImage($thumbDir.$this->ds.$this->baseName.'jpg');
        }

        return $result;
    }
}