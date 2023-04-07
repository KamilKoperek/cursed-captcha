<?php
  $numOfCaptchas = 6;
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');
  $output = array();
  if($_GET['action'] == 'create') {
    session_start();
    $_SESSION['passed'] = false;
    $id = rand(1, $numOfCaptchas);
    $_SESSION['captcha_id'] = $id;
    $_SESSION['attempts_left'] = 3;
    $captcha_data = json_decode(file_get_contents("captchas/data/$id.json"), true);
    $output = ['code'=>0, 'question'=>$captcha_data['question'], 'image'=>base64_encode(file_get_contents("captchas/images/$id.png")), 'captcha_session'=>session_id()];
  }
  if($_GET['action'] == 'validate') {
    session_id($_GET['captcha_session']);
    session_start();
    $_SESSION['attempts_left']--;
    if($_SESSION['attempts_left'] > 0) {
      $id = $_SESSION['captcha_id'];
      $captcha_data = json_decode(file_get_contents("captchas/data/$id.json"), true);
      $answer = json_decode($_GET['answer'], true);
      $correct = 0;
      for($i = 1; $i <= 16; $i++) {
        if($answer[$i-1] == in_array($i, $captcha_data['correct']))
            $correct++;
      }
      if($correct >= $captcha_data['minimum']) {
        $output['code'] = 1;
        $_SESSION['passed'] = true;
      } else
        $output['code'] = 2;
    } else
      $output['code'] = 3;
  }
  if($_GET['action'] == 'confirm') {
    session_id($_GET['captcha_session']);
    session_start();
    if($_SESSION['passed'])
      $output['code'] = 4;
    else
      $output['code'] = 5;
    session_destroy();
  }

  echo json_encode($output);
