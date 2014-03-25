<?php

namespace app\controllers;

use app\models\Likes;
use lithium\action\DispatchException;

class LikesController extends \lithium\action\Controller {


	public function test() {

	}

	public function get() {
		if (is_array($this->request->query['key'])) {
			$count = Likes::find('all', [
				'conditions' => [
					'user' => $this->request->query['user'],
					'namespace' => $this->request->query['namespace'],
					'key' => $this->request->query['key']
				],
				'fields' => [
					"CONCAT_WS('.', user, namespace, `key`) AS k",
					'COUNT(ip) AS count'
				],
				'group' => ['user', 'namespace', 'key']
			]);
		}
		else {
			$count = Likes::count([
				'conditions' => [
					'user' => $this->request->query['user'],
					'namespace' => $this->request->query['namespace'],
					'key' => $this->request->query['key']
				]
			]);
		}

		header("Access-Control-Allow-Origin: *");
		return compact('count');
	}

	public function add() {
		$like = Likes::create();

		if ($this->request->data) {
			$like->ip = $_SERVER['REMOTE_ADDR'];
			try {
				if ($like->save($this->request->data)) {
					return compact('like');
				}
			}
			catch ( \Exception $e) {
				return ['status' => 'duplicate'];
			}
		}

		header("Access-Control-Allow-Origin: *");
		return ['status' => 'failed'];
	}
}

?>