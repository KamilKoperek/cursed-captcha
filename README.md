# cursed-captcha
It's version of captcha made from compilation of weird images found on the internet. Uses only PHP sessions for handling id of given captcha. Maybe it is unsafe, but I did'n bypassed it yet.

I don't know why I did it.

## demo
[Try demo](https://koperek.top/captcha/example.html)

## how to use
1. Please don't.
2. but

### how to run client side
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
    </div>```
 You can customize it, untill you keep structure and id's.
 Next, add button that opens popup:
 ```html
 <div onclick="openCaptcha()" id="captcha-open-button">
    Prove that you aren't robot
 </div>```
Or you can use any element with `onclick="openCaptcha()"` or any other mothod that runs open
