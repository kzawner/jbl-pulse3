function defer(method) {
  if (window.jQuery)
    method();
  else
    setTimeout(function() { defer(method) }, 50);
}

// Wraps bitrix interceptor plugin script to send user to the 'thank you' page
// after order is made.
(function() {
  function wrapper() {
    function toSuccessPage() {
      window.location = 'order-success.php';
    }

    var ajaxOrig = jQuery.ajax;
    jQuery.ajax = function (options) {
      var success = options['success'];
      options['success'] = function (data) {
        console.debug('the form successfully sent')
        success(data);
        // In case of error success() will just submit the form.
        if (jQuery.parseJSON(data)['ERROR'] == '') {
          toSuccessPage();
        };
      };
      ajaxOrig(options);
    }
    console.debug('jquery ajax() method patched')
  }

  defer(wrapper);
})();
