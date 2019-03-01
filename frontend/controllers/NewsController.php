<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\News;

class NewsController extends \yii\web\Controller
{
    public function actionIndex(Category $category, News $article)
    {
        return $this->render('index', [
        	'article' => $article,


        ]);
    }

}
