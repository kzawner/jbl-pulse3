<?php
require_once __DIR__ . '/include/settings.php';

/**
 * Send order details to an email in case it could not be sent to CRM.
 *
 * @param array $data Order details.
 * @access protected
 * @return void
 */
function _report_order(array $data) {
  $mail_to = $GLOBALS['site_settings']['lead_email'];

  $details = array();
  foreach ($data as $key => $value) {
    $details[] = "$key: $value";
  }

  $message = "Review and process the next order manually:\n\n";
  $message .= "Order details:\n " . implode($details, "\n");
  $message .= "\n\nClient ip: " . $_SERVER['REMOTE_ADDR'];
  $message .= "\nServer host: " . $_SERVER['HTTP_HOST'];
  $subject = "New order - failed to send to CRM (" . implode($data, ", ") . ")";
  $r = mail($mail_to, $subject, $message);

  error_log("$subject");
}
// If $_POST is not empty, it should contain an order details.
// Currently it is sent either in case use has JS turned off or Bitrix lead
// interceptor plugin failed to sent the order details this falling back
// to form submit.
if ($_POST) {
  _report_order($_POST);
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>СПАСИБО, ВАШ ЗАКАЗ ПРИНЯТ!</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400|Montserrat:700' rel='stylesheet' type='text/css'>
    <style>
      @import url(//cdnjs.cloudflare.com/ajax/libs/normalize/3.0.1/normalize.min.css);
      @import url(//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css);
    </style>
    <link rel="stylesheet" href="default_thank_you.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>

  <?php
  include __DIR__ . '/include/all_codes.php';
  ?>
  </head>
  <body>
    <header class="site-header" id="header">
      <h1 class="site-header__title" data-lead-id="site-header-title">СПАСИБО, ВАШ ЗАКАЗ ПРИНЯТ!</h1>
    </header>

    <div class="main-content">
      <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
      <p class="main-content__body" data-lead-id="main-content-body">Наш менеджер свяжется с Вами по телефону для подтверждения заказа в ближайшее время. Спасибо!</p>
    </div>

    <footer class="site-footer" id="footer">
    <p class="site-footer__fineprint" id="fineprint">shopgodzilla.com.ua ©<?php print date("Y") ?> | Все права защищены</p>
    </footer>
  </body>
</html>
