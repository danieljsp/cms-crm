<?php namespace App\Model\Table;

use Cake\ORM\Table;

class FormsTable extends Table
{
  public function initialize(array $config)
    {
        $this->belongsTo('Proyectos');
    }

}
?>
