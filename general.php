<?php
function getEst($g){
    $sas = "";    
    $pepe = [];
    foreach ($g as $key => $value) {
        $sas .= $key . "^";
        foreach ($value as $keyGC => $valueGC) {
            $sas .= $keyGC . "|". $valueGC .";";
            
        }
        $sas .= "~";
    }
    return utf8_decode($sas);
}

function save($json , $DB){
	try
  	{
    	$ConBA = new Experiencias_Calificaciones($DB);
    	$ConEA = new Experiencias_Apoyos($DB);
    	for($i=1;$i<count($json)+1;$i++)
    	{
        	$json_ = $json[$i];
        	if($json_["type"] == "CB-E"){
            	$apoyos = $json_["answers"][0];
            	foreach($apoyos as $indice => $valor)
            	{
                	$ConEA->save($indice);  
            	}   
        	} else {
            	$expe = $json_["answers"][0];
            	foreach($expe as $indice => $valor)
            	{
                	$ConBA->save($i, $indice, $valor);  
            	}
        	}
    	}
    	$info = $ConEA->getApoyos();
    	$pepe = [];
    	foreach($info as $indice => $valor)
    	{
      		$pepe[] = $indice."|".$valor;
    	}
    	$g= $ConBA->getCalificaciones();

    	print_r(utf8_encode(implode(";", $pepe)));
    	print_r("#");
    	print_r(getEst($g));
    	session_destroy();
    	die();
    } 
    catch (Exception $e) 
    {
      echo 'Something is wrong';
  	}

}

function number_q( $arre)
{
	$num = 0;
	for ($u = 0; $u <count($arre); $u++)
	{
		if($arre[$u] != ""){
			$num++;
		}
	}
	return $num;
}

function makeObject($preguntas){
	$strOb = "var _ = {";
    for($i=1;$i<=count($preguntas);$i++)
    {
    	$strOb .=  $i.": {";
        $strOb .=  "'question' : '". $preguntas[$i][0] ."',";
        $strOb .=  "'options':[";
    	for($j=1;$j<6;$j++)
    	{
            if($preguntas[$i][$j]!="")
            {
            	$strOb .= "'". $preguntas[$i][$j] ."'"; 
            	$strOb .= ","; 

            }
    	}
    	$strOb = rtrim($strOb, ",");
        $strOb .= "],";
        $strOb .= "'type' : '".$preguntas[$i][6]."',";
        $strOb .= "'answers' : ''";
        $strOb .= "}";
        if ($i != count($preguntas)){
        	$strOb .= ",";	
        }
    }
    $strOb .= "};";
    return $strOb;
}