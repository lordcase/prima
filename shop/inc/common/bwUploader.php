<?php 

define('UPLOADER_MAX_FILESIZE', 30000);
define('UPLOADER_DEST_DIR', 'uploads/');


if(!defined("BW_APPLICATION"))
{
  die("Direct access to this internal component is forbidden.");
}

//require_once('inc/common/bwUploader.i18n.php');

class bwUploader extends bwComponent {

  var $fileId;
  var $maxFileSize;
  var $allowedFileTypes = array();
  var $forbiddenFileTypes = array();
  var $allowedExtensions = array();
  var $forbiddenExtensions = array();
  var $uploadDir;
  var $automaticNaming;
  var $destFileName;

  function bwUploader()
  {
    bwComponent::bwComponent();
    
    $this->SetFileId('fileupload');
    $this->SetMaxFileSize(UPLOADER_MAX_FILESIZE);
    $this->SetUploadDir(UPLOADER_DEST_DIR);
    $this->SetAutomaticNaming(true);
  }

  function SetFileId($id)
  {
    $this->fileId = $id;
  }
  
  function GetFileId()
  {
    return $this->fileId;
  }

  function SetAllowedFileTypes($values)
  {
    $this->allowedFileTypes = array();
    $this->AddAllowedFileTypes($values);
  }

  function AddAllowedFileTypes($values)
  {
    if(!is_array($values))
    {
      $values = explode(',', $values);
    }
    
    foreach($values as $value)
    {
      $this->allowedFileTypes[] = trim($value);
    }
  }

  function GetAllowedFileTypes()
  {
    return $this->allowedFileTypes();
  }


  function SetForbiddenFileTypes($values)
  {
    $this->forbiddenFileTypes = array();
    $this->AddForbiddenFileTypes($values);
  }

  function AddForbiddenFileTypes($values)
  {
    if(!is_array($values))
    {
      $values = explode(',', $values);
    }
    
    foreach($values as $value)
    {
      $this->forbiddenFileTypes[] = trim($value);
    }
  }

  function GetForbiddenFileTypes()
  {
    return $this->forbiddenFileTypes();
  }


  function SetAllowedExtensions($values)
  {
    $this->allowedExtensions = array();
    $this->AddAllowedExtensions($values);
  }

  function AddAllowedExtensions($values)
  {
    if(!is_array($values))
    {
      $values = explode(',', $values);
    }
    
    foreach($values as $value)
    {
      $this->allowedExtensions[] = trim($value);
    }
  }

  function GetAllowedExtensions()
  {
    return $this->allowedExtensions();
  }


  function SetForbiddenExtensions($values)
  {
    $this->forbiddenExtensions = array();
    $this->AddForbiddenExtensions($values);
  }

  function AddForbiddenExtensions($values)
  {
    if(!is_array($values))
    {
      $values = explode(',', $values);
    }
    
    foreach($values as $value)
    {
      $this->forbiddenExtensions[] = trim($value);
    }
  }

  function GetForbiddenExtensions()
  {
    return $this->forbiddenExtensions();
  }
  
  function SetAutomaticNaming($automatic = true)
  {
    $this->automaticNaming = $automatic;
  }
  
  function GetAutomaticNaming()
  {
    return $this->automaticNaming;
  }
  

  function IsUpload()
  // returns true, if there is an uploaded fie to be processed
  {
    return isset($_FILES[$this->fileId]);
  }
  
  function GetFileName()
  // returns the name attribute of the uploaded file
  {
    return $_FILES[$this->fileId]["name"];
  }
  
  function GetFileType()
  // returns the type attribute of the uploaded file
  {
    return $_FILES[$this->fileId]["type"];
  }
  
  function IsFileType($type)
  // returns true if the type attribute of the uploaded file is $type
  // $type can also be an array
  {
    if(is_array($type))
    {
      $return = in_array($this->GetFileType(), $type);
    }
    else
    {
      $return = ($this->GetFileType() == $type);
    }
    return $return;
  }
  
  function IsFileTypeAllowed()
  {
    if(count($this->allowedFileTypes) >= 1)
    {
      if($this->IsFileType($this->allowedFileTypes))
      {
        return true;
      }
      else
      {
// PROVIDE FEEDBACK!
        return false;
      }
    }
    else
    {
      return true;
    }
  }

