<?php


namespace app\models;


use function array_diff;
use function explode;
use Imagick;
use function is_dir;
use function mkdir;
use function scandir;

class ThumbGenerator
{
    const SIZES = [
        'full' => '800x600',
        'medium' => '360x270',
        'small' => '120x90',
    ];
    const DS = DIRECTORY_SEPARATOR;

    public static function getSizeDir($sizeName){
        return self::SIZES[$sizeName];
    }

    public static function generate($file, $shopId)
    {
        $result = false;

        $pathParts = pathinfo($file);
        $imagick = new \Imagick($file);

        foreach (self::SIZES as $sizeName => $sizes) {
            $thumbDir = $pathParts['dirname']
                . self::DS . $shopId
                . self::DS . $sizes;

            if (!is_dir($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }

            list($width, $height) = explode('x', $sizes);
            // уменьшаем и ужимаем картинку, оптимизируем для быстрой загрузки
            $imagick->resizeImage($width, $height, imagick::FILTER_LANCZOS, 1, false);
            $imagick->stripImage();
            $imagick->setImageCompressionQuality(85);
            $imagick->setInterlaceScheme(Imagick::INTERLACE_JPEG);
            $imagick->transformImageColorspace(Imagick::COLORSPACE_SRGB);
            $imagick->setImageFormat("jpeg");

            /**
             * Это нужно для сохранения совместимости с текущим способом хранения картинок
             * Чтобы сжать основную картинку.
             */
            if ($sizeName === 'full') {
                $imagick->writeImage($file);
            }

            $result = $imagick->writeImage($thumbDir.self::DS.$pathParts['basename']);
        }

        return $result;
    }

    public static function getGallery($id, $path = 'img/shopPhoto') {
        if (!is_dir($path.self::DS.$id)) {
            return false;
        }

        $result = [];
        foreach (self::SIZES as $sizeName => $sizes) {
            $sizePath = $id . self::DS . $sizes;
            $files = array_diff(scandir($path . self::DS . $sizePath, 1), array('..', '.'));

            foreach ($files as $file) {
                $result[$sizeName][] = $sizePath . self::DS . $file;
            }
        }

        return $result;
    }

    public static function regenerateShopPhotos() {
        $result = false;

        $photos = ShopPhoto::find()->asArray();
        foreach ($photos as $photo) {
            self::generate('img/shopPhoto/'.$photo['shopPhoto'], $photo['shopId']);
        }

        return $result;
    }
}