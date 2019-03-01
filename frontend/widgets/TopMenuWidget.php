<?php

namespace frontend\widgets;

use Yii;
use common\models\Category;
use yii\helpers\Html;
use yii\base\Widget;
use yii\helpers\URL;
use common\models\Language;
use host33\multilevelhorizontalmenu\MultilevelHorizontalMenu;

class TopMenuWidget extends Widget
{
	public $items;

	public function init()
	{
        parent::init();

        $this->items = [
        	[
        		'url' => ['site/index'],
        		'label' => Yii::t('app', 'Home'),
                'active' => Yii::$app->request->getUrl() == Url::toRoute(['site/index'])
        	]
        ];
        $this->addCategories();
    }

    private function addCategories()
    {
        $language = Language::find()->where(['url' => Yii::$app->language])->one();
        $categories = Category::find()->where(['language_id' => $language->id])->all();
        foreach ($categories as $category) {
            $categoryUrl = URL::toRoute('/' . ltrim($category->url, '/'));
        	$this->items[] = [
        		'url' => $categoryUrl,
        		'label' => $category->title,
                'active' => Yii::$app->request->getUrl() == $categoryUrl,
        	];
        }    	
    }

	public function run()
    {
        return \yii\widgets\Menu::widget([
            'items' => $this->items,
        ]);

        return MultilevelHorizontalMenu::widget([
            'menu' => $this->items,
        ]);

    }
}