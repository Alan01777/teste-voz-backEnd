<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotDeletedException extends Exception
{
    protected $message = 'A categoria não foi deletada.';
}
