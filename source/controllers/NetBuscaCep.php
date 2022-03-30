<?php

namespace Source\Controllers;

class NetBuscaCep
{
    private $cep;

    public function __construct(string $cep)
    {
        $aCep = preg_replace('/\D/', "", $cep);
        $this->cep = substr($aCep, 0, 5) . "-" . substr($aCep, 5, 9);
    }

    private function parseXML(string $data): array
    {
        $xml = new \SimpleXMLElement($data);
        $result = [];
        $result["erro"]        = ((string)$xml->erro[0] == 'true') ? true : false;
        $result["cep"]         = (string)$xml->cep[0];
        $result["logradouro"]  = (string)$xml->logradouro[0];
        $result["complemento"] = strlen($xml->complemento[0]) ? $xml->complemento[0] : '-';
        $result["bairro"]      = (string)$xml->bairro[0];
        $result["localidade"]  = (string)$xml->localidade[0];
        $result["uf"]          = (string)$xml->uf[0];
        $result["ibge"]        = ((int)$xml->ibge[0] > 0) ? (int)$xml->ibge[0] : 0;
        $result["gia"]         = ((int)$xml->gia[0] > 0) ? (int)$xml->gia[0] : 0;
        $result["ddd"]         = ((int)$xml->ddd[0] > 0) ? (int)$xml->ddd[0] : 0;
        $result["siafi"]       = ((int)$xml->siafi[0] > 0) ? (int)$xml->siafi[0] : 0;

        return $result;
    }

    public function fetchCep()
    {
        $cep = $this->cep;
        $url = "https://viacep.com.br/ws/{$cep}/xml";
        $content = file_get_contents($url);
        $viacep = $this->parseXML($content);
        return $viacep;
    }

    public function fetchXML(): string
    {
        $cep = $this->cep;
        $url     = "https://viacep.com.br/ws/{$cep}/xml";
        $content = file_get_contents($url);

        return $content;
    }

}