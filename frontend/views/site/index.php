<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
	@var $this yii\web\View
	@var $category common\models\Category
*/

?>
<div class="row">
	<div class="col-md-3">
		<h3 class="additional-title">Новости</h3>
		<hr class ="red-line"/>
		<?php foreach ($allNews as $article): ?>
		<div class="articles">
			<?= Html::a(Yii::t('app', $article->title), Url::toRoute('/' . $article->getCategory()->one()->url . '/' . $article->url)); ?>
		</div>
		<p> </p>
		<?php endforeach; ?>
	</div>

	<div class="col-md-6">
		<h2> </h2>
		<p> </p>
	</div>

	<div class="col-md-3">
		<h3 class="additional-title">Главное</h3>
		<hr class ="red-line"/>
		<p> </p>
	</div>
</div>
