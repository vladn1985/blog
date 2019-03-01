<?php
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;

/*
	@var $this yii\web\View
	@var $category common\models\Category
*/

?>
<h1><?= $category->title ?></h1>

<div class="news">
	<?php foreach ($news as $article): ?>
		<div class="row">
			<div class="col-md-3">
				<?php 
					$image = $article->getImages()->one();
					$filePath = '/images/' . $image->url;
					echo Html::img($filePath, ['width' => '100%']);
					?>
			</div>
			<div class="col-md-9">
				<div class="title">
					<?= Html::a(Yii::t('app', $article->title), Url::toRoute('/' . $category->url . '/' . $article->url)); ?>
				</div>
				<div class="article">
					<?= StringHelper::truncate($article->article, 500); ?>
				</div>
				<div class="moderation-button">
					<?php
						if (\Yii::$app->user->can('createPost')) {
							echo Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-link']);
						}
						if (\Yii::$app->user->can('updatePost')) {
							echo Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-link']);
						}
					?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>

<?= LinkPager::widget([
    'pagination' => $pages,
]); ?>