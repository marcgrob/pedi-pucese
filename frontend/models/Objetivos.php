<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
/**
 * This is the model class for table "objetivos".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $responsables
 * @property string $fecha_inicio
 * @property string $fecha_fin
 * @property string $evidencias
 *
 * @property Estrategias[] $estrategias
 */
class Objetivos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $evidencias;
    public static function tableName()
    {
        return 'objetivos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion', 'responsables', 'fecha_inicio', 'fecha_fin', 'evidencias'], 'required'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['descripcion'], 'string', 'max' => 500],
            [['responsables'], 'string', 'max' => 100],
            [['evidencias'], 'file', 'extensions' => 'pdf'],
            //[['evidencias'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'responsables' => 'Responsables',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
            'evidencias' => 'Evidencias',
        ];
    }
  //  -----> CREAR REGLAS DE VALIDACIONES PARA FECHAS    
    public function verifDate($attribute){
        $time = new \DateTime('now', new \DateTimeZone('America/Guayaquil'));
        $currentDate = $time->format('Y-m-d h:m:s');
        
        if($this->$attribute <=  $currentDate ){
            $this->addError($attribute, 'No puede ser menor a la fecha actual');
        }
        
    }
    
     public function getDocumentFile() {
         Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/pdf/objetivos/';
        return isset($this->evidencias) ? Yii::$app->params['uploadPath'] . $this->evidencias : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getDocumentUrl() {
        Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/web/pdf/objetivos/';
        // return a default image placeholder if your source avatar is not found
        $evidencias = isset($this->evidencias) ? $this->evidencias : null;
        return Yii::$app->params['uploadUrl'] . $evidencias;
    }

    /**
     * Process upload of image
     *
     * @return mixed the uploaded image instance
     */
    public function uploadDocument() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $evidencias = UploadedFile::getInstance($this, 'evidencias');
        
        // if no image was uploaded abort the upload
        if (empty($evidencias)) {
            return false;
        }

        // store the source file name
        $this->evidencias = $evidencias->name;
        $ext = end((explode(".", $evidencias->name)));

        // generate a unique file name
        $this->evidencias = Yii::$app->security->generateRandomString() . ".{$ext}";

        // the uploaded image instance
        return $evidencias;
    }

    /**
     * Process deletion of image
     *
     * @return boolean the status of deletion
     */
    public function deleteDocument() {
        $file = $this->getDocumentFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->evidencias = null;

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstrategias()
    {
        return $this->hasMany(Estrategias::className(), ['id_objetivo' => 'id']);
    }
}
