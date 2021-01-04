<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_feature".
 *
 * @property int $feature_id
 * @property int $product_id
 * @property string|null $value
 *
 * @property Feature $feature
 * @property Product $product
 */
class ProductFeature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['feature_id', 'product_id'], 'required'],
            [['feature_id', 'product_id'], 'integer'],
            [['value'], 'string', 'max' => 45],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feature::className(), 'targetAttribute' => ['feature_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'feature_id' => 'Feature ID',
            'product_id' => 'Product ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Feature]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeature()
    {
        return $this->hasOne(Feature::className(), ['id' => 'feature_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
