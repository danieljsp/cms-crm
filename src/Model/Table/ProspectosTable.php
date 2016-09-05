<?php namespace App\Model\Table;

use Cake\ORM\Table;

class ProspectosTable extends Table
{
  public function initialize(array $config)
    {
        $this->belongsTo('Proyectos');
        $this->belongsTo('Ciudades', [
            'foreignKey' => 'ciudad_id',
            'dependent' => true,
        ]);
        $this->hasMany('Compromisos');
    }

}
?>