  function IsFileTypeForbidden()
  {
    if(count($this->forbiddenFileTypes) >= 1)
    {
      if(!$this->IsFileType($this->forbiddenFileTypes))
      {
        return true;
      }
      else
      {
// PROVIDE FEEDBACK!
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  
  function IsFileTypeValid()
  {
    return ($this->IsFileTypeAllowed() && !$this->IsFileTypeForbidden());
  }
  
  function GetExtension()
  {
    $nameParts = explode(".", $this->GetFileName());
    $extension = $nameParts[count($nameParts) - 1];
    
    return $extension;
  }

  function IsExtension($extension)
  // returns true if the extension of the uploaded file is $extension
  // $extension can also be an array
  {
    if(is_array($extension))
    {
      $return = in_array($this->GetExtension(), $extension);
    }
    else
    {
      $return = ($this->GetExtension() == $extension);
    }
    return $return;
  }
  
  function IsExtensionAllowed()
  {
    if(count($this->allowedExtensions) >= 1)
    {
      if($this->IsExtension($this->allowedExtensions))
      {
        return true;
      }
      else
      {
// PROVIDE FEEDBACK!
        return false;
      }
    }
    else
    {
      return true;
    }
  }

  function IsExtensionForbidden()
  {
    if(count($this->forbiddenExtensions) >= 1)
    {
      if(!$this->IsExtension($this->forbiddenExtensions))
      {
        return true;
      }
      else
      {
// PROVIDE FEEDBACK!
        return false;
      }
    }
    else
    {
      return false;
    }
  }  

  function IsExtensionValid()
  {
    return ($this->IsExtensionAllowed() && !$this->IsExtensionForbidden());
  }
  

  function GetFileSize()
  // returns the size attribute of the uploaded file
  {
    return $_FILES[$this->fileId]["size"];
  }
  
  function IsFileSizeOk()
  // returns true if the size attribute of the uploaded file is less than or
  // equal to max size
  {
    return ($this->GetFileSize() <= $this->GetMaxFileSize());
  }
  
  function GetFileTempName()
  // returns the tmp_name attribute of the uploaded file
  {
    return $_FILES[$this->fileId]["tmp_name"];
  }
  
  function GetFileError()
  // returns the error attribute of the uploaded file
  {
    return $_FILES[$this->fileId]["error"];
  }
  
  function Validate()
  {
    return ($this->IsFileTypeValid() && $this->IsExtensionValid() && $this->IsFileSizeOk()); 
  }
  
  function SetUploadDir($dir)
  {
    if($dir{strlen($dir)-1} != '/')
    {
      $dir .= '/';
    }
  
    $this->uploadDir = $dir;
  }
  
  function GetUploadDir()
  {
    return $this->uploadDir;
  }
  
  function SetMaxFileSize($size)
  {
    $this->maxFileSize = $size;
  }

  function GetMaxFileSize()
  {
    return $this->maxFileSize;
  }  

  function SetDestFileName($name)
  {
    $this->destFileName = $name;
  }

  function GetDestFileName()
  {
    return $this->destFileName;
  }

  function GetDestName()
  // returns the actual filename on the server, that corresponds to a given
  // uploaded tiem
  // returned name includes file path. 
  {
    return ($this->GetUploadDir() . $this->GetDestFileName());
  }
  
  function GenerateDestFileName()
  {
    $this->SetDestFileName($this->GetFileName());
  }
  
  function FileExists()
  {
    return file_exists($this->GetDestName());
  }
  
  function Upload()
  // performs validation of the uploaded file, and moves it to its destination
  // on the server.
  // returns true if successful.
  {
    if($this->IsUpload() &&
       is_uploaded_file($this->GetFileTempName()) && 
       ($this->GetFileError() == UPLOAD_ERR_OK) &&
       $this->Validate()
      ) 
    {
      if($this->GetAutomaticNaming() == true)
      {
        $this->GenerateDestFileName();
      }
      if(move_uploaded_file($this->GetFileTempName(), $this->GetDestName()) &&
         $this->AfterUpload()
        )
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
  
  function AfterUpload()
  {
    return true;
  }

}

?>
