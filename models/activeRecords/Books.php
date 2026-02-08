<?php

namespace app\models\activeRecords;

use app\events\eventsDto\AddNewBookEvent;
use app\models\queries\AuthorBookQuery;
use app\models\queries\AuthorsQuery;
use app\models\queries\BooksQuery;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property string $release_date Год выпуска
 * @property string $description Описание
 * @property int $isbn Isbn
 * @property string $img Фото главной страницы
 *
 * @property AuthorBooks[] $authorBooks
 * @property Authors[] $authors
 */
class Books extends ActiveRecord
{
    /** Событие на добавление новой книги */
    public const EVENT_AFTER_INSERT= 'addNewBookEvent';

    /**
     * @var UploadedFile|null
     */
    public ?UploadedFile $imageFile = null;

    /**
     * ID авторов
     * @var array
     */
    public $authorIds = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'release_date', 'description', 'isbn', 'authorIds'], 'required'],
            [['release_date'], 'safe'],
            [['description'], 'string'],
            [['isbn'], 'string', 'max' => 13],
            [['isbn'], 'match', 'pattern' => '/^(?:\d{9}[\dXx]|\d{13})$/'],
            [['isbn'], 'unique'],
            [['name', 'img'], 'string', 'max' => 255],
            [['imageFile'], 'file',
                'skipOnEmpty' => !$this->isNewRecord,
                'extensions' => 'png, jpg, jpeg, gif, webp',
                'maxSize' => 1024 * 1024 * 5,
                'checkExtensionByMimeType' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название книги',
            'release_date' => 'Год выпуска',
            'description' => 'Описание',
            'isbn' => 'Isbn',
            'author_id' => 'Авторы',
            'img' => 'Фото главной страницы',
            'imageFile' => 'Загрузить фото',
        ];
    }

    /**
     * Gets query for [[AuthorBooks]].
     *
     * @return ActiveQuery|AuthorBookQuery
     */
    public function getAuthorBooks(): ActiveQuery|AuthorBookQuery
    {
        return $this->hasMany(AuthorBooks::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return ActiveQuery|AuthorsQuery
     * @throws InvalidConfigException
     */
    public function getAuthors(): ActiveQuery|AuthorsQuery
    {
        return $this->hasMany(Authors::class, ['id' => 'author_id'])->viaTable('author_book', ['book_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return BooksQuery the active query used by this AR class.
     */
    public static function find(): BooksQuery
    {
        return new BooksQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     * @param $data
     * @param $formName
     * @return bool
     */
    public function load($data, $formName = null): bool
    {
        if (isset($data['Books']['imageFile'])) {
            unset($data['Books']['imageFile']);
        }

        return parent::load($data, $formName);
    }

    /**
     * Загрузка каринтки
     *
     * @param UploadedFile|null $uploadedFile
     * @return void
     * @throws Exception
     */
    public function upload(?UploadedFile $uploadedFile): void
    {
        $this->imageFile = $uploadedFile;
        if ($this->validate() && !is_null($this->imageFile)) {
            $fileName = Yii::$app->security->generateRandomString(10) . '.' . $this->imageFile->extension;
            $filePath = Yii::getAlias('@webroot/uploads/books/') . $fileName;

            $this->imageFile->saveAs($filePath);

            $this->img = $fileName;
        }
    }

    /**
     * Возвращает путь к картинке
     *
     * @return string
     */
    public function getImgUrl(): string
    {
        if ($this->img) {
            return Yii::getAlias('@web/uploads/books/') . $this->img;
        }
        return Yii::getAlias('@web/uploads/books/default.jpg');
    }

    public function afterFind(): void
    {
        parent::afterFind();

        $this->authorIds = \yii\helpers\ArrayHelper::getColumn(
            $this->authorBooks,
            'author_id'
        );
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        // Обработка связи с авторами
        if (!empty($this->authorIds)) {
            AuthorBooks::deleteAll(['book_id' => $this->id]);
            foreach ($this->authorIds as $authorId) {
                $bookAuthor = new AuthorBooks();
                $bookAuthor->book_id = $this->id;
                $bookAuthor->author_id = $authorId;
                $bookAuthor->save();
            }
        }

        // Триггер на отправку SMS подписчикам
        if ($insert) {
            foreach ($this->authorIds as $authorId) {
                $addNewBookEvent = new AddNewBookEvent($authorId, $this->name);
                $this->trigger(self::EVENT_AFTER_INSERT, $addNewBookEvent);
            }
        }
    }
}
