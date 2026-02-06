<?php

namespace app\models\activeRecords;

use app\models\queries\AuthorsQuery;
use app\models\queries\SubscribesQuery;
use floor12\phone\PhoneValidator;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "subscribes".
 *
 * @property int $author_id
 * @property string $phone
 *
 * @property Authors $author
 */
class Subscribes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'subscribes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['author_id', 'phone'], 'required'],
            [['author_id', 'phone'], 'unique', 'targetAttribute' => ['author_id', 'phone'], 'message' => 'Этот телефон уже подписан на данного автора'],
            [['author_id'], 'integer'],
            [['phone'], PhoneValidator::class],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'author_id' => 'Author ID',
            'phone' => 'Phone',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return ActiveQuery|AuthorsQuery
     */
    public function getAuthor(): ActiveQuery|AuthorsQuery
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }

    /**
     * {@inheritdoc}
     * @return SubscribesQuery the active query used by this AR class.
     */
    public static function find(): SubscribesQuery
    {
        return new SubscribesQuery(get_called_class());
    }

}
