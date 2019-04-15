<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "claim".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property int $category_id
 * @property string $photo
 * @property string $date
 * @property string $cause
 *
 * @property Category $category
 */
class Claim extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required' , 'message' => 'Заполните поле {attribute}'],
            [['status', 'cause'], 'string'],
            [['category_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, png, bmp', 'maxSize' => 1024*1024*10, 'on' => 'notajax']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название заявки',
            'description' => 'Описание заявки',
            'status' => 'Status',
            'category_id' => 'Категория',
            'photo' => 'Фото',
            'date' => 'Date',
            'cause' => 'Cause',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function create()
    {
        if($this->validate())
        {
            $this->date = date('Y-m-d H:i:s');

            $this->photo->name = time() . $this->photo->name;

            $this->photo->saveAs(Yii::getAlias('@app') . '/data/images/' . $this->photo->name);

            return $this->save(false);
        }
    }
}
