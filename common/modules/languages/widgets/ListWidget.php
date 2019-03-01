<?php

namespace common\modules\languages\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\{Html, URL};


class ListWidget extends Widget{

    public $array_languages;

    public function init() {
        $language = Yii::$app->language; //текущий язык

        //Создаем массив ссылок всех языков с соответствующими GET параметрами
        $array_lang = [
            'current' => '',
            'languages'   => [],
        ];

        foreach (Yii::$app->getModule('languages')->languages as $key => $value){
            if ($value === Yii::$app->language) {
                $array_lang['current'] = $key;
            } else {
                $array_lang['languages'][] = [
                    'label' => $key,
                    'url'   => Url::toRoute([Yii::$app->request->getUrl(), 'lang' => $value]),
                ];
            }
        }

        //ссылку на текущий язык не выводим
        if(isset($array_lang[$language])) unset($array_lang[$language]);
        $this->array_languages = $array_lang;
    }

    public function run() {
        return $this->render('list',[
            'array_lang' => $this->array_languages
        ]);
    }
}
