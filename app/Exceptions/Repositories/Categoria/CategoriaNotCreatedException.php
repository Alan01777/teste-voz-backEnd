<?php

namespace App\Exceptions\Repositories\Categoria;

use Exception;

class CategoriaNotCreatedException extends Exception
{
    protected $message = 'A categoria não foi criada. Por favor, tente novamente ou entre em contato com o suporte.';
    protected $code = 400;
}
