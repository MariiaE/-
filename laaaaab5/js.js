
const form = document.getElementById('myForm');


function getFormValue(event) {
    event.preventDefault();
    const name = form.querySelector('[name="address"]');

    const address = {
        name: name.value
    };
     console.log(address);
}

form.addEventListener('submit', getFormValue);

postData('./in3.php', {
    address: address
})
    .then((data) => {
        console.log(data);
        message.innerHTML = `<span >
            <b>${data.answer}<br>
            
        </span>`
    })
    .catch(() => {
        message.innerHTML = '<span class="error">Проверьте данные!</span>'
    })