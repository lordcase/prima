<?php 

if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

//require_once('inc/common/bwImageUploader.i18n.php');

class bwImageUploader extends bwUploader {

  var $automaticResize;
  var $maxImageSize;
  var $resizedQuality;
  var $automaticThumbnails;
  var $thumbnailSize;
  var $thumbnailQuality;
  var $thumbnailName;

  function bwImageUploader()
  {
    bwUploader::bwUploader();
    $this->AllowJPEG();
    $this->SetAutomaticResize(false);
    $this->SetAutomaticThumbnails(true);
    $this->SetThumbnailSize(150);
    $this->SetThumbnailQuality(75);
    $this->SetResizedQuality(75);
  }    

  function SetAutomaticResize($automatic = true)
  {
    $this->automaticResize = $automatic;
  }
  
  function GetAutomaticResize()
  {
    return $this->automaticResize;
  }
  
  function SetMaxImageSize($size)
  {
    $this->maxImageSize = $size;
  }
  
  function GetMaxImageSize()
  {
    return $this->maxImageSize;
  }

  function SetResizedQuality($quality)
  {
    $this->resizedQuality = $quality;
  }
  
  function GetResizedQuality()
  {
    return $this->resizedQuality;
  }

  function SetAutomaticThumbnails($automatic = true)
  {
    $this->automaticThumbnails = $automatic;
  }
  
  function GetAutomaticThumbnails()
  {
    return $this->automaticThumbnails;
  }
  
  function SetThumbnailSize($size)
  {
    $this->thumbnailSize = $size;
  }
  
  function GetThumbnailSize()
  {
    return $this->thumbnailSize;
  }

  function SetThumbnailQuality($quality)
  {
    $this->thumbnailQuality = $quality;
  }
  
  function GetThumbnailQuality()
  {
    return $this->thumbnailQuality;
  }

  function SetThumbnailName($name)
  {
    $this->thumbnailName = $name;
  }

  function GetThumbnailName()
  {
    return $this->thumbnailName;
  }

  function GenerateDestFileName()
  {
    bwUploader::GenerateDestFileName();
    $this->SetThumbnailName('tn_' . $this->GetFileName());
  }

  function AllowJPEG()
  {
    $this->AddAllowedFileTypes('image/jpeg, image/pjpeg');
    $this->AddAllowedExtensions('jpg, jpeg, JPG, JPEG');
  }
  
  function AllowPNG()
  {
    //dummy
  }

  function AllowGIF()
  {
    //dummy
  }

  function AfterUpload()
  {
    if($this->GetAutomaticResize() == true)
    {
      $this->ResizeImage($this->GetDestName(), $this->GetDestName(), $this->GetMaxImageSize(), $this->GetResizedQuality());
    }  
    if($this->GetAutomaticThumbnails() == true)
    {
      $this->ResizeImage($this->GetDestName(), $this->GetUploadDir() . $this->GetThumbnailName(), $this->GetThumbnailSize(), $this->GetThumbnailQuality());
    }  
  }

  function ResizeImage($source, $destination, $maxSize, $imageQuality)
  {
    $size = GetImageSize($source);
    $aspectRatio = $size [0] / $size[1];
    if(($size[0] > $maxSize) || ($size[0] > $maxSize))
    {
      if($size[0] >= $size[1])
      {
        $newSize0 = $maxSize;
        $newSize1 = intval($maxSize / $aspectRatio);
      }
      else
      {
        $newSize1 = $maxSize;
        $newSize0 = intval($maxSize * $aspectRatio);
      }
    }
    else
    {
      $newSize0 = $size[0];
      $newSize1 = $size[1];
    }
    
    $imageOriginal = imagecreatefromjpeg($source);
    $imageResized = imagecreatetruecolor($newSize0,$newSize1);
    
    imagecopyresampled($imageResized, $imageOriginal, 0, 0, 0, 0, $newSize0, $newSize1, $size[0], $size[1]);

    imagejpeg($imageResized, $destination, $imageQuality);
    
    imagedestroy($imageOriginal);
    imagedestroy($imageResized);
    
  }

}

?>
