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
			$this->posicao = $i;
			
			if(($car=="E")||($car == "A")){
				$this->texto->setEA($i);
			}

			if(in_array($car, $this->analise->naturais)){ 
				if($this->cifra->possivelInversao == 'nao'){ 
					$chor = substr($texto, $i, ($this->complChor+1)); 
					echo "<br/><br/><br/><br/><br/><br/>$chor será analisado";
					if($i >= $this->complChor){
						if(($this->auxiliar->endString($chor)) == "positivo"){
							$this->analise->pre_positivo($chor, $this->cifra);//antes de encaminhar positivo(), análise recebe objeto.
						}else{
							$this->analise->analisar1($this->cifra, $this->texto, $chor);
						}
					}else{
						$this->analise->analisar1($this->cifra, $this->texto, $chor);
					}
				}else{ //possível inversão.
					$this->cifra->defaultPossivelInversao();
				}					
			}////if ABCDEFG
		}//for() principal que define o $chor
	}//function loopTexto()

	
		
}
