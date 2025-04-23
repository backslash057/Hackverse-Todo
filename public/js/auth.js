let form = document.querySelector(".form");
let error_frame = document.querySelector(".error_frame");

function display_result(message, positive) {
    error_frame.innerText = message;
    error_frame.style.display = "block";

    if(positive) error_frame.classList.toggle("positive");
}


function authenticate(path, datas) {
    fetch(path,
        {
            headers: {"Content-Type" : 'application/json'},
            method: "POST",
            body: JSON.stringify(datas)
        }
    ).then(response => response.json()
    ).then((data) => {
        if(data.success) {
            display_result(data.message, true);

            // redirect the user to home page
            setTimeout(() => {
                window.location.replace("/");
            }, 1000);
        }
        else display_result(data.message, false);
    })
    .catch(e => {
        // TODO: empty all the form entries here
        display_result("An error occured. Try again later", false);
    });
}


form.addEventListener("submit", event => {
    event.preventDefault();

    error_frame.style.display = "none";

    let formData = new FormData(event.target);
    let datas = {};
    
    formData.forEach((key, value) => {
        datas[value] = key;
    });

    authenticate(form.action, datas);
});