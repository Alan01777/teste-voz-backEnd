<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotFoundException extends Exception
{
    protected $message = 'Categoria não encontrada.';
}
