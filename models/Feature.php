<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "feature".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProductFeature[] $productFeatures
 */
class Feature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[ProductFeatures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductFeatures()
    {
        return $this->hasMany(ProductFeature::className(), ['feature_id' => 'id']);
    }
}
