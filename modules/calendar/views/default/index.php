<?php
use yii\bootstrap5\Html;

/** @var string $currentType */

/** @var \app\modules\calendar\controllers\DefaultController $controller */
$controller = $this->context;
$module = $controller->module;
$current = $current ?? '';


$buttons = [
    'personal' => [
        'title' => '<i class="fa fa-user"></i> <span class="hidden-xs">Мой календарь</span>',
        'url' => 'calendar'
    ],
    'company' => [
        'title' => '<i class="fa fa-users"></i> <span class="hidden-xs">Календарь компании</span>',
        'url' => 'calendar'
    ]
]
?>

<!-- .btn-group -->

<div class="btn-group">
    <?php foreach ($buttons as $type => $btn) : ?>
        <?= Html::a($btn['title'], $btn['url'],
            ['class' => 'btn btn-outline-primary btn-sm ' . ($type === $current ? 'active' : '')]
        ) ?>
    <?php endforeach ?>
</div><!-- /.btn-group -->


<div class="Module-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
