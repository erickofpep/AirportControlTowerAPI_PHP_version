const RgstrPasswordIcon = document.querySelector('#RgstrPsswrdIcon');
const password = document.querySelector('#password');

RgstrPasswordIcon.addEventListener('click', function(e) {

    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye');
});

const RgstrCnfrmPsswrdIcon = document.querySelector('#RgstrCnfrmPsswrdIcon');
const confirm = document.querySelector('#confirm');
RgstrCnfrmPsswrdIcon.addEventListener('click', function(e) {

    const type = confirm.getAttribute('type') === 'password' ? 'text' : 'password';
    confirm.setAttribute('type', type);

    this.classList.toggle('fa-eye');
});