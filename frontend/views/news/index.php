<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

?>
<h1><?= $article->title; ?></h1>

<div>
	<?php 
		$images = $article->getImages()->all();
		foreach ($images as $image) {
			$filePath = '/images/' . $image->url;
			echo Html::img($filePath, [
				'max-width' => '100%',
			]);
		}
	?>
</div>

<div><?= $article->article; ?></div>