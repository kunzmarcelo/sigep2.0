<?php

include_once "../modell/BancoDadosPDO.class.php";

$lote = new BancoDadosPDO();
if(isset($_GET['id'])){
   $cod = $_GET['id'];
   echo $lote->alterar("produto", "status='0'", "id_produto='$cod'");
}