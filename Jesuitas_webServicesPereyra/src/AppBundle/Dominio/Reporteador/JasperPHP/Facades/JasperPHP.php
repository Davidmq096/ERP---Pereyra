<?php

namespace AppBundle\Dominio\Reporteador\JasperPHP\Facades;

use Illuminate\Support\Facades\Facade;

class JasperPHP extends Facade {

    protected static function getFacadeAccessor() { return 'jasperphp'; }
}