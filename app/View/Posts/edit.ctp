<!-- File: /app/View/Posts/edit.ctp -->

<h1>Edit subscriber</h1>
<?php
    echo $this->Form->create('Post');
    echo $this->Form->input('title', array('label' => 'Name'));
    echo $this->Form->input('body',  array('type' => 'email', 'label' => 'Mail'));	
	echo $this->Form->input('categories', array('type'=>'select', 'multiple' => true, 'empty' => '(choose one)'));	
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save');	