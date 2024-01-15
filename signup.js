
console.log(document.querySelector('input[name="error-controler"]'));
document.querySelector('input[name="error-controler"]').addEventListener('change', e =>{
    console.log(e.target.value);
});