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
            [['title', 'description', 'category_id', 'photo', 'date'], 'required'],
            [['status'], 'string'],
            [['category_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'description', 'photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'photo' => 'Photo',
            'date' => 'Date',
        ];
    }
}
