$(function () { // document ready

    $('#calendar').fullCalendar({
        schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
        now: new Date(),
        height: 700,
        editable: true, // enable draggable events
        aspectRatio: 1.8,
        scrollTime: '00:00', // undo default 6am scrollTime
        header: {
            left: 'today prev,next',
            center: 'title',
            right: 'timelineDay,timelineThreeDays,agendaWeek,month'
        },
        timeFormat: 'H:mm',
        monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthNamesShort: ['Янв.', 'Фев.', 'Март', 'Апр.', 'Май', 'Июнь', 'Июль', 'Авг.', 'Сент.', 'Окт.', 'Ноя.', 'Дек.'],
        dayNames: ["Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота"],
        dayNamesShort: ["ВС", "ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ"],
        buttonText: {
            prev: "Назад",
            next: "Вперед",
            prevYear: "Предыдущий год",
            nextYear: "Следующий год",
            today: "Сегодня",
            month: "Месяц",
            week: "Неделя",
            day: "День"
        },
        defaultView: 'timelineDay',
        views: {
            timelineThreeDays: {
                type: 'timeline',
                duration: {days: 3}
            },
        },

        resourceLabelText: 'Боксы и посты',

        resources: { // you can also specify a plain string like 'json/resources.json'
            url: 'connector.php?get=resources',
            //url: 'json/resources.json',
            error: function () {
                $('#script-warning').show();
            }
        },

        events: { // you can also specify a plain string like 'json/events.json'
            url: 'connector.php?get=events',
            //url: 'json/events.json',
            error: function () {
                $('#script-warning').show();
            }
        },

        eventMouseover: function (event, jsEvent) {
            var tstart = new Date(event.start);
            var start=tstart.toLocaleTimeString();

            var tend = new Date(event.end);
            var end=tend.toLocaleTimeString();

            var tooltip = '<div class="tooltipevent panel panel-primary" style="position:absolute;z-index:10001;">' +
                '<div class="panel-body">Событие #' + event.id + ' ' + event.event_name + '' +
                '</div><div class="panel-footer">' +
                '<a>Время: </a>'+ start +' до ' + end + '<br>' +
                '<a>Заказчик: </a>' + event.customer_name + '<br>'+
                '<a>Исполнитель: </a>'+ event.mechanic + '<br>' +
                '<a>Название авто: </a>'+ event.customer_car_name + '<br>' +
                '<a>Гос номер: </a>'+ event.customer_car_gv_number + '<br>' +
                '<a>VIN: </a>'+ event.customer_car_vin + '<br>' +
                '<a>Километраж: </a>'+ event.customer_car_mileage + '<br>' +

                '</div></div></div>';

            $("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltipevent').fadeIn('500');
                $('.tooltipevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltipevent').css('top', e.pageY + 10);
                $('.tooltipevent').css('left', e.pageX + 20);
            });
        },

        eventMouseout: function (event, jsEvent) {
            $(this).css('z-index', 8);
            $('.tooltipevent').remove();
        },

        eventClick: function (event) {
            console.log(event.id);
            editEvent();
        }
    });

});
