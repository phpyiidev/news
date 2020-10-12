<?php

/**
 * Преставление главной страницы
 * @var $this yii\web\View
 * */

use yii\jui\Menu;

$this->title = 'Новостной портал';
?>
    <div class="site-index">

        <div class="jumbotron">
            <h1>Добро пожаловать на портал новостей!</h1>
            <p class="lead">Здесь каждый может создавать новости и добавлять рубрики новостей, а так же просматривать
                уже имеющиеся новости.</p>
        </div>
        <div class="row">
            <div class="user-menu">
                <ul class="nav nav-tabs" id="main-menu" rubric_id="0">

                </ul>
            </div>
        </div>

        <div class="body-content" id="rubric_news">

        </div>
    </div>
<?php
$newsJS = <<<JS
    // Настраиваем обработку ошибок для всех ajax запросов
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
    
    /**
     * Сразу после срабатывания события ready для document, отправляем ajax запрос на REST контроллер рубрик для 
     * получения дерева рубрик в json формате и последующей передачи в функцию buildMenu для построения меню из рубрик
    */
    $.ajax('/api/rubrics/index',{
        method: 'get',
        success: function(data){
            buildMenu(data[0]['items'], 0);
            $("a#rubric-link").first().click().click();
        }
    });
    
    /**
    * Рекурсионная функция построения меню из json дерева рубрик бесконечной вложенности
    * @param json дерово рубрик
    * @param rubric_id Идентификатор родительской рубрики. Для начала построения меню с корневых рубрик указать 0
    */
    function buildMenu(json, rubric_id) {
        //console.log(json[0]);
        $.each(json, function(index, item) {
            //console.log($('ul#main-menu[rubric_id="'+rubric_id+'"]'));
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
                buildMenu(item.items, index);
            }
        });
    }
    /**
    * Отслеживаем клики по ссылкам меню рубрик и отправляем ajax запрос на REST контроллер новостей с идентификатором 
    * рубрики для получения всех новостей данной рубрики и её подрубрик. При успешном ответе формируем и вкладываем в 
    * контейнер блоки новостей, размещая по 3 новости в ряд. Для каждого ряда новостей создается отдельный контейнер, 
    * для каждых трёх новостей.  
    */
    $(document).on("click", "a#rubric-link", function() {
        var _this = $(this);
        $.ajax('/api/news/index',{
            method: 'get',
            data: {'rubrics': _this.attr('rubric')},
            success: function(data){
                $.each($("a#rubric-link"),function(index,item) {
                    $(item).parent().removeClass('active')
                });
                _this.parent().addClass('active');
                if (data.length === 0) {
                    $("div#rubric_news").html("<h3>В данной рубрике пока нет новостей</h3>");
                } else {
                    $("div#rubric_news").html("");
                    var count = 0;
                    $.each(data, function(index, item) {
                        if (count === 0 || count % 3 === 0) {
                            $("div#rubric_news").append('<div class="row" id ="row-'+Math.floor(count/3)+'"></div>');
                        }
                        $("div#rubric_news div#row-"+Math.floor(count/3)).append(
                            '<div class="col-lg-4">'+
                                '<h2>'+item.name+'</h2>'+
                                '<p>'+item.text+'</p>'+
                                '<p><a class="btn btn-default" href="/news/view?id='+item.id+'">Просмотр</a></p>'+
                            '</div>'
                        );
                        count++;
                    });
                }
            }
        });
    });
JS;
$this->registerJs($newsJS, \yii\web\View::POS_READY);
?>