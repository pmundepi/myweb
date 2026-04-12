<?php
$honeypot = $_POST['website'] ?? '';
if(!empty($honeypot)) {
    http_response_code(200);
    echo "Message sent!";
    exit;
}

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $errors = [];
    if (empty($_POST['name'])) {
        $errors[] = "Name is required";
    }
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    if (empty($_POST['phone'])) {
        $errors[] = "Phone number is required";
    }
    if (empty($_POST['service'])) {
        $errors[] = "Service is required";
    }
    if (empty($_POST['message'])) {
        $errors[] = "Message is required";
    }

    // Process form data if no errors
    if (empty($errors)) {
        // Sanitize form data
        $name = htmlspecialchars($_POST['name']);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $phone = htmlspecialchars($_POST['phone']);
        $service = htmlspecialchars($_POST['service']);
        $message = htmlspecialchars($_POST['message']);

        // Send email
        $to = "santoshpant99@gmail.com";
        $subject = "New Inquiry For AceFidential Health";
        $body = "Name: $name\nEmail: $email\nPhone: $phone\nService: $service\nMessage: $message";
        $headers = "From: noreply@acefidential.com\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "CC: pmundepi05@gmail.com\r\n";

        if (mail($to, $subject, $body, $headers)) {
            echo "Thank you for your message. We will get back to you soon!";
        } else {
            echo "Oops! Something went wrong while sending the email.";
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo "$error<br>";
        }
    }
} else {
    // Not a POST request
    echo "This page should be accessed with a POST request.";
}
?>