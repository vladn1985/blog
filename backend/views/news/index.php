<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use common\models\News;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['style' => 'max-width:20px;'],
            ],

            [
                'attribute' => 'images',
                'format' => 'html',
                'value' => function (News $model) {
                    $image = $model->getImages()->one();
                    if (!$image) {

                        return '';
                    }
                    $html = Html::img('@frontendImg/' . $image->url, [
                        'height' => 60,
                    ]);

                    return $html;
                }
            ],
            [
                'attribute' => 'title',
                'value' => function (News $model) {
                    return StringHelper::truncate($model->title, 50);
                },
            ],
            [
                'attribute' => 'article',
                'value' => function (News $model) {
                    return StringHelper::truncate(strip_tags($model->article), 50);
                }
            ],
            'url:url',
            [
                'attribute' => 'category_id',
                'value' => 'category.title',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
