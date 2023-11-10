<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AnaliseController extends Controller
{
  public $naturais = ['C','D','E','F','G','A','B'];
  private $numeros = ['2', '3', '4', '5', '6', '7', '9'];
  private $intComposto = ['0', '1', '2', '3', '4'];
  private $cifra;
  private $texto;
  public $parentesis = "fechado";
  public $ordem = 'aberta';

  function analisar1(CifraController $cifra, TextoController $texto, $chor)
  {
    $this->cifra = $cifra;
    $this->texto = $texto;
    $s = 1; //índice do $chor a ser analizado
    $ac = $chor[1]; //analizar este caractere dentro do $chor
    return AnaliseController::space($chor, $ac, $s);
  }

  function pre_positivo($chor, CifraController $cifra)
  {
    $this->cifra = $cifra;
    AnaliseController::positivo($chor);
  }

  function positivo($chor){
            static $contaAcordes = 1; //fim de teste
            echo "<br><font color='red'>$chor é o $contaAcordes ° acorde</font><br>";
    
    $this->ordem = 'converter';
    $positivo = $this->cifra->formataPositivo($chor); //array[2]
    $this->cifra->guardarCifras($positivo);
          
          print_r($this->cifra->guardaCifras);
          $contaAcordes ++;
  }

  function increm($chor, $s)
  { 
    $s ++;
    $ac = $chor[$s];
    AnaliseController::space($chor, $ac, $s);
  }

  function space($chor, $ac, $s)
  {
    echo "<br>ac = ..$ac..<br>s = $s<br>";var_dump($this->cifra);echo "<br><br>";
    if(($ac == ' ')||($this->cifra->invertido == 'sim')){ 
      if((($chor[0] == "E")||($chor[0] == "A"))&&(($s == 1)||(($s == 2)&&($chor[1] == 'm')))&&($this->cifra->invertido == 'nao')){
        $rotacionar = AuxiliarController::seEouA($this->texto->texto[$this->texto->ea -2], $chor, $s); //:array 
        $funcao = array_shift($rotacionar);
        AnaliseController::$funcao(...$rotacionar); //positivo(chor) || increm(chor, s)
      }else{
        $chor = substr($chor, 0, ($s));
        AnaliseController::positivo($chor);
      }
    }elseif(($ac == '#')||($ac == 'b')&&(($s == 1)||($this->cifra->dissonancia == "sim"))){
      AuxiliarController::processaSustenidoEBemol($this->cifra, $ac, $s);
      AnaliseController::increm($chor, $s);
    }elseif((($ac == 'm')&&($s == 1))&&($this->cifra->composto == "nao")||(($ac == 'm')&&($s == 2)&&($this->cifra->enarmonia == "sim")&&($this->cifra->composto == "nao"))){
      $this->cifra->terca = "testada";
      AnaliseController::increm($chor, $s);
    }elseif((($ac == '+')||($ac == '-'))&&(($s == 1)||($this->cifra->dissonancia == "sim"))&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      if($ac == '+'){
        $chor = AuxiliarController::repor($chor, $s);//array()
      }
      AnaliseController::increm($chor, $s);
    }elseif(($ac == '/')&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      $rotacionar = AuxiliarController::bar($this->cifra, $this->naturais, $chor, $ac, $s);
      $funcao = array_shift($rotacionar);
      AnaliseController::$funcao(...$rotacionar); //space( chor, ac s ) || increm(chor, s)
    }elseif(($ac == '(')&&($this->parentesis == "fechado")&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      $this->parentesis = "aberto";
      $rotacionar = AuxiliarController::parentesis($this->cifra, $chor, $ac, $s);
      if($funcao = array_shift($rotacionar)){
        AnaliseController::$funcao(...$rotacionar); //space( chor, ac s ) || increm(chor, s)
      }else{
        AnaliseController::negativo($chor);
      }
    }elseif(($ac == ')')&&($this->parentesis == "aberto")&&($this->cifra->composto == "nao")){
      $this->cifra->dissonancia = "nao";
      $this->parentesis = "fechado";
      AnaliseController::increm($chor, $s);
    }elseif(in_array($ac, $this->numeros)&&($this->cifra->dissonancia == "nao")&&($this->cifra->composto == "nao")){  //numeros de 2 a 9.
      AuxiliarController::numOk($this->cifra, $chor, $s);
      AnaliseController::increm($chor, $s);
    }elseif(($ac == "1")&&($this->cifra->dissonancia == "nao")&&($this->cifra->composto == "nao")){  //numero 1 para contruir 10 a 14
      AuxiliarController::compostoIncompleto($this->cifra);
      AnaliseController::increm($chor, $s);
    }elseif((in_array($ac, $this->intComposto))&&($this->cifra->composto == "sim")){  //numeros de 10 a 14
      AuxiliarController::compostoCompleto($this->cifra);
      AnaliseController::increm($chor, $s);
    }elseif(($ac == '|')&&($chor[$s+2] == 'd')&&((($s == 1)&&($this->cifra->enarmonia == "nao"))||(($s == 2)&&($this->cifra->enarmonia == "sim")))){
      $chor = AuxiliarController::seMarcado($this->texto->dimCli, $chor, $s); //array
      AnaliseController::increm($chor[0], $chor[1]);
    }elseif(($ac == '|')&&($chor[$s+2] == 's')&&((($s == 1)&&($this->cifra->enarmonia == "nao"))||(($s == 2)&&($this->cifra->enarmonia == "sim")))){
      $chor = AuxiliarController::seMarcado($this->texto->susCli, $chor, $s); //array
      AnaliseController::increm($chor[0], $chor[1]);
    }elseif(($ac == '|')&&($chor[$s+2] == 'm')&&((($s == 1)&&($this->cifra->enarmonia == "nao"))||(($s == 2)&&(($this->cifra->enarmonia == "sim")||($this->cifra->terca == "testada")))&&(($chor[$s+5] == '2')||($this->cifra->terca == "testada")))){ //ou impede menores com maj, mas aprova Cm7M
      $chor = AuxiliarController::seMarcado($this->texto->majCli, $chor, $s); //array
      AnaliseController::increm($chor[0], $chor[1]);
    }elseif(($ac == '|')&&($chor[$s+2] == 'g')&&((($s == 1)&&($this->cifra->enarmonia == "nao"))||(($s == 2)&&(($this->cifra->enarmonia == "sim")||($this->cifra->terca == "testada"))))){
      $chor = AuxiliarController::seMarcado($this->texto->augCli, $chor, $s); //array
      AnaliseController::increm($chor[0], $chor[1]);
    }elseif(($ac == '|')&&($chor[$s+2] == 'a')&&((($s == 1)&&($this->cifra->enarmonia == "nao"))||(($s == 2)&&(($this->cifra->enarmonia == "sim")||($this->cifra->terca == "testada"))))){
      $chor = AuxiliarController::seMarcado($this->texto->addCli, $chor, $s); //array
      AnaliseController::increm($chor[0], $chor[1]);
    }else{
      AnaliseController::negativo($chor);
    }
  }//space*/

  function negativo($chor)
  {
    $this->ordem = 'fechada';
    $this->parentesis = "fechado";
    $this->cifra->composto = "nao";
    $this->cifra->enarmonia = "nao";
    $this->cifra->dissonancia = "nao";
    $this->cifra->sustOuBemol = "natural";
    $this->cifra->sustOuBemolInv = "naturalInv";
    $this->cifra->possivelInversao = 'nao';
    echo "<br/><font color='red'>$chor não é acorde!.</font>";
    $pularCaracteres = strpos($chor, ' ');
    return $pularCaracteres;
  }
}//classe
