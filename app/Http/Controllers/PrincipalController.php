<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrincipalController extends Controller
{
	private $texto;
	private $cifra;
	private $analise;
	private $conversor;

	function __construct()
	{
		$this->complChor = 12; //$chor terá essa quantidade de caracteres
		$this->cifra = new CifraController();
		$this->texto = new TextoController();
		$this->analise = new AnaliseController();
		$this->conversor = new ConversorController();
	}
	
	public function recebetexto(Request $request){
		$this->conversor->setSemiTons($request['semiTons']); //criar um middleware para autenticar int|min=-11|max=11
		$this->texto->setTexto($request['aSeparar']);
		$this->loopTexto($this->texto->getTexto());
	}

	public function loopTexto($texto){
		/*TESTE*/echo '<br><br><br><br><br><br><br>'.$texto.'<br><br>';
		$l = strlen($texto);
		
		for($i=0; $i<$l; $i++){//faz a leitura do texto
			$car = $texto[$i];
													 $p=$this->analise->ordem;settype($p, 'string'); echo "<br>car:..$car...e ordem:..$p<br>";
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
					$chor = $chor . " ";
					$chor = substr($chor, 0, (1+strpos($chor, " ")));
					echo "<br><br><hr>analizando chor:..$chor..";
					if(strlen($chor) == 2){  //quando o ultimo caractere, sozinho, é um acorde. 
						$this->analise->pre_positivo($chor, $this->cifra, $this->texto);//antes de encaminhar positivo(), análise recebe objeto.
					}else{
						$this->analise->analisar1($this->cifra, $this->texto, $chor);
						/*TESTE*/echo "<br><br>I:..$i..";
						$i = ($i + $this->analise->pularCaracteres);
						/*TESTE*/$pc = $this->analise->pularCaracteres;settype($pc, 'string');echo " + pula caracteres: ..$pc.. = I: ..$i..";
					}
					if($this->analise->ordem == 'converter'){ //se foi positivo.
						$nChord = $this->conversor->conversor($this->cifra);
					}
					$this->cifra->setCifraDefault($this->analise);
				}////if ABCDEFG
			}// se ordem == aberta
			$concat = ($this->analise->ordem == 'converter')?'concatConvertido':'concatITexto';
			$par = ($this->analise->ordem == 'converter')?[$i, $nChord]:[$i];
			$par[] = ($this->analise->ordem != 'fechada')?" ":"";//sem isso o espaço não é devolvido.
			$this->texto->$concat($par);
			$this->analise->ordem = 'fechada';
		}//for() principal que define o $chor
		$tc = $this->texto->getTextoConvertido();
		echo "<br><strong>Texto concatenado:..$tc..</strong>";
	}//function loopTexto()
	
	
		
}//class
