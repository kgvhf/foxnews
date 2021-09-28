<?php

namespace app\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $released
 */
class News extends ActiveRecord {

    /**
     * 
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'news';
    }

    public function behaviors() {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'body'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at', 'released'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 2000],
            [['imageFile'], 'image', 'mimeTypes' => 'image/*', 'maxSize' => 10 * 1024 * 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'released' => 'Published',
            'image' => 'Product Image',
            'imageFile' => 'Product Image',
        ];
    }

    public function getEncodedBody() {
        return Html::encode($this->body);
    }

    public function save($runValidation = true, $attributeNames = null) {
        if ($this->imageFile) {
            $this->image = '/news/' . Yii::$app->security->generateRandomString() . '/' . $this->imageFile->name;
        }

        $transaction = Yii::$app->db->beginTransaction();
        $ok = parent::save($runValidation, $attributeNames);

        if ($ok && $this->imageFile) {
            $fullPath = Yii::getAlias('storage' . $this->image);
            $dir = dirname($fullPath);
            if (!FileHelper::createDirectory($dir) | !$this->imageFile->saveAs($fullPath)) {
                $transaction->rollBack();
                return false;
            }
        }

        $transaction->commit();

        return $ok;
    }

    public function getImageUrl() {
        return self::formatImageUrl($this->image);
    }

    public static function formatImageUrl($imagePath) {
        if ($imagePath) {
            return Yii::getAlias('@web/storage') . $imagePath;
        }

        return Yii::getAlias('@web/storage') . '/no_image_available.png123';
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        if ($this->image) {
            $dir = Yii::getAlias('storage'). dirname($this->image);
            FileHelper::removeDirectory($dir);
        }
    }

}
