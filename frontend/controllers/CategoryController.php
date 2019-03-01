<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\News;
use yii\data\Pagination;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex(Category $category)
    {
	    $query = News::find()->where(['category_id' => $category->id]);
	    $pages = new Pagination([
	    	'totalCount' => $query->count(), 
	    	'pageSize' => 5,
	    ]);
	    $news = $query->offset($pages->offset)
	        ->limit($pages->limit)
	        ->all();

	    return $this->render('index', [
	         'news' => $news,
	         'pages' => $pages,
	         'category' => $category,
    	]);
	}

}
