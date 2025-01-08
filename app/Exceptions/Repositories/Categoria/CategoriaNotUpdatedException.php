<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotUpdatedException extends Exception
{
    protected $message = 'A categoria não foi atualizada.';
}
