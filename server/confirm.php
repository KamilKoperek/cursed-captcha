<?php
$ch = curl_init();
$optArray = array(
  CURLOPT_URL => 'https://koperek.top/captcha/get_captcha.php?action=confirm&captcha_session=' . $_GET['captcha_session'],
  CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array($ch, $optArray);
$result = json_decode(curl_exec($ch), true);
if($result['code'] == 4) {
  echo "Captcha confirmed on server side, congratulations!";
} else {
  echo "Captcha incorrect or session expired";
}

?>
