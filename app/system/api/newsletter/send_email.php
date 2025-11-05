<?php
include '../../cogs/db.php';
if(!empty($_POST['emails'])) {
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $html = $_POST['htmlMessage'];
  $cta = $_POST['cta'];

  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8\r\n";
  $headers .= "From: Newsletter <no-reply@yourdomain.com>\r\n";

  foreach($_POST['emails'] as $to) {
    $body = "
      <html>
      <body>
        <p>$message</p>
        $html
        " . (!empty($cta) ? "<p><a href='$cta' style='display:inline-block;padding:10px 15px;background:#4CAF50;color:#fff;border-radius:6px;text-decoration:none;'>Call To Action</a></p>" : "") . "
      </body>
      </html>";
    if ($env == 'production') {
      mail($to, $subject, $body, $headers);
    }
  }

  echo "Emails sent successfully!";
} else {
  echo "No recipients selected.";
}
?>
