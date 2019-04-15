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
            [['title', 'description', 'category_id'], 'required' , 'message' => 'Заполните поле {attribute}', 'on' => ['ajax', 'notajax']],
            [['status', 'cause'], 'string'],
            [['cause'],'required', 'on' => ['editcause'], 'message' => 'Заполните поле {attribute}'],
            [['category_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'description'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id'],
            'on' => ['ajax', 'notajax'] ],
            [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, png, bmp', 'maxSize' => 1024*1024*10, 'on' => ['notajax','editphoto']]
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
            'status' => 'Статус',
            'category_id' => 'Категория',
            'photo' => 'Фото',
            'date' => 'Date',
            'cause' => 'Причина',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function create()
    {
        if($this->validate())
        {
            $this->user_id = Yii::$app->user->id;

            $this->date = date('Y-m-d H:i:s');

            $this->photo->name = time() . $this->photo->name;

            $this->photo->saveAs(Yii::getAlias('@app') . '/data/images/' . $this->photo->name);

            return $this->save(false);
        }
    }

    public function edit()
    {
        if($this->validate())
        {
            if($this->scenario=='editphoto')
            {
                @unlink(Yii::getAlias('@app') . '/data/images/' . $this->findOne($this->id)->photo);

                $this->photo->name = time() . $this->photo->name;

                $this->photo->saveAs(Yii::getAlias('@app') . '/data/images/' . $this->photo->name);
            }
            
            return $this->save(false);
        } 
    }
}
