<?php

namespace App\Exceptions\Repositories\Produto;

use Exception;

class ProdutoNotFoundException extends Exception
{
    protected $message = 'O produto não foi encontrado. Por favor, verifique o ID e tente novamente ou entre em contato com o suporte.';
    protected $code = 404;
}
