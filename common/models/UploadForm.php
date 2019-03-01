<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $images;

    public function rules()
    {
        return [
            [['images'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->images as $file) {
                $file->saveAs('image/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        }

        return false;
    }
}