<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrincipalController extends Controller
{
	private $texto;
	private $cifra;
	private $analise;
	private $auxiliar;
	private $conversor;

	function __construct()
	{
		$this->complChor = 12; //$chor terá essa quantidade de caracteres
		$this->cifra = new CifraController();
		$this->texto = new TextoController();
		$this->analise = new AnaliseController();
		$this->auxiliar = new AuxiliarController();
		$this->conversor = new ConversorController();
	}
	
	public function recebetexto(Request $request){
		$this->conversor->setSemiTons($request['semiTons']); //criar um middleware para autenticar int|min=-11|max=11
		$this->texto->setTexto($request['aSeparar']);
		$this->loopTexto($this->texto->getTexto());
	}

	public function loopTexto($texto){
		echo $texto.'<br><br>';
		$l = strlen($texto);
		
		for($i=0; $i<$l; $i++){

			
			/*
			static $y = 0;
			echo "<br>i: $i - y: $y.";
			if($i != $y){
				echo "<br> i ($i) != y ($y). ";
			}
			$y ++;
			*/
			
			$car = $texto[$i];
			if($car == ' '){
				$this->analise->ordem = 'aberta';
				continue;
			}
			if($this->analise->ordem == 'aberta'){
				if(($car=="E")||($car == "A")){
					$this->texto->setEA($i);
				}
	
				if(in_array($car, $this->analise->naturais)){ 
					$chor = substr($texto, $i, ($this->complChor+1)); 
					
					//echo "<br/><br/><hr/>$chor será analisado<br>";
					//$rotacionar = $this->auxiliar->endString($chor);
					
					$chor = $chor . " ";
					echo "<br>Antes de strpos: ..$chor..";
					//echo "rotacionar = .$rotacionar.";
					$chor = substr($chor, 0, (1+strpos($chor, " ")));
					echo "rotacionar substr = ..$chor..";
					$this->texto->setLocalen($i, strlen($chor));
					//var_dump($this->texto->getLocaLen());
					if(strlen($chor) == 2){  //quando o ultimo caractere, sozinho, é um acorde. 
						//echo "-->posi";
						$this->analise->pre_positivo($chor, $this->cifra);//antes de encaminhar positivo(), análise recebe objeto.
					}else{
						//echo "-->1";
						$pularCaracteres = $this->analise->analisar1($this->cifra, $this->texto, $chor); //aqui, $rotacionar = $chor.' ';
						$i = ($i + $pularCaracteres);
					}
					if($this->analise->ordem == 'converter'){ //se foi positivo.
						$nChord = $this->conversor->conversor($this->cifra);
						echo "<br>array guarda cifra: ";
						print_r($this->cifra->guardaCifras); //a array foi limpa em conversor()
						//str_replace($chor, $this->cifra->guardaCifras, $texto);
						$this->texto->texto = $this->texto->converterTexto($nChord);
						//teste até o echo.
						$final = $this->texto->getTexto();
						ECHO "<br>texto final: ..$final..<br><br>";
						$this->cifra->setCifraDefault();
					}
				}////if ABCDEFG
				$this->analise->ordem = 'fechada';
			}// se ordem == aberta
		}//for() principal que define o $chor
		
	}//function loopTexto()

	
		
}//class
