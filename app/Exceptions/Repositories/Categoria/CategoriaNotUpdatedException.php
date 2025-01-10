<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotUpdatedException extends Exception
{
    protected $message = 'A categoria não foi atualizada. Por favor, tente novamente ou entre em contato com o suporte.';
    protected $code = 400;
}
