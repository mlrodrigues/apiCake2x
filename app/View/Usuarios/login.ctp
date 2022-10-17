<!doctype html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
  <?php echo $this->Html->charset(); ?>
	<title>Login :: Área administrativa</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
    echo $this->fetch('meta');
    echo $this->Html->meta('icon');
		echo $this->Html->css(array(
		    'admin/libs/bootstrap.min',
        'admin/libs/bootstrap-responsive.min',
        'admin/login'
    )), $this->fetch('css');
    echo $this->fetch('script');
  ?>

  <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
  <script>window.html5 || document.write('<script src="<?php echo $this->Html->url('/js/admin/libs/html5shiv.min.js') ?>"><\/script>')</script>
</head>
<body>
  <div class="container">
    <div class="content">
      <div class="row">
        <div class="login-form">
          <h2>Login</h2>
          <?php echo $this->Flash->render('auth') ?>
          <?php echo $this->Form->create('Usuario') ?>
            <fieldset>
              <?php echo $this->Form->input('usuario', array('placeholder' => 'Usuario', 'label' => false)) ?>
              <?php echo $this->Form->input('senha', array('placeholder' => 'senha', 'label' => false, 'type' => 'password')) ?>
              <button type="submit" class="btn btn-primary">login</button>
            </fieldset>
          <?php echo $this->Form->end() ?>
        </div>
      </div>
    </div>
  </div>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script><?php echo $this->Html->url('admin/libs/jquery-1.7.1.min') ?><\/script>')</script>

  <?php echo $this->Html->script(array('admin/libs/bootstrap.min')) ?>
</body>
</html>