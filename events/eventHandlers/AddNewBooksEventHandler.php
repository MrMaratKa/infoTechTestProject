<?php

namespace app\events\eventHandlers;

use app\events\eventsDto\AddNewBookEvent;
use app\models\activeRecords\Subscribes;
use app\services\SmsPilotService;

class AddNewBooksEventHandler
{
    public function __construct(private SmsPilotService $smsPilot, private Subscribes $subscribeTable)
    {
    }

    /**
     * Обработка события добавления новой книги
     *
     * @param AddNewBookEvent $addNewBookEvent
     * @return void
     */
    public function handle(AddNewBookEvent $addNewBookEvent): void
    {
        $subscribes = $this->subscribeTable::find()->with('author')->where([
            'author_id' => $addNewBookEvent->authorId
        ])->all();

        foreach ($subscribes as $subscribe) {
            $text = "Автор {$subscribe->author->fio}, на которго вы подписаны, выпустил новую книгу {$addNewBookEvent->bookName}";
            file_put_contents('TEST', $text, FILE_APPEND);
            \Yii::info($text);
            $this->smsPilot->send($subscribe->phone, $text);

        }
    }
}