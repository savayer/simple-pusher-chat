<?php
  require __DIR__ . '/vendor/autoload.php';
  $dotenv = new Dotenv\Dotenv(__DIR__);
  $dotenv->load();

  $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    getenv('KEY'),
    getenv('SECRET'),
    getenv('APP_ID'),
    $options
  );
  
  $pusher->trigger('chat', 'new-message', $_POST);
?>

