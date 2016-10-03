<?php
//$nombre, $email, $telefono, $proyecto, $comentarios, $tipo
echo $this->Form->create('update', ['url' => ['action' => 'update']]);
// Text
echo $this->Form->input('nombre');
echo $this->Form->input('email');
echo $this->Form->input('telefono');
echo $this->Form->input('proyecto');
echo $this->Form->input('comentarios');
echo $this->Form->input('tipo', array('options' => array('CallMe' => 'CallMe', 'Web Site' => 'Web Site')));
echo $this->Form->button('Enviar');
echo $this->Form->end();
?>
