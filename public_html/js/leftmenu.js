/**
 * Created by cshlovjah on 11.04.16.
 */
"use strict";
$(document).ready(function(){
    function initMenu(options) {
        var handleClickLeftMenu = function ($el, e) {
            e.preventDefault();

            $(options.menuSelector).removeClass(options.activeClassName);

            $el.addClass(options.activeClassName);
        };

        options.elementSelectors.forEach(function (selector) {
            var $el = $(selector);
            $el.click(handleClickLeftMenu.bind(null, $el));
        });
    }

    initMenu({
        activeClassName: "active",
        menuSelector: ".leftMenu",
        elementSelectors: [
            '#todayLeftMenu',
            '#weekLeftMenu',
            '#monthLeftMenu',
            '#siteLeftMenu'
        ]
    });

});
