<?php

namespace App\Manager;

class ImageManager
{

    public static function uploadBase64Image($file, $customPath = null)
    {
        $defaultPath = '';
        if ($customPath) {
            $defaultPath = $customPath;
        }

        $imgFile = self::getB64Image($file);
        $imgExtension = self::getB64Extension($file);
        $path = env('PATH_IMAGES') . $defaultPath . '/';
        $imgName = time() . rand() . '.' . $imgExtension;
        $finalName = $path . $imgName;

        self::file_force_contents($path, $imgName, $imgFile);

        return $finalName;
    }

    public static function getB64Image($base64_image)
    {
        $image_service_str = substr($base64_image, strpos($base64_image, ",") + 1);
        $image = base64_decode($image_service_str);

        return $image;
    }

    public static function getB64Extension($base64_image, $full = null)
    {
        preg_match("/^data:image\/(.*);base64/i", $base64_image, $img_extension);

        return ($full) ? $img_extension[0] : $img_extension[1];
    }

    public static function file_force_contents($path, $imgName, $imgFile)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($path . $imgName, $imgFile);
    }

}
