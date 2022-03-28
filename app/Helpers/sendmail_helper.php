<?php

/* Send email */
function sendmail(array $data)
{
  $email = \Config\Services::email();
  $email->setFrom('masfendypurnomo@gmail.com', 'Fendy Purnomo');
  $email->setTo($data['email']);
  $email->setSubject($data['subject']);
  $email->setMessage($data['messages']);

  $email->initialize([
    'protocol' => 'smtp',
    'mailPath' => '/usr/sbin/sendmail',
    'SMTPHost' => 'smtp.googlemail.com',       // or smtp.gmail.com
    'SMTPUser' => 'masfendypurnomo@gmail.com',
    'SMTPPass' => 'Fendy@Google.234',
    'SMTPCrypto' => 'ssl',                     // or tls
    'SMTPPort' => 456,                         // or 587
    'SMTPTimeout' => 60,
    'wordWrap' => true,
    'mailType' => 'html',
    'charset' => 'UTF-8'
  ]);

  if ($email->send()) return true;
  return $email->printDebugger(['headers']);
}