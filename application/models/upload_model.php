<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 22:55 น.
 * To change this template use File | Settings | File Templates.
 */
class Upload_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function uploadBase64($post)
    {
        if ($post) {
            //$data_image
            //$imageName
            //$fileType
            //$imagePatch

            extract($post);
            if (empty($data_image) || $data_image == "") {
                return "";
            }

            $data = $data_image;;

            $getFileType = explode(';', $data);
            $getFileType = $getFileType[0];
            $getFileType = explode('/', $getFileType);
            $getFileType = $getFileType[1];

            $fileName = @$imageName;
            if (!empty($fileName)) {
                $fileName = explode('\\', $fileName);
                $fileName = $fileName[count($fileName) - 1];
            } else {
                $fileName = ".$getFileType";
            }
            $fileName = str_replace(' ', '_', $fileName);
            $fileName = date("Ymd") . "-" . date('His') . "-$fileType-" . $fileName;
            if (!$this->checkCreateFolder(@$imagePatch))return false;
            $newName = "$imagePatch$fileName";

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = str_replace(" ", '+', $data);
            $data = base64_decode($data);

            $result = file_put_contents($newName, $data);
            if (!$result) {
                return false;
            }
            return $newName;
        }
        return false;
    }

    function convertImageName($data = null, $imageName = "", $imagePatch = "'uploads/", $fileType = "image")
    {

        if ($data) {
            //$data_image
            //$imageName
            //$fileType
            //$imagePatch

            $getFileType = explode(';', $data);
            $getFileType = $getFileType[0];
            $getFileType = explode('/', $getFileType);
            $getFileType = $getFileType[1];

            $fileName = @$imageName;
            if (!empty($fileName)) {
                $fileName = explode('\\', $fileName);
                $fileName = $fileName[count($fileName) - 1];
            } else {
                $fileName = ".$getFileType";
            }
            $fileName = str_replace(' ', '_', $fileName);
            $fileName = date("Ymd") . "-" . date('His') . "-$fileType-" . $fileName;
            if (!$this->checkCreateFolder(@$imagePatch))return false;
            $newName = "$imagePatch$fileName";

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = str_replace(" ", '+', $data);
            $data = base64_decode($data);

            $result = file_put_contents($newName, $data);
            if (!$result) {
                return false;
            }
            return $newName;
        }
        return false;
    }

    function checkCreateFolder($path)
    {

        if (!is_dir($path)) //create the folder if it's not already exists
        {
            $flgCreate = mkdir($path, 0777, true);
            if (!$flgCreate) {
                return "Create False";
            }
        }
        return true;
    }

    function createFolder($path)
    {
        $folderName = date("Y-m-d");
        $pathFolder = "$path/$folderName";
        if (!$this->checkCreateFolder($pathFolder))
            return false;
        $this->pathUpload = $pathFolder;
        return $folderName;
    }

    var $image;
    var $image_type;

    function loadImage($filename)
    {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    function getWidth()
    {
        return imagesx($this->image);
    }

    function getHeight()
    {
        return imagesy($this->image);
    }

    function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    function scale($scale)
    {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled(
            $new_image,
            $this->image,
            0,
            0,
            0,
            0,
            $width,
            $height,
            $this->getWidth($this->image),
            $this->getHeight($this->image));
        $this->image = $new_image;
    }

    function deleteFile($path)
    {
        return unlink($path);
    }
}