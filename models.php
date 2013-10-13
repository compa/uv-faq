<?php
class Experiencias_Preguntas 
{
    private $exp = [];
    private $DeB;

    function __construct($DB) 
    {
        $this->DeB = $DB;
    }

    function getPreguntas()
    {
        try
        {
            $datos = [];
            foreach($this->DeB->query('SELECT * from experiencias_preguntas') as $fila)
            {
                $fila = array_map("utf8_encode", $fila);
                $datos[$fila[0]] = [];
                array_push($datos[$fila[0]], $fila[1], $fila[2],$fila[3],$fila[4],$fila[5],$fila[6], $fila[7]);
            }
            return $datos;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

class Experiencias {
	private $exp = [];
	private $DeB;

	function __construct($DB) 
    {
		$this->DeB = $DB;
    }

    function getExperiencies(){
   	    try
   		{
	   		foreach($this->DeB->query('SELECT * from experiencias ORDER BY nombre') as $fila)
            {
	           $exp[$fila[0]] = $fila[1];
            }
            return $exp;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}

class Experiencias_Calificaciones
{
    private $DB;
    function __construct($DB) 
    {
        $this->DB = $DB;
    }

    function getCalificaciones()
    {
        $estadisticas = [];
        try
        {
            $preg = [];
            foreach($this->DB->query('SELECT * from experiencias_calificaciones ORDER BY pregunta, calificacion') as $fila)
            {
                
                if(isset($preg[$fila[1]])) {
                    @$preg[$fila[1]][$fila[3]] += 1;
                } else {
                    $preg[$fila[1]][$fila[3]] = 1;
                }
            }
            return $preg;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
   }

   function save($pregunta, $materia, $calificacion)
   {

        $pregunta = utf8_decode(urldecode(str_replace("_", " ", $pregunta)));
        $materia = utf8_decode(urldecode(str_replace("_", " ",$materia)));
        $calificacion = utf8_decode(urldecode(str_replace("_", " ",$calificacion )));

        $sentencia = $this->DB->prepare("INSERT INTO experiencias_calificaciones (pregunta, experiencia, calificacion) 
                                       VALUES (:pre, :exp, :cal)");
        $sentencia->bindParam(':pre', $pregunta);
        $sentencia->bindParam(':exp', $materia);
        $sentencia->bindParam(':cal', $calificacion);
        $sentencia->execute();
   }
}

class Experiencias_Apoyos 
{
    private $exp = [];
    private $DB;

    function __construct($DB) 
    {
        $this->DB = $DB;
    }

    function getApoyos()
    {
        try
        {
            $apoyos = [];
            foreach($this->DB->query('SELECT * from experiencias_apoyos') as $fila)
            {
                if(isset($apoyos[$fila[1]])) {
                    $apoyos[$fila[1]] += 1;
                } else {
                    $apoyos[$fila[1]] = 1;
                }
            }
            return $apoyos;
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function save($exp)
    {
        $sentencia = $this->DB->prepare("INSERT INTO experiencias_apoyos (experiencia)
                                          VALUES ( :exp )");
        $sentencia->bindParam(':exp',  utf8_decode(urldecode(str_replace("_", " ", $exp))));
        $sentencia->execute();
   }
}



