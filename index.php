<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'function.php';

if (isset($_POST['submit'])) {
    $contact = new Contact();
    $result = $contact->contactUs($_POST);

    if ($result) {
        echo '
            <script>
                Swal.fire({
                    title: "Congrats",
                    text: "Data Successfully Logged",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    document.getElementById("registerForm").reset(); // Reset the form after successful submission
                });
            </script>';
    } else {
        echo '
            <script>
                Swal.fire({
                    title: "Oops",
                    text: "Something went wrong",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact Us</title>
</head>

<body>
    <form id="registerForm" method="post" role="form" autocomplete="off" class="my-form">
        <div class="inputBox input-Box-Size">
            <input type="text" name="firstName" required>
            <label>First Name</label>
        </div>
        <div class="inputBox input-Box-Size">
            <input type="text" name="lastName" required>
            <label>Last Name</label>
        </div>
        <div class="inputBox input-Box-Size">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>
        <div class="inputBox input-Box-Size">
            <input type="tel" name="phone" required>
            <label>Phone No.</label>
        </div>
        <div class="inputBox">
            <textarea name="message" cols="30" rows="8" placeholder="" required></textarea>
            <label>Enter your Message</label>
        </div>
        <div class="inputBox">
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const labels = document.querySelectorAll('label');
        labels.forEach((label) => {
            label.innerHTML = label.innerText
                .split('')
                .map((letter, i) => `<span style="transition-delay: ${i * 50}ms">${letter}</span>`)
                .join('');
        });

        const form = document.getElementById('registerForm');
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const inputs = form.querySelectorAll('input');
            const values = Array.from(inputs).map((input) => input.value);
            console.log(values);
            fetch('process.php', {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(response => response.text())
                .then(data => {
                    Swal.fire({
                        title: 'Congrats',
                        text: 'Data Successfully Logged',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        form.reset(); // Reset the form after successful submission
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Oops',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });
    });
    </script>

</body>

</html>