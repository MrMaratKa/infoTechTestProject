<?php

namespace app\models\activeRecords;

use app\models\queries\AuthorBookQuery;
use app\models\queries\AuthorsQuery;
use app\models\queries\BooksQuery;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "author_book".
 *
 * @property int $book_id
 * @property int $author_id
 *
 * @property Authors $author
 * @property Books $book
 */
class AuthorBooks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'author_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['book_id', 'author_id'], 'required'],
            [['book_id', 'author_id'], 'integer'],
            [['book_id', 'author_id'], 'unique', 'targetAttribute' => ['book_id', 'author_id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::class, 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'book_id' => 'Book ID',
            'author_id' => 'Author ID',
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
     * Gets query for [[Book]].
     *
     * @return ActiveQuery|BooksQuery
     */
    public function getBook(): ActiveQuery|BooksQuery
    {
        return $this->hasOne(Books::class, ['id' => 'book_id']);
    }

    /**
     * {@inheritdoc}
     * @return AuthorBookQuery the active query used by this AR class.
     */
    public static function find(): AuthorBookQuery
    {
        return new AuthorBookQuery(get_called_class());
    }
}
