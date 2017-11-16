$(document).foundation();

Lyssal_AjaxPageLoader.initAjaxLinks();
Lyssal_AjaxPageLoader.TARGET_DEFAULT = $('#page-body');
Lyssal_AjaxPageLoader.LOADING_TYPE = Lyssal_AjaxPageLoader.LOADING_TYPE_LYSSAL_BLINKING;
Lyssal_AjaxPageLoader.AFTER_AJAX_LOADING_DEFAULT = function (element) {
    var targetElement = ($(element).is('[data-target]') ? $(element).attr('data-target') : Lyssal_AjaxPageLoader.TARGET_DEFAULT);

    $(targetElement).foundation();
    //Lyssal_Navigation.setStateUrl(Lyssal_AjaxPageLoader.getUrl(element));
};
