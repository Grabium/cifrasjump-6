<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Controllers\TextoController;

class PrincipalController extends Controller
{
	private $texto;
	private $cifra;
	private $analise;
	private $auxiliar;
	private $conversor;

	function __construct()
	{
		$this->complChor = 12; //menos que isso acessa o endString()
		$this->cifra = new CifraController();
		$this->texto = new TextoController();
		$this->auxiliar = new AuxiliarController();
		$this->analise = new AnaliseController();
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
					//if($this->cifra->possivelInversao == 'nao'){ //talvez apagar pq apos positivo, a leitura pula.
						//echo "<br><br><br>aqui:..$car..<br><br><br>";
						$chor = substr($texto, $i, ($this->complChor+1)); 
						echo "<br/><br/><hr/>$chor será analisado<br>";
						//if($i >= $this->complChor){
							$rotacionar = $this->auxiliar->endString($chor) ;
							if($rotacionar == "positivo"){
								$this->analise->pre_positivo($chor, $this->cifra);//antes de encaminhar positivo(), análise recebe objeto.
							}else{
								$pularCaracteres = $this->analise->analisar1($this->cifra, $this->texto, $rotacionar); //aqui, $rotacionar = $chor.' ';
								$i = ($i + $pularCaracteres);
							}
						/*}else{
							$pularCaracteres = $this->analise->analisar1($this->cifra, $this->texto, $chor);
							$i = ($i + $pularCaracteres);
						}*/
					
						

					/*
					}else{ //possível inversão.
						$this->cifra->defaultPossivelInversao();
					}				*/
					
					if($this->analise->ordem == 'converter'){
						$this->conversor->conversor($this->cifra);
						$this->cifra->setCifraDefault();
					}
					
				}////if ABCDEFG
				$this->analise->ordem = 'fechada';
			}// se astatusAnalise aberta
		}//for() principal que define o $chor
	}//function loopTexto()

	
		
}
