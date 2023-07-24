// public/js/upload.js
const form = document.querySelector('form');

form.addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(form);

    axios.post('/upload-pdf', formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
    .then(response => {
        const messageDiv = document.getElementById('response-message');
        messageDiv.innerText = response.data.message;
        form.reset();
    })
    .catch(error => {
        console.error(error);
        const messageDiv = document.getElementById('response-message');
        messageDiv.innerText = 'An error occurred while uploading the PDF.';
    });
});
