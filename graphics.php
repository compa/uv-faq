<?php session_start(); ?>
<?php define("SUBPATH", "/Entre_Pares"); ?>
<?php if(isset($_GET["destroy"])){ session_destroy(); header('Location: '. SUBPATH . '/index.php'); } ?>
<?php require_once "connection.php"; ?>
<?php require_once "models.php"; ?>
<?php require_once "general.php"; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidad Veracruzana</title>
    <script type="text/javascript" src="<?= SUBPATH; ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?= SUBPATH; ?>/js/jsapi.js"></script>
    <script type="text/javascript" src="<?= SUBPATH; ?>/js/general.js"></script>
    <?php $datos = new Experiencias_Preguntas($DB); ?>
    <?php $preguntas = $datos->getPreguntas(); ?>
    <script type="text/javascript">
    <?= makeObject($preguntas, $DB); ?>
    </script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= SUBPATH; ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SUBPATH; ?>/css/style.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?= SUBPATH; ?>/js/html5shiv.js"></script>
      <script src="<?= SUBPATH; ?>/js/respond.min.js"></script>
    <![endif]-->    
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <img src="<?= SUBPATH; ?>/img/uv.png" style="height:50px;width:40px;float:left;">
          <a class="navbar-brand" href="#">Universidad Veracruzana</a>
        </div>
        <div class="collapse navbar-collapse" style="float:right;background-color:#463265;">
          <ul class="nav navbar-nav" >
            <li class="active" style="background-color:#463265;"><a href="<?= SUBPATH; ?>/index.php?destroy=true"  style="background-color:#463265;">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container">
      <div class="starter-template">
        <h3>Universidad Veracruzana</h3>
        <h4>Facultad de Contaduría y Administración</h4>
        <div class="clearfix"></div>
        <p>Programa Entre Pares</p>
        <hr>
        <div id="main-ask" class="well">
           <div id='main-graphics' style='width:100%;height:100%;display:inline;'>
              <button value='graph1' class='btn btn-warning' style='display:inline-block;'>Pregunta 1</button>
              <button value='graph2' class='btn btn-warning' style='display:inline-block;'>Pregunta 2</button>
              <button value='graph3' class='btn btn-warning' style='display:inline-block;'>Pregunta 3</button>
              <button value='graph4' class='btn btn-warning' style='display:inline-block;'>Pregunta 4</button>
              <button value='graph5' class='btn btn-warning' style='display:inline-block;'>Pregunta 5</button>
              <button value='graph6' class='btn btn-warning' style='display:inline-block;'>Pregunta 6</button>
              <button value='graph7' class='btn btn-warning' style='display:inline-block;'>Pregunta 7</button>
            </div>
            <div id='main-graphics-graph'  style='width:100%;height:100%;display:inline;'></div>
            <script>make_lis();</script> 
        </div>
      </div>
    </div>
    <input type="hidden" id="std" value="<?=getEstadisticas($DB);?>" >
  </body>
</html>