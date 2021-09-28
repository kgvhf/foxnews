<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-muted">
        <small>
            Created at: <?php echo Yii::$app->formatter->asRelativeTime($model->created_at) ?>
        </small>
    </p>

    <p>
        <?= Html::a('Update', ['update', 'slug' => $model->slug], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'slug' => $model->slug], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    
    <div>
        <img src="<?php echo $model->getImageUrl() ?>" style="width: 400px; height: auto;">
    </div>
    
    <div class="mt-3"><?php echo $model->getEncodedBody() ?></div>

</div>
