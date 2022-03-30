<?php

namespace Source\models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Cep
 * @package Source\models
 */
class Cep extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("cep", ["cep", "logradouro", "complemento", "bairro", "localidade", "uf", "ibge", "gia", "ddd", "siafi"]);
        //
    }
}