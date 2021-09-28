<?php
/** @var \app\models\News $model */
?>

<div>   
    <a href="<?php echo yii\helpers\Url::to(['/news/view', 'slug' => $model->slug]) ?>">
        <h3><?php echo \yii\helpers\Html::encode($model->title) ?></h3>
    </a>
    
    <div>
        <?php echo \yii\helpers\StringHelper::truncate($model->getEncodedBody(), 400) ?>
    </div>
    <hr>
</div>
