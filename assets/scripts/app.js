$(document).foundation();

var ajaxPageLoader = new AjaxPageLoader();
ajaxPageLoader.setDefaultTarget('#page-body');
ajaxPageLoader.setAfterAjaxLoadingEvent(function (ajaxLink) {
  var targetElement = ($(ajaxLink).is('[data-target]') ? $(ajaxLink).attr('data-target') : ajaxLink.getTargetElement());

  $(targetElement).foundation();
});
