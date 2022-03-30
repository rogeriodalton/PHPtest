<?php

namespace Source\Controllers;

use Source\Models\Cep;
use League\Plates\Engine;
use Source\Controllers\NetBuscaCep;

class Form
{
    /**
     * @var Engine
     */
    private $view;

    public function __construct($router)
    {
        $this->router = $router;

        $this->view = Engine::create(
            dirname( __DIR__, 2 ) . "/theme",
            "php"
        );

        $this->view->addData(["router" => $router]);
    }

    public function home(): void
    {
        echo $this->view->render("home", [
            "ceps" => (new Cep())->find()->order('cep')->fetch(true)
        ]);
    }

    public function create(array $data): void
    {
        $cepData = filter_var_array($data, FILTER_SANITIZE_STRING);
        $aCep = preg_replace('/\D/', "", $cepData["CEP"]);
        $aCep = substr($aCep, 0, 5) . "-" . substr($aCep, 5, 9);        

        if (in_array("", $cepData)) {
            $callback["message"] = message("Informe o CEP", "error");
            echo json_encode($callback);
            return;
        }
        
        $cep = (new Cep())->find("cep = :aCep", "aCep={$aCep}")->fetch();
        if (!empty($cep)) {
            $callback["message"] = message("CEP já cadastrado.", "error");
            echo json_encode($callback);
            return;
        }

        $netCEP = new NetBuscaCep($aCep);
        $aNetCep = $netCEP->fetchCep();
        
        if ($aNetCep['erro']==true) {
            $callback["message"] = message("CEP NÃO EXISTE.", "error");
            echo json_encode($callback);
            return;
        }
        
        $cep = new Cep();
        $cep->cep = $aNetCep["cep"];
        $cep->logradouro = $aNetCep['logradouro'];
        $cep->complemento = $aNetCep["complemento"];
        $cep->bairro = $aNetCep["bairro"];
        $cep->localidade = $aNetCep['localidade'];
        $cep->uf = $aNetCep['uf'];
        $cep->ibge = $aNetCep['ibge'];
        $cep->gia = $aNetCep['gia'];
        $cep->ddd = $aNetCep['ddd'];
        $cep->siafi = $aNetCep['siafi'];
        $cep->save();

        $callback["message"] = message("CEP cadastrado com sucesso", "success");
        $callback["cep"] = $this->view->render("cep", ["cep" => $cep]);
        echo json_encode($callback);        
    }

    public function delete(array $data): void
    {
        if (empty($data["id"])) {
            return;
        }
        $id = filter_var($data["id"], FILTER_VALIDATE_INT);
        $cep = (new Cep())->findById($id);
        if ($cep) {
            $cep->destroy();
        };

        $callback["remove"] = true;
        echo json_encode($callback);
    }
}