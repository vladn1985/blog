<?php

namespace backend\controllers;

use Yii;
use common\models\News;
use common\models\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Language;
use yii\helpers\ArrayHelper;
use common\models\Category;
use yii\web\UploadedFile;
use common\models\Image;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $files = UploadedFile::getInstances($model, 'images');
            foreach ($files as $file) {
                $info = new \SplFileInfo($file->name);
                $path = Yii::getAlias('@frontend') . '/web/images/';
                $fileName = $this->getRandomFileName($path, $info->getExtension());
                $file->saveAs($path . $fileName);
                $image = new Image;
                $image->url = $fileName;
                $image->news_id = $model->id;
                $image->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $languagesObjects = Language::find()->all();
        $languages = ArrayHelper::map($languagesObjects, 'id', 'title');
        $categoriesObjects = Category::find()->where(['language_id' => $model->language_id])->all();
        $categories = ArrayHelper::map($categoriesObjects, 'id', 'title');

        return $this->render('create', [
            'model' => $model,
            'languages' => $languages,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $files = UploadedFile::getInstances($model, 'images');
            foreach ($files as $file) {
                $info = new \SplFileInfo($file->name);
                $path = Yii::getAlias('@frontend') . '/web/images/';
                $fileName = $this->getRandomFileName($path, $info->getExtension());
                $file->saveAs($path . $fileName);
                $image = new Image;
                $image->url = $fileName;
                $image->news_id = $model->id;
                $image->save();

            }

            return $this->redirect(['view', 'id' => $model->id]);

        }

        $imageObjects = Image::find()->where(['news_id' => $model->id])->all();
        $images = [];
        $imagesPreviewConfig = [];
        foreach ($imageObjects as $image) {
            $images[] = Yii::getAlias('@frontendImg') . '/' . $image->url;
            $imagesPreviewConfig[] = [
                // 'caption' => $image->url,
                // 'size' => 12434,
                'url' => '/news/delete-image',
                'key' => $image->id,
            ];
        }
        $languagesObjects = Language::find()->all();
        $languages = ArrayHelper::map($languagesObjects, 'id', 'title');
        $categoriesObjects = Category::find()->where(['language_id' => $model->language_id])->all();
        $categories = ArrayHelper::map($categoriesObjects, 'id', 'title');

        return $this->render('update', [
            'model' => $model,
            'languages' => $languages,
            'categories' => $categories,
            'images' => $images,
            'imagesPreviewConfig' => $imagesPreviewConfig,
        ]);
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImage()
    {
        $imageId = Yii::$app->request->post('key');
        $image = Image::findOne($imageId);

        $filePath = Yii::getAlias('@frontend') . '/web/images/' . $image->url;
        $image->delete();
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return json_encode([]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
        
    public static function getRandomFileName(string $path, string $extension): string
    {
        do {
            $name = substr(md5(microtime() . rand(0, 9999)), 0, 6)  . '.' . $extension;
            $fullPath = $path . $name;
        } while (file_exists($fullPath));

        return $name;
    }
}
