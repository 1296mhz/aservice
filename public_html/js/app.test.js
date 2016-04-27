"use strict";
var startdatetime,
    enddatetime;

var resources = getDataJson('connector.php?get=resources', 'json'); //получаем данные по боксам и постам
var types = getDataJson('connector.php?get=repairTypes', 'json'); //получаем типы работ
var users = getDataJson('connector.php?get=humanResources', 'json'); //получаем данные по пользователям, пользователю
var state = getDataJson('connector.php?get=getAllStatus', 'json'); //Получение всех статусов события

function watchDog(){

        getDataJson('connector.php?get=watch', 'json');

}

function initChangeBox(selBoxValue) {
    console.log("initChangeBox" + selBoxValue);
    fillSelector('select#repair_post_id', resources, 'title', selBoxValue);//Ремонтные посты
    var type = getDataJson('connector.php?get=repairType', 'boxid=' + selBoxValue);
    fillSelector('select#repair_type_id', type, 'name', 'more');
}

$( document ).ready(function() {
    console.log( "ready!" );
    watchDog();
    setInterval( 'watchDog()', 10000);

    // user_target_name
    var $selectBox = $('#repair_box_id');

    startdatetime = $('#startdatetime').datetimepicker({format: 'YYYY-MM-DD HH:mm', locale: 'ru'});
    enddatetime = $('#enddatetime').datetimepicker({format: 'YYYY-MM-DD HH:mm', locale: 'ru'});

    $selectBox.off('change').on('change', function(e){
        e.preventDefault();
        console.log("change");
        initChangeBox($selectBox.val());
    });

    init();
    resizeWorkspace();

    function init() {
        console.log("Инциализация, загрузка init вывод имя, группа");
        var initData = getDataJson('connector.php?get=init', 'json');
        $("a#username").html("Ты вошёл как: " + initData.userInfo.name);
        $("a#role").html("Твоя группа: " + initData.userInfo.nameRole);
    }

   var searchElements = {
       url: 'connector.php?get=search',
       elements: [
           'input#customer_name',
           'input#customer_phone',
           'input#customer_car_vin',
           'input#customer_car_gv_number',
           'input#customer_car_name'
       ]
   };

    function searchAutocomplete(options){
            options.elements.forEach(function(elem){
                search(elem,options.url);
            })
    }

    function editEvent(){
        //Заполняем селекторы с боксами
        fillSelector('select#repair_box_id', resources, 'title', 'more'); // ремонтные боксы
        var selBoxVal = $('select#repair_box_id').val(); //Берем текущее значение бокса
        fillSelector('select#repair_post_id', resources, 'title', selBoxVal);//Ремонтные посты
        var type = getDataJson('connector.php?get=repairType', 'boxid=' + selBoxVal);   //Загружаем типы работ
        fillSelector('select#repair_type_id', type, 'name', 'more'); //заполняем Типы работ
        fillSelector('select#user_target_name', users, 'name', 'more'); //Заполняем механиков
        searchAutocomplete(searchElements);
        fillSelector('select#state', state, 'name', 'more');//Заполняем статус события
        $('#createEvent').modal('show');
    }
    
    
    $('#add_event_button').click(function () {
        //Заполняем селекторы с боксами
        fillSelector('select#repair_box_id', resources, 'title', 'more'); // ремонтные боксы
        var selBoxVal = $('select#repair_box_id').val(); //Берем текущее значение бокса
        fillSelector('select#repair_post_id', resources, 'title', selBoxVal);//Ремонтные посты
        var type = getDataJson('connector.php?get=repairType', 'boxid=' + selBoxVal);   //Загружаем типы работ
        fillSelector('select#repair_type_id', type, 'name', 'more'); //заполняем Типы работ
        fillSelector('select#user_target_name', users, 'name', 'more'); //Заполняем механиков
        searchAutocomplete(searchElements);
        fillSelector('select#state', state, 'name', 'more');//Заполняем статус события
        $('#createEvent').modal('show');
    });

    $('#reload').off('click').on('click', function(){
        console.log('Обновление');
        $('#calendar').fullCalendar('refetchEvents');
    });

    console.log('Обновление');
    $('#calendar').fullCalendar('refetchEvents');

    $('#sendBtn').off('click').on('click', function(e){

        e.preventDefault();

        var formData = $('#createEventForm').serializeArray();

        // check form
        var result = {};
        formData.forEach(function(v){
            result[v.name] = v.value;

        });
        var formAnswer = getDataJson('connector.php?get=addEvent', result);

        jQuery.each(formAnswer, function(i, val) {

                if (val == false) {
                    $('.' + i).removeClass('has-success');
                    $('.' + i).addClass('has-error');
                    console.log(i + " " + val);

                } else {
                    $('.' + i).removeClass('has-error');
                    $('.' + i).addClass('has-success');
                    console.log(i + " " + val);
                }

                if (i == 'error_datetime' && val == 'end_times_longer') {
                    alert('Начальное время больше или равно конечному!');
                }
                if (i == 'error_datetime' && val == 'internal_error_wrong_format') {
                    alert('Внутренняя ошибка, формат времени!');
                }

            });
        console.log('Првиет');
        $('#calendar').fullCalendar('refetchEvents');
    });



});

