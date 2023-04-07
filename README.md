# cursed-captcha
It's version of captcha made from compilation of weird images found on the internet. Uses only PHP sessions for handling id of given captcha. Maybe it is unsafe, but I did'n bypassed it yet.

I don't know why I did it.

## demo
[Try demo](https://koperek.top/captcha/example.html)

## how to use
1. Please don't.
2. but

### how to run client side
#### prepare front-end scripts
Copy 'client' directory content to your's project and include CSS style and JS script, eg.:
```html
<link rel="stylesheet" href="client/captcha.css"/>
<script src="client/captcha.js"></script>
```
Insert HTML of captcha:
```html
<div id="captcha">
      <div id="captcha-image">
        <img alt='' id="captcha-img"/>
        <div id="captcha-panels"></div>
      </div>
      <div id="captcha-question"></div>
      <div id="captcha-result"></div>
      <div id="captcha-submit" onclick="submitCaptcha()">SEND</div>
    </div>
```
 You can customize it, untill you keep structure and id's.
 Next, add button that opens popup:
 ```html
 <div onclick="openCaptcha()" id="captcha-open-button">
    Prove that you aren't robot
 </div>
```
Or you can use any element with `onclick="openCaptcha()"` or any other mothod that invocates `openCaptcha` function.

Now, you need to edit captcha.js file. All modyfications is two variables in first two lines.
* First - `targetUrl` - is URL that would be open after successful captcha solve
* Second - `captchaProviderUrl` - URL to server that can provide captchas and verify it solvings - look down to know how to run that server

#### prepare back-end script provided as `targetUrl`
In this script you mus call server (provided as `captchaProviderUrl`) with GET parameters:
- `action`, value is `confirm`
- `captcha_session` value is string provided to script by GET to this script by parameter `captcha_session`
In response you will get JSON with result code (4 is captcha resolved or 5 at captcha incorrect, look down at response codes table)
If you get code 4, you can execute own script, now confirmed by captcha. Simple example in PHP:
```php
$captchaProviderUrl = 'https://koperek.top/captcha/server/get_captcha.php';
$ch = curl_init();
$optArray = array(
  CURLOPT_URL => $captchaProviderUrl . '?action=confirm&captcha_session=' . $_GET['captcha_session'],
  CURLOPT_RETURNTRANSFER => true
);
curl_setopt_array($ch, $optArray);
$result = json_decode(curl_exec($ch), true);
if($result['code'] == 4)
  echo "Captcha confirmed on server side, congratulations!";
else
  echo "Captcha incorrect or session expired";
```
`$captchaProviderUrl` is our server.

### how to run server side
You can use my server (https://koperek.top/captcha/server/get_captcha.php), but I have only few captchas.
or host it by yourself. Just copy server/get_captcha.php and captchas directory (to same directory). And, Voilà!
#### get_captcha.php response codes
|Code|Action|Meaning|
|----|:----:|-------|
|0|create|session created successfuly|
|1|validate|captcha answer correct|
|2|validate|captcha answer incorrect|
|3|validate|captcha answers limit exceed|
|4|confirm|captcha confirmed|
|5|confirm|captcha rejected|

#### how to customize captchas
Add square, png-format image to `captchas/images`. Name it as number next at higgest number in files. For best results use 400x400px resolution. Next, create .json file (with same number). Fill it with:
```json
{"question": "little ducks", "correct":[3,4,6,8,10,12], "minimum": 16}
```
* question - what's on your's image, will be displayed as `Select squares with *question*`
* correct - numbers of squares that should be selected - counting flom left to right, up to down.
* minimum - is minimum of squares that must be selected correctly for pass the test. 16 means that all must be correct, 15 - you can make mistake by sellecting one square additional or not selecting one required.
*files must be named in sequence from 1*
Last step is set `$numOfCaptchas` variable in server script (`get_captcha.php`, 2nd line) to number of files.
