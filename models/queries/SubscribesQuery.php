<?php

namespace app\models\queries;

use app\models\activeRecords\Subscribes;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Subscribes]].
 *
 * @see Subscribes
 */
class SubscribesQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Subscribes[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Subscribes|array|null
     */
    public function one($db = null): array|Subscribes|null
    {
        return parent::one($db);
    }
}
