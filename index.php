
<? session_start(); ?>
<? require_once "connection.php"; ?>
<? require_once "models.php"; ?>
<? require_once "general.php"; ?>

<? if(isset($_GET["destroy"])){ session_destroy(); } ?>
<? if(isset($_GET["init"])){ $_SESSION["user"] = true; } ?>
<? if(isset($_POST["json"])){ save($_POST["json"], $DB); } ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidad Veracruzana</title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jsapi.js"></script>
    <script type="text/javascript" src="/js/general.js"></script>
    <? $datos = new Experiencias_Preguntas($DB); ?>
    <? $preguntas = $datos->getPreguntas(); ?>
    <script type="text/javascript">
    <?= makeObject($preguntas, $DB); ?>
    </script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->    
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <img src="/img/uv.png" style="height:50px;width:50px;float:left;">
          <a class="navbar-brand" href="#">Universidad Veracruzana</a>
        </div>
        <div class="collapse navbar-collapse" style="float:right;background-color:#463265;">
          <ul class="nav navbar-nav" >
            <li class="active" style="background-color:#463265;"><a href="/index.php?destroy=true"  style="background-color:#463265;">Salir</a></li>
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
        <? if(isset($_POST["all_exp"]) or isset($_SESSION["gMaterias"])): ?>
            <? if(isset($_POST["all_exp"])) { $_SESSION["gMaterias"] = $_POST["all_exp"]; } ?>
            <script type="text/javascript">
              <? $claves = explode("|", $_SESSION["gMaterias"]); ?>
                var gMaterias = [
                    <? for($i=0;$i<count($claves);$i++): ?>
                        <? if($i === (count($claves) - 1)): ?>
                            <?= "'". urldecode($claves[$i]) ."'"; ?>
                        <? else: ?>
                            <?= "'". urldecode($claves[$i]) ."',"; ?>
                        <? endif; ?>
                    <? endfor; ?>
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
        <? else: ?>
          <?  if(!isset($_SESSION["user"])):  ?>
          <p class="well">
          	¿Deseas Realizar la Encuesta?
          </p>
          <p>
          	<a href="index.php?init=true" class="btn btn-primary" style="width:300px;"> Si</a>
          </p>
          <p >
          	<a href="http://www.uv.mx" class="btn btn-danger" style="width:300px;">No (regresar a la Pagina Principal)</a>
          </p>
          <? else: ?>
          	 <p class="well">
              Selecciona las Experiencias Educativas que Cursas este Semestre
            </p>
            <form class="form-horizontal" role="form" method="POST" action="/">
              <div id="msgerror" class="alert alert-danger" style="display:none;"></div>
              <? $exp = new Experiencias($DB); ?>
              <? $materias =  $exp->getExperiencies(); ?>
              <? for($i=1; $i<7; $i++): ?>
              <div class="form-group">
                <label class="col-lg-3 control-label">Experiencia <?= $i ?></label>
                <div class="col-lg-6">
                  <select id="<?= 'exp'. $i ?>" class="form-control" >
                    <option></option>
                    <? foreach ($materias as $pepe => $value): ?>
                      <option  value="<?= str_replace(" ", "_", utf8_encode($value)); ?>"> <?= utf8_encode($value) ?></option>
                    <? endforeach; ?>
                  </select>
                </div>
              </div>
              <? endfor; ?>
              <input id="all_exp" name="all_exp" type="hidden" >
              <input type="submit" class="btn btn-success" value="Continuar" >
            </form>
          <? endif; ?>
        <? endif; ?>
      </div>
    </div>
    <input type="hidden" id="std">
  </body>
</html>