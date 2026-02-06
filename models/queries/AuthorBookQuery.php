<?php

namespace app\models\queries;

use app\models\activeRecords\AuthorBooks;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[AuthorBooks]].
 *
 * @see AuthorBooks
 */
class AuthorBookQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return AuthorBooks[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AuthorBooks|array|null
     */
    public function one($db = null): array|AuthorBooks|null
    {
        return parent::one($db);
    }
}
