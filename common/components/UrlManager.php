<?php
/*
 * Добавляет указатель языка в ссылки
 */
namespace common\components;

use Yii;
use common\models\Language;
use yii\helpers\ArrayHelper;
use common\models\Category;
use common\models\News;

class UrlManager extends \yii\web\UrlManager {

    private $availableLanguages;

    public function createUrl($params) {
        if ($requestLang = $params['lang'] ?? \Yii::$app->language) {
            unset($params['lang']);
        }

        $route = $params[0] ?? null;
        if ($route == 'category/index') {
            $params[0] = '/' . $params['category']->url;
            unset($params['per-page']);
            if ($params['page'] == 1) {
                unset($params['page']);
            }
        }

        //Получаем сформированную ссылку(без идентификатора языка)
        $url = parent::createUrl($params);

        $routeParts = explode('/', trim($url, '/'));
        $element = reset($routeParts);

        if (in_array($element, $this->getAvailableLanguages())) {
            $url = '/' . ltrim(str_replace($element, '', ltrim($url, '/')), '/');
        };

        if ($requestLang !== Yii::$app->sourceLanguage) {
            $url = '/' . $requestLang . $url;
        };

        return $url;
    }

    private function getAvailableLanguages()
    {
        if (!$this->availableLanguages) {
            $languages = Language::find()->all();
            $this->availableLanguages = ArrayHelper::map($languages, 'id', 'url');
        }

        return $this->availableLanguages;
    }

    public function parseRequest($request)
    {
        $pathInfo = $request->getPathInfo();
        $pathInfoParts = explode('/', $pathInfo);
        $language = Language::find()->where(['url' => Yii::$app->language])->one();
        if (count($pathInfoParts)) {
            $category = $this->getCategory($pathInfoParts[0], $language);
            if ($category == NULL) {
                return parent::parseRequest($request);
            }
            $articleUrl = $pathInfoParts[1] ?? NULL;
            if ($articleUrl == NULL) {
                return ['category/index', [
                    'category' => $category,
                ]];                
            }
            $article = $this->getArticle($category, $articleUrl, $language);
            if ($article == NULL) {
                return ['site/error'];
            }
            return ['news/index', [
                'category' => $category,
                'article' => $article,
            ]];
        }

        return parent::parseRequest($request);
    }

    private function getArticle(Category $category, string $url, Language $language): ?News
    {
        return News::find()->where([
            'category_id' => $category->id,
            'url' => $url,
            'language_id' => $language->id,
        ])->one();
    }

    private function getCategory(string $url, Language $language): ?Category
    {
        return Category::find()->where([
            'url' => $url,
            'language_id' => $language->id,
        ])->one();
    }
}
