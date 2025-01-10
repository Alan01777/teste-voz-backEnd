<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotFoundException extends Exception
{
    protected $message = 'Categoria não encontrada. Por favor, verifique o ID informado ou entre em contato com o suporte para assistência.';
    protected $code = 404;
}
