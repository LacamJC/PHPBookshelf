const password_input = document.getElementById('password');
const confirm_input = document.getElementById('confirm');
const checkbox = document.getElementById('show');

checkbox.addEventListener('click', () => {
    if(checkbox.checked){
        password_input.type = 'text';
        confirm_input.type = 'text';
    }else{
        password_input.type = 'password';
        confirm_input.type = 'password';
    }
})