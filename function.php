<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Contact
{
    private $host;
    private $user;
    private $password;
    private $db;
    private $port;
    public $mysqli;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'] ?? '34.71.246.178';
        $this->user = $_ENV['DB_USER'] ?? 'pantheon';
        $this->password = $_ENV['DB_PASSWORD'] ?? '';
        $this->db = $_ENV['DB_NAME'] ?? 'pantheon'; // Update the database name here
        $this->port = $_ENV['DB_PORT'] ?? '17050';

        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->db, $this->port);
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->mysqli->connect_error;
            exit();
        }

        // Test the database connection and query
        $query = "SELECT * FROM contact LIMIT 1";
        $result = $this->mysqli->query($query);

        if ($result) {
            $row = $result->fetch_assoc();
            var_dump($row); // Check the output in the browser console
        } else {
            echo "Error: " . $this->mysqli->error;
        }
    }

    public function contactUs($data)
    {
        $firstName = $this->mysqli->real_escape_string($data['firstName']);
        $lastName = $this->mysqli->real_escape_string($data['lastName']);
        $email = $this->mysqli->real_escape_string($data['email']);
        $phone = $this->mysqli->real_escape_string($data['phone']);
        $message = $this->mysqli->real_escape_string($data['message']);

        $query = "INSERT INTO contact (first_name, last_name, email, phone, message) VALUES ('$firstName', '$lastName', '$email', '$phone', '$message')";

        if ($this->mysqli->query($query)) {
            return true;
        } else {
            echo "Error: " . $this->mysqli->error;
            echo "Query: " . $query;
            return false;
        }
    }
}

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