<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotDeletedException extends Exception
{
    protected $message = 'O produto não foi deletado. Por favor, tente novamente ou entre em contato com o suporte.';
    protected $code = 400;
}
