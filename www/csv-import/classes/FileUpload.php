<?php

class FileUpload
{
    public function upload($companyName, $date, $fileName, $fileSize, $fileTmpName, $fileType)
    {
        $this->companyName = $companyName;
        $this->date = $date;
        $this->fileName = $fileName;
        $this->fileSize = $fileSize;
        $this->fileTmpName = $fileTmpName;
        $this->fileType = $fileType;
    }
}
