var targetUrl = "https://koperek.top/captcha/server/confirm.php";
var captchaProviderUrl = "https://koperek.top/captcha/server/get_captcha.php"

var selected = Array(16).fill(false)
var session

function submitCaptcha() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var response = JSON.parse(xhttp.responseText)
      console.log(response)
      if(response["code"] == "1") {
        document.getElementById("captcha-result").innerHTML = "";
        window.location.href = targetUrl + "?captcha_session="+session;
      } else if(response["code"] == "2")
        document.getElementById("captcha-result").innerHTML = "Try again";
      else if(response["code"] == "3")
        openCaptcha()
    }
  };
  xhttp.open("GET", captchaProviderUrl + "?action=validate&answer="+JSON.stringify(selected)+"&captcha_session="+session, true);
  xhttp.send();
}

function generate() {
  selected.fill(false)
  var panels = document.getElementById("captcha-panels")
  panels.innerHTML = ""
  for(var i = 0; i < 16; i++) {
    panel = document.createElement("div")
    panel.className = "captcha-panel"
    panels.appendChild(panel)
  }
  document.querySelectorAll('.captcha-panel').forEach((item, i) => {
    item.addEventListener('click', event => {
      selected[i] = !selected[i]
      item.style.backgroundColor = selected[i] ? '#00900050' : 'transparent'
    })
  })
}

function openCaptcha() {
  generate()
  document.getElementById("captcha").style.display = "block"
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
       var captcha = JSON.parse(xhttp.responseText)
       session = captcha["captcha_session"]
       document.getElementById("captcha-img").src = "data:image/png;base64, " + captcha["image"]
       document.getElementById("captcha-question").innerHTML = "Select squares with&nbsp;<b>" + captcha["question"] + "</b>"
    }
  };
  xhttp.open("GET", captchaProviderUrl + "?action=create", true);
  xhttp.send();
}
