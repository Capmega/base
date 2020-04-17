<?php

namespace Capmega\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Capmega\Base\Traits\TraitModel;

/**
 * Class with all predefined configurations models
 */
abstract class ResourceModel extends Model
{
    /**
     * Define las constantes usadas para los Status por defecto
     */
    const STATUS_DELETE   = 5;
    const STATUS_INACTIVE = 10;
    const STATUS_CREATE   = 15;
    const STATUS_ACTIVE   = 20;

    public function __construct(){
        parent::__construct();
    }

    use TraitModel;
}
