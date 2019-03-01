<?php

echo yii\bootstrap\Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [
        [
        	'label' => $array_lang['current'],
        	'items' => $array_lang['languages']
        ],
    ],
]);
