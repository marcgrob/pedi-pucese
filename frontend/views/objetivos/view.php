<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model app\models\Objetivos */

$this->title = 'Objetivo ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Objetivos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objetivos-view">

    <h3><?= $model->descripcion ?></h3>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-4">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'responsables',
                        'fecha_inicio',
                        'fecha_fin',
                    ],
                ])
                ?>
            </div>
            <div class="col-sm-8">
                <?=
                FileInput::widget([
                    'name' => 'evidencias',
                    'options' => [
                        'multiple' => true,
                        'showRemove' => false,
                    ],
                    'pluginOptions' => [
                        'overwriteInitial' => false,
                        'initialPreview' => $model->getEvidencias_preview(),
                        'initialPreviewAsData' => true,
                        'initialPreviewConfig' => $model->getEvidencias(),
                        'showPreview' => true,
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'showBrowse' => false,
                        'showremoveClass' => false,
                        'showremoveIcon' => false
                    ]
                ]);
                ?>
            </div>
        </div>
    </div>
    
    <h3>ESTRATEGIAS</h3>
     <?=
        Html::button('Crear Estrategias', [
            'class' => 'btn btn-success btn-ajax-modal',
            'value' => Url::to(['/estrategias/create', 'id' => $model->id]),
            'id'=>'agregar_estrategias',
            'data-target' => '#modal_add_estrategias',
        ]);
        ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            //'id',
            ['class' => 'yii\grid\SerialColumn'],
            'descripcion',
            //'responsables',
            //'fecha_inicio',
            //'fecha_fin',
            // 'evidencias',
            // 'presupuesto',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['estrategias/view', 'id' => $model['id']], [
                                    'title' => Yii::t('yii', 'Ver'),
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['estrategias/update', 'id' => $model['id']], [
                                    'title' => Yii::t('yii', 'Modificar'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['estrategias/delete', 'id' => $model['id']], [
                                    'title' => Yii::t('yii', 'Eliminar'),
                        ]);
                    },
                        ]
                    ],
                ],
            ]);
            ?>
 <?php
    Modal::begin([
        'size' => Modal::SIZE_LARGE,
        'id' => 'modal_add_estrategias',
        'header' => '<h4>Estrategias</h4>',
    ]);
    echo '
    <?php
    $this->re<div id="modal-content"></div>';
    Modal::end();
    ?>
    <?php
    $this->registerJs('
        $(\'.modal-lg\').css(\'width\', \'90%\');
        $(\'.btn-ajax-modal\').click(function (){
    var elm = $(this),
        target = elm.attr(\'data-target\'),
        ajax_body = elm.attr(\'value\');

    $(target).modal(\'show\')
        .find(\'.modal-content\')
        .load(ajax_body);
});
    ');
    ?>
</div>
