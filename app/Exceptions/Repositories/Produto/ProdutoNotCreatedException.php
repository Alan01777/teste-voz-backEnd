<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotCreatedException extends Exception
{
    protected $message = 'O produto não foi criado. Por favor, tente novamente ou entre em contato com o suporte.';
    protected $code = 400;
}
