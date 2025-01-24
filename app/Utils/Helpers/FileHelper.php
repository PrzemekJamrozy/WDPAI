<?php

namespace Utils\Helpers;

class FileHelper
{

    const UPLOAD_PATH = 'uploads';
    const AVATAR_DIR = 'avatars';
    const IMAGE_ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif'];

    public static function uploadAvatar(array $file): string|false
    {
        $fileTmpName = $file['tmp_name'];

        if (!in_array($file['type'], self::IMAGE_ALLOWED_TYPES)) {
            return false;
        }

        $imageType = explode('.',$file['name'])[count(explode('.',$file['name'])) - 1];
        $destinationDir = self::UPLOAD_PATH . DIRECTORY_SEPARATOR . self::AVATAR_DIR . DIRECTORY_SEPARATOR;
        $newFileName = uniqid() . '.' . $imageType;
        $filePath = $destinationDir . $newFileName;
        if (move_uploaded_file($fileTmpName, $filePath)) {
            return $filePath;
        }
        return false;
    }
}