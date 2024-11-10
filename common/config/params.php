<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => env('SMTP_USERNAME'),
    'senderEmail' => env('SMTP_USERNAME'),
    'senderName' => env('APP_NAME') . ' Mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'generalTitle' => env('APP_NAME'),
    'demoCompany' => env('CUSTOMER'),
];
