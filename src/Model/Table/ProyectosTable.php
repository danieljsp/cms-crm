<?php namespace App\Model\Table;

use Cake\ORM\Table;

class ProyectosTable extends Table
{
  public function initialize(array $config)
    {
        $this->hasOne('Forms');
    }

}
?>
