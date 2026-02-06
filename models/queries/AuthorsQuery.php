<?php

namespace app\models\queries;

use app\models\activeRecords\Authors;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Authors]].
 *
 * @see Authors
 */
class AuthorsQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Authors[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Authors|array|null
     */
    public function one($db = null): Authors|array|null
    {
        return parent::one($db);
    }
}
