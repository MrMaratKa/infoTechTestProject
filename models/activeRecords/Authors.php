<?php

namespace app\models\activeRecords;

use app\models\forms\ReportForm;
use app\models\queries\AuthorBookQuery;
use app\models\queries\AuthorsQuery;
use app\models\queries\BooksQuery;
use DateTime;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $fio ФИО
 *
 * @property AuthorBooks[] $authorBooks
 * @property Books[] $books
 */
class Authors extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'authors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fio'], 'required'],
            [['fio'], 'string', 'max' => 255, 'tooLong'=>'{attribute} должно быть меньше {max} символов'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
        ];
    }

    /**
     * Gets query for [[AuthorBooks]].
     *
     * @return ActiveQuery|AuthorBookQuery
     */
    public function getAuthorBooks(): ActiveQuery|AuthorBookQuery
    {
        return $this->hasMany(AuthorBooks::class, ['author_id' => 'id']);
    }

    /**
     * Gets query for [[Books]].
     *
     * @return ActiveQuery|BooksQuery
     * @throws InvalidConfigException
     */
    public function getBooks(): ActiveQuery|BooksQuery
    {
        return $this->hasMany(Books::class, ['id' => 'book_id'])->viaTable('author_book', ['author_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AuthorsQuery the active query used by this AR class.
     */
    public static function find(): AuthorsQuery
    {
        return new AuthorsQuery(get_called_class());
    }

    /**
     * Топ авторы за указанный в форме период
     *
     * @param ReportForm $reportForm
     * @return array
     * @throws \Exception
     */
    public static function getTopAuthorsList(ReportForm $reportForm): array
    {
        $startDate = (new DateTime($reportForm->year . '-01-01'))->format('Y-m-d');
        $endDate = (new DateTime($reportForm->year . '-12-31'))->format('Y-m-d');

        return Authors::find()
            ->select(['authors.fio', 'COUNT(author_book.book_id) as book_count'])
            ->innerJoin('author_book', 'author_book.author_id = authors.id')
            ->innerJoin('books', 'books.id = author_book.book_id')
            ->where(['between', 'books.release_date', $startDate, $endDate])
            ->groupBy('authors.id')
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(10)
            ->all();
    }

}
