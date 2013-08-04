<script type="text/javascript">
var index_url = "<?php echo $this->Html->url(array( 'controller' => 'Subscribers',  'action' => 'index')); ?>";
</script>
<h1>List of subscribers</h1>
<br />
<p><?php echo $this->Html->link('Add subscriber', array('action' => 'add')); ?></p>
<?php echo $this->Form->input('sorting', array('id'=> 'sort','type'=>'select', 'value'=>$active_sorting_mode, 'label' => false,'style'=>'float:right',  'options'=> $sorting, 'empty' => '(sorting options)'));?>

<table>
    <tr>
        <th>Name</th>
		<th>Mail</th>
		<th>Categories</th>
        <th>Actions</th>
        <th>Created</th>
    </tr>
    <?php foreach ($posts as $post): ?>
    <tr>
        <td>
            <?php echo $post['Subscriber']['name']; ?>
        </td>
		
		<td>
            <?php echo $post['Subscriber']['mail']; ?>
        </td>
		
		<td>
            <?php 
			$category_ids = $post['Subscriber']['categories']; 
				if (!empty($post['Subscriber']['categories'])) {
					foreach ( $category_ids as $id) {
						echo  $categories[$id];
						echo '&nbsp;';
					}					
				}
			?>
        </td>
		
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $post['Subscriber']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Subscriber']['id'])); ?>
        </td>
        <td>
            <?php echo $post['Subscriber']['atime']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>