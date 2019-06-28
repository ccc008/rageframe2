<?php
use yii\grid\GridView;
use common\helpers\Html;
use common\helpers\DebrisHelper;

$this->title = '报错日志';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title; ?></h3>
            </div>
            <div class="box-body table-responsive">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    //重新定义分页样式
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                        ],
                        'method',
                        'module',
                        [
                            'attribute' => '控制器方法',
                            'value' => function ($model) {
                                return $model->controller . '/' . $model->action;
                            },
                        ],
                        'url',
                        [
                            'attribute' => 'ip',
                            'value' => function ($model) {
                                return DebrisHelper::long2ip($model->ip);
                            },
                            'filter' => false, //不显示搜索框
                        ],
                        [
                            'label' => '地区',
                            'value' => function ($model) {
                                return DebrisHelper::analysisLongIp($model->ip);
                            },
                        ],
                        [
                            'attribute' => 'error_code',
                            'label' => '状态码',
                            'value' => function ($model) {
                                if ($model->error_code < 300) {
                                    return '<span class="label label-primary">' . $model->error_code . '</span>';
                                } else {
                                    return '<span class="label label-danger">' . $model->error_code . '</span>';
                                }
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute' => 'created_at',
                            'filter' => false, //不显示搜索框
                            'format' => ['date', 'php:Y-m-d H:i:s'],
                        ],
                        [
                            'header' => "操作",
                            'class' => 'yii\grid\ActionColumn',
                            'template'=> '{view}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::linkButton(['view','id' => $model->id], '查看详情', [
                                        'data-toggle' => 'modal',
                                        'data-target' => '#ajaxModalLg',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
