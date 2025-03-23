<?php 
global $_REQUEST;
$response = array('error' => '');
$contact_email = 'karthickop6@gmail.com';

// Check if POST data exists
if (!isset($_POST['data'])) {
    $response['error'] = 'Invalid request!';
    echo json_encode($response);
    die();
}

// Parse POST data
parse_str($_POST['data'], $post_data);

// Sanitize input
$user_name = isset($post_data['username']) ? stripslashes(strip_tags(trim($post_data['username']))) : '';
$user_email = isset($post_data['email']) ? stripslashes(strip_tags(trim($post_data['email']))) : '';
$user_subject = isset($post_data['subject']) ? stripslashes(strip_tags(trim($post_data['subject']))) : '';
$user_msg = isset($post_data['message']) ? stripslashes(strip_tags(trim($post_data['message']))) : '';

if (!empty($contact_email) && !empty($user_email) && !empty($user_msg)) {
    $subj = 'Message from TennisClub';
    $msg = "Name: $user_name\nEmail: $user_email\nSubject: $user_subject\nMessage: $user_msg";
    
    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "From: no-reply@yourdomain.com\r\n";
    $headers .= "Reply-To: $user_email\r\n";

    if (@mail($contact_email, $subj, $msg, $headers)) {
        $response['success'] = 'Message sent successfully!';
    } else {
        $response['error'] = 'Error sending message. Check mail server configuration!';
    }
} else {
    $response['error'] = 'Missing required fields!';
}

echo json_encode($response);
die();
?>