<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\datetime\DateTimePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObjetivosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Objetivos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="objetivos-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <p>
                    <?=
                    Html::button('Crear Objetivos', [
                        'class' => 'btn btn-success btn-ajax-modal',
                        'value' => Url::to(['/objetivos/create']),
                        'data-target' => '#modal_add_objetivos',
                    ]);
                    ?>                </p>
            </div>
            <div class="col-sm-3">
                <!--?= $form->field($model, 'id')->dropDownList([])->label('Copiadora') ?-->
                <?php
                $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                ]);
                ?>
                <?=
                DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fecha_inicio',
                    'language' => 'es',
                    'options' => ['placeholder' => 'Seleccione Año'],
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'format' => 'yyyy',
                        'autoclose' => true,
                        'startView' => 4,
                        'minView' => 4,
                    ],
                ])
                ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'descripcion',
                //'evidencias',
                [
                    'attribute' => 'fecha_inicio',
                    'value' => 'fecha_inicio',
                    'filter' => false,
                ],
                [
                    'attribute' => 'fecha_fin',
                    'value' => 'fecha_fin',
                    'filter' => false
                ],
                // 'evidencias',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]);
        ?>
        <?php
        Modal::begin([
            'size' => Modal::SIZE_LARGE,
            'id' => 'modal_add_objetivos',
            'header' => '<h4>Objetivos</h4>',
        ]);
        echo '<div id="modal-content"></div>';
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
