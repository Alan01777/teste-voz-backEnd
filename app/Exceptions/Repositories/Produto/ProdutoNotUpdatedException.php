<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotUpdatedException extends Exception
{
    protected $message = 'O produto não foi atualizado.';
}
