<?php

namespace app\models;

// use lithium\data\Connections;
// Connections::get('default')->applyFilter('_execute', function($self, $params, $chain) {
//     var_dump($params['sql']);
//     return $chain->next($self, $params, $chain);
// });

class Likes extends \lithium\data\Model {

	public $validates = array();
}

?>