<?php
namespace App\View;

class Json {
	public function display(array $data) {
		echo json_encode($data);
	}
}