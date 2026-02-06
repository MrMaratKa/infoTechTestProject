<?php
namespace app\events\eventsDto;

use yii\base\Event;

class AddNewBookEvent extends Event
{
    public function __construct(public int $authorId, public string $bookName, $config = [])
    {
        parent::__construct($config);
    }
}