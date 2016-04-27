/**
 * Created by cshlovjah on 12.04.16.
 */
function getDataJson(urlSet, keysvalues) {
    console.log("Загрузка: " + urlSet);
    var response = false;
    $.ajax({
        type: 'POST',
        async: false,
        url: urlSet,
        data: keysvalues,
        success: function (data) {
            console.log(data);
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
                $(el).empty();
                _.each(data.children, function (data) {
                    console.log(data.id + " " + data.title);
                    $(el).append("<option value=" + data.id + ">" + data[nameField] + "</option>"); //data title
                });
            }
        });
    }
}

function resizeWorkspace() {
    //Пвто отступ модальной формы формы
    var onResize = function () {
        // apply dynamic padding at the top of the body according to the fixed navbar height
        $("body").css("padding-top", $(".navbar-fixed-top").height());
    };
    $(window).resize(onResize); // attach the function to the window resize event
    $(function () {
        onResize();
    });
}


function search(el, url) {

    var $el = $(el);

    $el.keyup(function () {
        var search = $el.val();

        $.ajax({
            type: "POST",
            url: url,
            async: false,
            // dataType: "jsonp",
            data: {"search": search, "context": el},
            cache: false,
            success: function (data) {
                $el.autocomplete({ source: data });
            }
        });

        return false;
    });
}
