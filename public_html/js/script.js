"use strict";
$(document).ready(function() {
    init();



//Пвто отступ модальной формы формы
    var onResize = function () {
        // apply dynamic padding at the top of the body according to the fixed navbar height
        $("body").css("padding-top", $(".navbar-fixed-top").height());
    };

    $(window).resize(onResize); // attach the function to the window resize event

    $(function () {
        onResize();
    });

    function initChangeBox(selBoxValue) {

        fillSelector('select#repair_post_id', resources, 'title', selBoxValue);//Ремонтные посты
        var type = getDataJson('connector.php?get=repairType', 'boxid=' + selBoxValue);
        fillSelector('select#repair_type_id', type, 'name', 'more');
    }

    var resources = getDataJson('connector.php?get=resources', 'json'); //получаем данные по боксам и постам
    var types = getDataJson('connector.php?get=repairTypes', 'json'); //получаем типы работ
    var users = getDataJson('connector.php?get=humanResources', 'json'); //получаем данные по пользователям, пользователю

    $('#createTestButton').click(function () {
        console.log("Вызов диалогового окна");
        //Заполняем селекторы с боксами
        fillSelector('select#repair_box_id', resources, 'title', 'more'); // ремонтные боксы

        var selBoxVal = $('select#repair_box_id').val(); //Берем текущее значение бокса

        fillSelector('select#repair_post_id', resources, 'title', selBoxVal);//Ремонтные посты

        var type = getDataJson('connector.php?get=repairType', 'boxid=' + selBoxVal);   //Загружаем типы работ

        fillSelector('select#repair_type_id', type, 'name', 'more'); //заполняем Типы работ

        fillSelector('select#user_target_name', users, 'name', 'more'); //Заполняем механиков

        $('#createTestForm').dialog('open'); //Открываем окно диалога

    });



    function init() {
        console.log("Инциализация, загрузка init вывод имя, группа");
        $.ajax({
            type: 'POST',
            url: 'connector.php?get=init',
            data: 'json',
            success: function (data) {
                $("a#username").html("Ты вошёл как: " + data.userInfo.name);
                $("a#role").html("Твоя группа: " + data.userInfo.nameRole);

            }
        });
    }

    function getDataJson(urlSet, keysvalues) {
        console.log("Загрузка: " + urlSet);
        var response = false;
        $.ajax({
            type: 'POST',
            async: false,
            url: urlSet,
            data: keysvalues,
            success: function (data) {
                response = data;
            }
        });
        return response;
    }

//Функция для заполнения первый параметр эллемент напримар:select#имя_ид, второй параметр обьект который вставляем
    function fillSelector(el, values, nameField, selBoxV) {
        console.log("Заполняем эллемент: " + el);
        if (selBoxV == 'more') {
            $(el).empty();
            _.each(values, function (data) {
                $(el).append("<option value=" + data.id + ">" + data[nameField] + "</option>");
            });
        } else {
            _.each(values, function (data) {
                if (selBoxV == data.id) {

                    _.each(data.children, function (data) {
                        console.log(data.id + " " + data.title);
                        $(el).append("<option value=" + data.id + ">" + data[nameField] + "</option>"); //data title
                    });
                }
            });
        }
    }

});