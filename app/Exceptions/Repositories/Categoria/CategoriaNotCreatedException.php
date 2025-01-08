<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotCreatedException extends Exception
{
    protected $message = 'A categoria não foi criada.';
}
