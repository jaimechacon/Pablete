
<div class="row col-sm-12">
  <form class="form-signin text-center" action="<?php echo base_url();?>Login/ingresar" method="POST">
    <a class="navbar-brand" href="<?php echo base_url();?>Inicio">
      <img class="mb-4" src="<?php echo base_url();?>/assets/img/logo.png" alt="" width="150">
    </a>
    <h1 class="h3 mb-3 font-weight-normal">Inicio sesi&oacute;n</h1>
    <?php if(isset($message)) {
    echo '<div class="alert alert-danger" role="alert">'.$message.'</div>';
    }
    ?>
    <label for="email" class="sr-only">Correo</label>
    <input type="email" id="email" name="email" class="form-control" placeholder="Correo" required autofocus>
    <label for="contrasenia" class="sr-only">Password</label>
    <input type="password" id="contrasenia" name="contrasenia" class="form-control" placeholder="Contrase&ntilde;a" required>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="recordar"> Recordar contrase&ntilde;a
      </label>
    </div>
    <div style="margin-bottom: 15px;" id="captcha" class="g-recaptcha" data-sitekey="6LeXRPAUAAAAAB1HKTNrhEHbyjGG1g_sfnxp2J_j"></div>
    <button id="iniciarSesion" name="iniciarSesion" class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesi&oacute;n</button>
    <p class="mt-5 mb-3 text-muted">&reg; Ministerio de Salud - Sistema de Reportes 2019</p>
  </form>
</div>