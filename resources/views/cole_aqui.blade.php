@extends('top')
@section('content')
<br/><br/>
<h1>Cole o texto abaixo</h1>
<br/><br/>

<?php 
  $semiTons = 0;
?>

<form action="{{ route('recebetexto') }}" method='POST'>
@csrf

  <button id="diminuir" class="btn btn-danger" onclick="intervalo('-')">-</button>
  <input name="semiTons" id="semiTons" value={{ $semiTons }} />
  <button id="aumentar" class="btn btn-danger" onclick='intervalo("+")'>+</button>
  <button class="btn btn-danger" '>Alterar</button>
  <br/><br/>
  <textarea name="aSeparar" rows="40" cols="120" class="container-fluid -body-color"></textarea>
</form>

<script type="text/javascript">
function intervalo(operacao){
  event.preventDefault();
  var st = document.getElementById("semiTons").value;
  st = parseInt(st);
  if((st>-11)&&(operacao == "-")){
    st = st - 1;
  }else if((st<11)&&(operacao == "+")){
    st = st + 1;
  }
  document.getElementById("semiTons").value = st;
}
</script>

@endsection('content')