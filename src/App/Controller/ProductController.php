<?php 
namespace App\Controller;

use SkankyDev\Controller\MasterController;

class ProductController extends MasterController {
	
	public function index($page=1){
		$option = [
			'limit'=> 20,
			'query'=> [],
			'sort' => ['created'=> -1],
			'page'=>(int)$page,
		];
		$products = $this->Product->paginate($option);
		$this->view->set( ['products' => $products] );
	}

	public function view($ref){
		if(empty($slug)){
			throw new \Exception("page not found", 404);
		}
		$product = $this->Product->findOne(['ref'=>$ref]);
		if(!isset($post->slug)){
			throw new \Exception("page not found", 404);
		}
		$this->view->set(['product' => $product]);
	}

	private function list(){

	}

	private function add(){

	}

	private function edit(){

	}

	private function delete(){

	}

}