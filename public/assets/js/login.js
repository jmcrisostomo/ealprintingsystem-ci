let input_password = document.querySelector('[name="password"]');
let input_username = document.querySelector('[name="username"]');

let btn_eye = document.getElementById('btnEye');

input_username.focus();

btn_eye.addEventListener('click', () => {

    let eye = btn_eye.querySelector('.fa');

    let span = btn_eye.querySelector('span');

    if (eye.classList.contains('fa-eye-slash') == true) {

        input_password.setAttribute('type', 'text');
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');

    } else {

        input_password.setAttribute('type', 'password');
        eye.classList.add('fa-eye-slash');
        eye.classList.remove('fa-eye');

    }
});

let btnLogin = document.getElementById('btnLogin');


btnLogin.addEventListener('click', () => {

  btnLogin.classList.add("disabled");
  btnLogin.innerHTML = "Loading...";


  let username = document.getElementById('username');
  let password = document.getElementById('password');

  if ( username.value == '' ) {
    utils.toast({
      isWarning: true,
      msg: "Username cannot be empty.",
    });
    btnLogin.classList.remove("disabled");
    btnLogin.innerHTML = btnLogin.getAttribute("val");
  } else if ( password.value == '' ) {
    utils.toast({
      isWarning: true,
      msg: "Password cannot be empty",
    });
    btnLogin.classList.remove("disabled");
    btnLogin.innerHTML = btnLogin.getAttribute("val");
  } else {
    let formData = new FormData();
    formData.append('username', username.value);
    formData.append('password', password.value);
    let xhrPepoLogin = new XMLHttpRequest();
    let formDataURL = window.location.origin + "/auth/login/";
    let redirect = window.location.origin + "/";
    xhrPepoLogin.open('POST', formDataURL, true);
    xhrPepoLogin.onload = function() {

      btnLogin.classList.remove("disabled");
      btnLogin.innerHTML = btnLogin.getAttribute("val");

      if(this.readyState == 4 && this.status == 200)
      {


        let json = JSON.parse(this.response);
        let isWarning = false;
        // console.log(json.message);

        // let json = JSON.parse();
        console.log(this.response);

        if (json.status_code == "200" || json.status_code == "201") isWarning = false;
        else isWarning = true;

        if ("redirect" in json) {

          utils.goTo({url: redirect + json.redirect});

        } else {
          utils.toast({
            isWarning: isWarning,
            msg: json.description,
          });
        }

      }

      else
      {
        alert('Something went wrong, please contact us through https://pepo.iamtechinc.com/contact-us/');
      }
    }
    xhrPepoLogin.send(formData);
  }


    
});


document.body.onkeyup = function(event) {
  event.stopPropagation();

  if (event.which == 13)
    btnLogin.click();

};

/**
 *
 * Inputmask Regex config
 *
 */

let inputmaskAllowedCharacter = new Inputmask({
    placeholder: "",
    regex: String.raw`^[a-zA-Z\d\-_.,!?@#$%^&*()=+~\s]+$`
});
document.querySelectorAll('input').forEach((elem, index) => {
  inputmaskAllowedCharacter.mask(elem);
});


const removeNotAllowedCharacters = (e) => {
    let array_keycodes = [60, 62, 124, 47, 92, 96, 126, 59, 58, 188, 190, 220, 191, 192, 186, 219, 221];

    var e = window.event || e;
    var key = e.keyCode;

    // console.log({ array_keycodes })
    // console.log(key)
    // console.log(array_keycodes.includes(key))

    if (array_keycodes.includes(key)) {
        e.preventDefault();
    }
}