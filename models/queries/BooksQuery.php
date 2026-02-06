<?php

namespace app\models\queries;

use app\models\activeRecords\Books;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Books]].
 *
 * @see Books
 */
class BooksQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Books[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Books|array|null
     */
    public function one($db = null): Books|array|null
    {
        return parent::one($db);
    }
}
