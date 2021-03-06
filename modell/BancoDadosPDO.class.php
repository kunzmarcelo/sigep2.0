<?php

class BancoDadosPDO {

    protected $db;
    protected $base;

    function __construct() {
        try {
            $this->base = "sigep2";
            $this->db = new PDO("mysql:host=localhost;dbname=$this->base", "root", "");               
            return TRUE;
        } catch (PDOException $e) {
            return "<br> Erro na conexão " . $e->getMessage();
        }
    }

    function __get($atributo) {
        return $this->$atributo;
    }

    function __set($atributo, $valor) {
        $this->$atributo = $valor;
    }

    function inserir($tabela, $campos, $valores) {
        // mysql_set_charset('utf8');
        $sql = "insert into $tabela ($campos) values ($valores)";
        //  echo $sql;
        try {
            $resultado = $this->db->exec($sql);
            return true;
        } catch (PDOException $e) {
            return "<script> alert('Erro na inserção'); </script> " . $e->getMessage();
        }
    }

    function alterar($tabela, $campos_valores, $condicao) {
        // mysql_set_charset('utf8');
       
        $sql = "update $tabela set $campos_valores where $condicao ";
         //echo $sql;
        try {
            $resultado = $this->db->exec($sql);
            return true;
        } catch (PDOException $e) {
            return "<script> alert('Erro na alteração'); </script>  " . $e->getMessage();
        }
    }

    function excluir($tabela, $condicao) {
        $sql = "delete from $tabela where $condicao";
        //echo $sql;
        try {
            $resultado = $this->db->exec($sql);
            return true;
        } catch (PDOException $e) {
            return "<script> alert('Erro na exclusão'); </script>  " . $e->getMessage();
        }
    }

    function listarTodos($tabela) {
        // mysql_set_charset('utf8');
        $sql = "select * from $tabela";
        //echo $sql;
        try {
            $resultado = $this->db->query($sql);
            return $resultado;
        } catch (PDOException $e) {
            return "<script> alert('Erro na listagem'); </script>  " . $e->getMessage();
        }
    }

    function listarUm($tabela, $condicao) {
        //// mysql_set_charset('utf8');
        $sql = "SELECT * FROM $tabela WHERE $condicao";
        //echo $sql;
        try {
            $resultado = $this->db->query($sql);
            return $resultado;
        } catch (PDOException $e) {
            return "<script> alert('Erro na listagem'); </script>  " . $e->getMessage();
        }
    }

    function listarTodosMuitosParaMuitos($campos, $tabelas, $condicao) {
        //SELECT COUNT( validacao ) FROM atleta WHERE validacao =0;
        // mysql_set_charset('utf8');
        $sql = "SELECT $campos FROM $tabelas WHERE $condicao";
        //echo $sql .'<br>';

        try {
            $resultado = $this->db->query($sql);
            //print_r($resultado);
            return $resultado;
        } catch (PDOException $e) {
            return "<script> alert('Erro na listagem'); </script>  " . $e->getMessage();
        }
    }

    function listarTodosCondicao($tabela, $condicao) {
        //SELECT COUNT( validacao ) FROM atleta WHERE validacao =0;
        // mysql_set_charset('utf8');
        $sql = "SELECT * FROM $tabela WHERE $condicao";
        //echo $sql;

        try {
            $resultado = $this->db->query($sql);
            //print_r($resultado);
            return $resultado;
        } catch (PDOException $e) {
            return "<script> alert(' Erro na listagem'); </script>  " . $e->getMessage();
        }
    }

    function listarUmComLigacao($tabelaCampos, $tabela, $condicao) {
        // mysql_set_charset('utf8');
        $sql = "SELECT $tabelaCampos FROM $tabela WHERE $condicao";
//echo $sql;
        try {
            $resultado = $this->db->query($sql);
            return $resultado;
        } catch (PDOException $e) {
            return "<script> alert('Erro na listagem'); </script>  " . $e->getMessage();
        }
    }

    function __destruct() {
        $this->db = NULL;
        $this->base = '';
    }

}

?>
