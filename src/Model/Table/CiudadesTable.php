<?php namespace App\Model\Table;

use Cake\ORM\Table;

class CiudadesTable extends Table
{
  public function initialize(array $config)
    {
        $this->hasOne('Prospectos');
        $this->belongsTo('Estados');
    }

}
?>
