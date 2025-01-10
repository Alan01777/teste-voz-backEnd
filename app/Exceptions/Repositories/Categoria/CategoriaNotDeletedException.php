<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotDeletedException extends Exception
{
    protected $message = 'A categoria não foi deletada. Por favor, tente novamente ou entre em contato com o suporte.';
    protected $code = 400;
}
