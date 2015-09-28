<?php

class Image extends Media {

    public function save() {
        if ($this->isWritable()) {
            if ($this->isModified()) {
                $normalMaxWidth = 800;
                $normalMaxHeight = 600;
                $thumbnailMaxWidth = 120;
                $thumbnailMaxHeight = 120;

                if (isset($this->items[$this->pointer]['upload_file_name'])) {
                    $uploadFileName = $this->items[$this->pointer]['upload_file_name'];
                    $uploadFile = $_FILES[$uploadFileName]['name'];
                    $extension = strtolower(substr(strrchr($uploadFile, '.'), 1));

                    if (('jpg' == $extension) || ('jpeg' == $extension)) {
                        $fileName = $this->getFileName();
                        if (!$fileName) {

                            $idChars = 'bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ';
                            $idLength = rand(4, 9);
                            $fileNameId = '';
                            while (strlen($fileNameId) < $idLength) {
                                $fileNameId .= substr($idChars, rand(0, strlen($idChars) -1), 1);
                            }

                            $fileName = date('Y-m-d-His-') . $fileNameId . '.' . $extension;
                            $this->setFileName($fileName);
                        }
                        $originalDir = $this->getDirectory() . 'original/';
                        $normalDir = $this->getDirectory() . 'normal/';
                        $thumbnailDir = $this->getDirectory() . 'thumbnail/';
                        if (move_uploaded_file($_FILES[$uploadFileName]['tmp_name'], $originalDir . $fileName)) {
                            list($width, $height) = getimagesize($originalDir . $fileName);

                            // create "normal" sized image

                            if (($width <= $normalMaxWidth) && ($height <= $normalMaxHeight)) {
                                copy($originalDir . $fileName, $normalDir . $fileName);
                            } else {
                                $ratio = $width / $height;

                                if ($normalMaxWidth / $normalMaxHeight > $ratio) {
                                    $normalMaxWidth = $normalMaxHeight * $ratio;
                                } else {
                                    $normalMaxHeight = $normalMaxWidth / $ratio;
                                }

                                $image_p = imagecreatetruecolor($normalMaxWidth, $normalMaxHeight);
                                $image = imagecreatefromjpeg($originalDir . $fileName);
                                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $normalMaxWidth, $normalMaxHeight, $width, $height);
                                imagejpeg($image_p, $normalDir . $fileName);
                            }

                            // create "thumbnail" sized image

                            if (($width <= $thumbnailMaxWidth) && ($height <= $thumbnailMaxHeight)) {
                                copy($originalDir . $fileName, $thumbnailDir . $fileName);
                            } else {
                                $ratio = $width / $height;

                                if ($thumbnailMaxWidth / $thumbnailMaxHeight > $ratio) {
                                    $thumbnailMaxWidth = $thumbnailMaxHeight * $ratio;
                                } else {
                                    $thumbnailMaxHeight = $thumbnailMaxWidth / $ratio;
                                }

                                $image_p = imagecreatetruecolor($thumbnailMaxWidth, $thumbnailMaxHeight);
                                $image = imagecreatefromjpeg($originalDir . $fileName);
                                imagecopyresampled($image_p, $image, 0, 0, 0, 0, $thumbnailMaxWidth, $thumbnailMaxHeight, $width, $height);
                                imagejpeg($image_p, $thumbnailDir . $fileName);
                            }

                            // save to database

                            unset($this->items[$this->pointer]['upload_file_name']);
                            $this->items[$this->pointer]['original_file_name'] = $uploadFile;
                            return parent::save();
                        }
                    } else {
                        // not a jpg
                        return false;
                    }
                } else {
                    // upload id missing
                    return parent::save();
                }
            } else {
                // not modified
                return true;
            }
        } else {
            // not writeable
            return false;
        }
    }

    public function delete() {
        if (!$this->getDirectory() || !$this->getFileName()) {
            $this->read();
        }
        if ($this->getDirectory() && $this->getFileName()) {
            unlink($this->getDirectory() . 'original/' . $this->getFileName());
            unlink($this->getDirectory() . 'normal/' . $this->getFileName());
            unlink($this->getDirectory() . 'thumbnail/' . $this->getFileName());
        }
        return parent::delete();
    }

}

