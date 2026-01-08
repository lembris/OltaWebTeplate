<?php

// application/config/email.php

$config = array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_user' => 'lembris.internet@gmail.com', // Your Gmail address
    'smtp_pass' => 'oaau mhwh fevr fhhy',  // Your Gmail password or an app-specific password
    'mailtype' => 'html',
    'charset' => 'utf-8',
    'smtp_crypto' => 'tls',  // Enable TLS encryption
    'newline' => "\r\n",     // Use double quotes to comply with RFC 822 standard
);
