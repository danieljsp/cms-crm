<?php namespace App\Model\Table;

use Cake\ORM\Table;

class CompromisosTable extends Table
{
  public function initialize(array $config)
    {
        $this->belongsTo('Prospectos');
    }

}
?>
