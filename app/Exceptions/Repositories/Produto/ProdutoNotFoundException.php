<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotFoundException extends Exception
{
    protected $message = 'O produto não foi encontrado.';
}
