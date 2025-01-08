<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotDeletedException extends Exception
{
    protected $message = 'O produto não foi deletado.';
}
