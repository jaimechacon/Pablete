<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistema de Reportes Minsal</title>
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>/assets/img/package.ico">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
  <?php if($login == 1): ?>
  <link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/examples/sign-in/signin.css" rel="stylesheet">
  <?php endif; ?>
  <!--<link href="<?php //echo base_url();?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />-->
  
  <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>  

  <!--<link href="<?php //echo base_url();?>assets/css/main-style.css" rel="stylesheet" />-->
</head>
  <body class="text-center fondo">