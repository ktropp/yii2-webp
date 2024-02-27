<?php

namespace ktropp\yii2webp;

use Yii;
use WebPConvert\WebPConvert;

class Webp
{
    private static function createWebp($source, $destination)
    {
        WebPConvert::Convert($source, $destination, []);
    }

    /*
     * Get Webp path from original img file
     */
    private static function getWebpPath($img)
    {
        $fileInfo = pathinfo($img);

        return $fileInfo['dirname'] . '/' . $fileInfo['filename'] . '.webp';
    }

    /*
     * Get path to webp file
     * @param string $img
     */
    public static function get($img)
    {
        $imgFullPath = Yii::getAlias('@webroot') . $img;
        $webpFilePath = static::getWebpPath($imgFullPath);
        $webpFileUrl = static::getWebpPath($img);

        if (!is_file($imgFullPath))
            return false;

        if(file_exists($webpFilePath))
            return (filesize($webpFilePath) < filesize($imgFullPath) ? $webpFileUrl : false);

        static::createWebp($imgFullPath, $webpFilePath);

        return $webpFileUrl;
    }
}