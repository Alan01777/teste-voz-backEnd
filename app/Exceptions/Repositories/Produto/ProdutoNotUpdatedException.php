<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotUpdatedException extends Exception
{
    protected $message = 'O produto não foi atualizado. Por favor, tente novamente ou entre em contato com o suporte.';
    protected $code = 400;
}
