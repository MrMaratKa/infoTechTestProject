<?php

namespace app\models\forms;

use yii\base\Model;

class ReportForm extends Model
{
    public string $year;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->year = $this->year ?? date('Y');
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['year'], 'required'],
            ['year', 'date', 'format' => 'yyyy'],
        ];
    }
}