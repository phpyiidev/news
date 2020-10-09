<?php

/* @var $this yii\web\View */

use yii\jui\Menu;

$this->title = 'Новостной портал';
?>
<div class="site-index">

    <div class="row">
        <div class="user-menu">
            <ul class="nav nav-tabs" id="main-menu"  rubric_id="0">

            </ul>
        </div>
    </div>
    <div class="jumbotron">
        <h1>Добро пожаловать на портал новостей!</h1>
        <p class="lead">Здесь каждый может создавать новости и добавлять рубрики новостей, а так же просматривать уже имеющиеся новости.</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
<?php
$menu = <<<JS
    $.ajaxSetup({
        error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
                alert('Not connect. Verify Network.');
            } else if (jqXHR.status == 404) {
                alert('Requested page not found (404).');
            } else if (jqXHR.status == 500) {
                alert('Internal Server Error (500).');
            } else if (exception === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (exception === 'timeout') {
                alert('Time out error.');
            } else if (exception === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Uncaught Error. ' + jqXHR.responseText);
            }
        }
    });
    $.ajax('/api/rubrics/index',{
        method: 'get',
        success: function(data){
            buildMenu(data[0]['items'], 0, 1);
        }
    });
    function buildMenu(json, rubric_id, level) {
        //console.log(json[0]);
        $.each(json, function(index, item) {
            console.log($('ul#main-menu[rubric_id="'+rubric_id+'"]'));
            if (item.items.length === 0) {
                $('ul#main-menu[rubric_id="'+rubric_id+'"]').append('<li><a id="rubric-link" href="#" rubric="'+index+'">'+item.name+'</a></li>');
            } else {
                $('ul#main-menu[rubric_id="'+rubric_id+'"]').append(
                    '<li class="dropdown-submenu">'+
                        '<a id="rubric-link" class="dropdown-toggle" data-toggle="dropdown" href="#" rubric="'+index+'">'+
                            item.name+
                        '</a>'+
                        '<ul class="dropdown-menu" id="main-menu" rubric_id="'+index+'"></ul>'+
                    '</li>'
                );
                level++;
                buildMenu(item.items, index, level);
                level--;
            }
        });
    }
    $(document).on("click", "a#rubric-link", function() {
        $.ajax('/api/news/index',{
            method: 'get',
            data: {'rubrics': $(this).attr('rubric')},
            success: function(data){
                console.log(data);
            },
        });
    });
JS;
$this->registerJs($menu);
?>