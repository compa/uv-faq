<?php session_start(); ?>
<?php define("SUBPATH", "/Entre_Pares"); ?>
<?php if(isset($_GET["destroy"])){ session_destroy(); header('Location: '. SUBPATH . '/index.php'); } ?>
<?php require_once "connection.php"; ?>
<?php require_once "models.php"; ?>
<?php require_once "general.php"; ?>
<?php if(isset($_GET["init"])){ $_SESSION["user"] = true; } ?>
<?php if(isset($_POST["json"])){ save($_POST["json"], $DB); } ?>
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
          <img src="<?= SUBPATH; ?>/img/uv.png" style="height:50px;width:50px;float:left;">
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
        <h4>Facultad de Sistemas</h4>
        <div class="clearfix"></div>
        <p>Programa Entre Pares</p>
        <hr>
        <?php if(isset($_POST["all_exp"]) or isset($_SESSION["gMaterias"])): ?>
            <?php if(isset($_POST["all_exp"])) { $_SESSION["gMaterias"] = $_POST["all_exp"]; } ?>
            <script type="text/javascript">
              <?php $claves = explode("|", $_SESSION["gMaterias"]); ?>
                var gMaterias = [
                    <?php for($i=0;$i<count($claves);$i++): ?>
                        <?php if($i === (count($claves) - 1)): ?>
                            <?= "'". urldecode($claves[$i]) ."'"; ?>
                        <?php else: ?>
                            <?= "'". urldecode($claves[$i]) ."',"; ?>
                        <?php endif; ?>
                    <?php endfor; ?>
                ];
            </script>
            <div id="main-ask" class="well">
              <p style="height:36px;">
                <input type="button" id="anterior"  class="btn btn-info" style="float:left;" value="Anterior" >
                <input type="button" id="siguiente" class="btn btn-info" style="float:right;" value="Siguiente" >
              </p>
              <div id="msgerror" class="alert alert-danger" style="display:none;"></div>
              <p id="pregunta">

              </p>
              <script type="text/javascript">
                var mov = new FQA();
              </script>
            </div>
        <?php else: ?>
          <?php  if(!isset($_SESSION["user"])):  ?>
          <p class="well">
          	¿Deseas Realizar la Encuesta?
          </p>
          <p>
          	<a href="<?= SUBPATH; ?>/index.php?init=true" class="btn btn-primary" style="width:300px;"> Si</a>
          </p>
          <p >
          	<a href="http://www.uv.mx" class="btn btn-danger" style="width:300px;">No (regresar a la Pagina Principal)</a>
          </p>
          <?php else: ?>
          	 <p class="well">
              Selecciona las Experiencias Educativas que Cursas este Semestre
            </p>
            <form class="form-horizontal" role="form" method="POST" action="<?= SUBPATH; ?>/">
              <div id="msgerror" class="alert alert-danger" style="display:none;"></div>
              <?php $exp = new Experiencias($DB); ?>
              <?php $materias =  $exp->getExperiencies(); ?>
              <?php for($i=1; $i<7; $i++): ?>
              <div class="form-group">
                <label class="col-lg-3 control-label">Experiencia <?= $i ?></label>
                <div class="col-lg-6">
                  <select id="<?= 'exp'. $i ?>" class="form-control" >
                    <option></option>
                    <?php foreach ($materias as $pepe => $value): ?>
                      <option  value="<?= str_replace(" ", "_", utf8_encode($value)); ?>"> <?= utf8_encode($value) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <?php endfor; ?>
              <input id="all_exp" name="all_exp" type="hidden" >
              <input type="submit" class="btn btn-success" value="Continuar" >
            </form>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>
    <input type="hidden" id="std">
  </body>
</html>