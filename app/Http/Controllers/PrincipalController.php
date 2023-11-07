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

	function __construct()
	{
		$this->complChor = 12; //menos que isso acessa o endString()
		$this->cifra = new CifraController();
		$this->texto = new TextoController();
		$this->auxiliar = new AuxiliarController();
		$this->analise = new AnaliseController();
			
			
	}
	
	public function recebetexto(Request $request){
		$this->cifra->setSemiTons($request['semiTons']); //criar um middleware para autenticar int|min=-11|max=11
		$this->texto->setTexto($request['aSeparar']);
		$this->loopTexto($this->texto->getTexto());
	}

	public function loopTexto($texto){
		echo $texto;
		$l = strlen($texto);
		
		for($i=0; $i<$l; $i++){
			$car = $texto[$i];
			if($car == ' '){
				$this->analise->statusAnalise = 'aberta';
				echo "-----------abriu princial!------------";
				continue;
			}
			if($this->analise->statusAnalise == 'aberta'){
				echo "-----------testado aberto : ..$car..";
					if(($car=="E")||($car == "A")){
						$this->texto->setEA($i);
					}
		
					if(in_array($car, $this->analise->naturais)){ 
						if($this->cifra->possivelInversao == 'nao'){ 
							echo "<br><br><br>aqui:..$car..<br><br><br>";
							$chor = substr($texto, $i, ($this->complChor+1)); 
							echo "<br/><br/><hr/>$chor será analisado";
							if($i >= $this->complChor){
								$rotacionar = $this->auxiliar->endString($chor) ;
								if($rotacionar == "positivo"){
									$this->analise->pre_positivo($chor, $this->cifra);//antes de encaminhar positivo(), análise recebe objeto.
								}else{
									$pularCaracteres = $this->analise->analisar1($this->cifra, $this->texto, $rotacionar);
									$i = ($i + $pularCaracteres);
								}
							}else{
								$pularCaracteres = $this->analise->analisar1($this->cifra, $this->texto, $chor);
								$i = ($i + $pularCaracteres);
							}
						}else{ //possível inversão.
							$this->cifra->defaultPossivelInversao();
						}					
					}////if ABCDEFG
					$this->analise->statusAnalise = 'fechada';
			}// se astatusAnalise aberta
		}//for() principal que define o $chor
	}//function loopTexto()

	
		
}
