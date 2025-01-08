<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotCreatedException extends Exception
{
    protected $message = 'O produto não foi criado.';
}
