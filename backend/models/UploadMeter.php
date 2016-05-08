<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\helpers\Html;

class UploadMeter extends \yii\base\Model
{

  public $fileupload;
  public $filename;


  /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fileupload'], 'file', 'extensions' => 'xls, xlsx, csv'],
        ];
    }

    public function getPathFile()
    {
      return isset($this->filename) ? Yii::$app->params['uploadPath'] : null;
      
    }
    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getFileUpload()
    {
        return isset($this->filename) ? $this->pathFile . 'meter/' . $this->filename : null;
    }

    /**
     * Process upload of fileupload
     *
     * @return mixed the uploaded fileupload instance
     */
    public function uploadFile()
    {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use getInstance method)
        $fileupload = UploadedFile::getInstanceByName('fileupload');

        //var_dump($fileupload);die();

        // if no fileupload was uploaded abort the upload
        if(empty($fileupload)) {
            return false;
        }

        // store the source file name
        $this->fileupload = $fileupload->name;
        
        $ext = end((explode(".", $fileupload->name)));

        // generate a unique file name
        $this->filename = date('U').'-'.Yii::$app->security->generateRandomString().".{$ext}";
        
        return $fileupload;
    }

    public function getTypeFile()
    {
      //application/vnd.ms-excel
    }

    /**
     * Process deletion of fileupload
     *
     * @return boolean the status of deletion
     */
    public function deleteFileupload()
    {
        $file = $this->getFileUpload();

        // check if file exists on server
        if(empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if(!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        //$this->avatar = null;
        //$this->filename = null;

        return true;
    }

}