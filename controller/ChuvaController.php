<?php
require_once "../model/conexao.php";
require_once "../model/ChuvaModel.php";

class ChuvaController
{
    private $model;
    private $mysqli;

    public function __construct()
    {
        $db = new db();
        $this->mysqli = $db->conecta_mysql();
        $this->model = new ChuvaModel($this->mysqli);
    }

    // O controller agora APENAS retorna os dados
    public function index()
    {
        // Sem API, pop_api = 0
        $pop_api = 0;

        // Retorna o resultado (não chama a view)
        return $this->model->calcularProbabilidadeChuva($pop_api);
    }
}
