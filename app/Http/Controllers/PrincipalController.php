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
		echo $texto;
		$l = strlen($texto);
		
		for($i=0; $i<$l; $i++){
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
					echo "<br/><br/><hr/>$chor será analisado<br>";
					$rotacionar = $this->auxiliar->endString($chor) ;
					if($rotacionar == "positivo"){
						$this->analise->pre_positivo($chor, $this->cifra);//antes de encaminhar positivo(), análise recebe objeto.
					}else{
						$pularCaracteres = $this->analise->analisar1($this->cifra, $this->texto, $rotacionar); //aqui, $rotacionar = $chor.' ';
						$i = ($i + $pularCaracteres);
					}
					if($this->analise->ordem == 'converter'){
						$this->conversor->conversor($this->cifra);
						$this->cifra->setCifraDefault();
					}
				}////if ABCDEFG
				$this->analise->ordem = 'fechada';
			}// se ordem == aberta
		}//for() principal que define o $chor
	}//function loopTexto()

	
		
}//class
