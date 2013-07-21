<!-- File: /app/View/Posts/index.ctp -->
<script type="text/javascript">
var index_url = "<?php echo $this->Html->url(array( 'controller' => 'Posts',  'action' => 'index')); ?>";
</script>
<h1>List of subscribers</h1>
<br />
<p><?php echo $this->Html->link('Add subscriber', array('action' => 'add')); ?></p>
<?php echo $this->Form->input('sorting', array('id'=> 'sort','type'=>'select', 'value'=>$active_sorting_mode, 'label' => false,'style'=>'float:right',  'options'=> $sorting, 'empty' => '(sorting options)'));?>

<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
		<th>Mail</th>
		<th>Categories</th>
        <th>Actions</th>
        <th>Created</th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['Post']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id'])); ?>
        </td>
		
		<td>
            <?php echo $this->Html->link($post['Post']['body'], array('action' => 'view', $post['Post']['id'])); ?>
        </td>
		
		<td>
            <?php echo $this->Html->link($post['Post']['categories'], array('action' => 'view', $post['Post']['id'])); ?>
        </td>
		
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $post['Post']['id']),
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id'])); ?>
        </td>
        <td>
            <?php echo $post['Post']['created']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>