<!-- File: /app/View/Posts/edit.ctp -->

<h1>Edit subscriber</h1>
<?php
    echo $this->Form->create('Subscriber');
    echo $this->Form->input('name', array('label' => 'Name'));
    echo $this->Form->input('mail',  array('type' => 'email', 'label' => 'Mail'));	
	echo $this->Form->input('categories', array('type'=>'select', 'multiple' => true, 'empty' => '(choose one)'));	
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save');	