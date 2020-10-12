<!-- Меню слева -->
<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Администратор</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Меню', 'options' => ['class' => 'header']],
                    ['label' => 'Главная', 'icon' => 'circle', 'url' => ['/']],
                    [
                        'label' => 'Рубрики',
                        'icon' => 'circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Список', 'icon' => 'list', 'url' => ['/rubrics/index'],],
                            ['label' => 'Добавить', 'icon' => 'plus', 'url' => ['/rubrics/create'],],
                        ],
                    ],
                    [
                        'label' => 'Новости',
                        'icon' => 'file-text-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Список', 'icon' => 'list', 'url' => ['/news/index'],],
                            ['label' => 'Добавить', 'icon' => 'plus', 'url' => ['/news/create'],],
                        ],
                    ],
                    [
                        'label' => 'Инструменты',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>