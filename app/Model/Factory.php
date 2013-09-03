<?php

class Factory
{		
		
	public static function getOrder($id = null)
	{		
		App::import('Model', 'Order/Item');
		return new Order\Item();
	}
}