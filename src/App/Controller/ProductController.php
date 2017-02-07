<?php 
namespace App\Controller;

use SkankyDev\Controller\MasterController;
use SkankyDev\Config\Config;
use SkankyDev\Utilities\Session;
use SkankyDev\Utilities\Token;

class ProductController extends MasterController {
	
	public function index($page=1){
		$option = [
			'limit'=> 20,
			'query'=> ['online'=>'online'],
			'sort' => ['created'=> -1],
			'page'=>(int)$page,
		];
		$products = $this->Product->paginate($option);
		$this->view->set( ['products' => $products] );
	}

	public function view($ref){
		if(empty($ref)){
			throw new \Exception("page not found", 404);
		}
		$product = $this->Product->findOne(['ref'=>$ref]);
		if(!isset($product->ref)){
			throw new \Exception("page not found", 404);
		}
		$this->view->set(['product' => $product]);
	}

	private function list($page = 1,$field = 'created',$order = -1){
		$option = [
			'limit'=> 25,
			'query'=> [],
			'page'=>(int)$page,
			'sort' => [],
		];
		$option['sort'][$field] = (int)$order;
		$products = $this->Product->paginate($option);
		$this->view->set( ['products' => $products] );		
	}


	private function add(){
		if($this->request->isPost()){

			$product = $this->Product->createDocument($this->request->getData());

			if($this->Product->isValid($product)){
				$dir = PUBLIC_FOLDER.DS.'img'.DS.'product'.DS.$product->ref;
				$product->media = [];
				if(!file_exists($dir)){
					mkdir($dir,0755,true);
				}
				$files = $this->request->getFiles();
				if( !empty($files) && !$files['media']['error'] ){
					//debug(Config::get('upload.image'));
					$ex = explode('.', $files['media']['name']);
					$ex = end($ex);
					if(in_array($ex, Config::get('upload.image'))){
						//peux etre faire une limite de taille: && $files['img']['size'] < 3000000
						move_uploaded_file($files['media']['tmp_name'] , $dir.DS.$files['media']['name']);
						$product->media[0]['name'] = $files['media']['name'];
						$product->media[0]['type'] = $files['media']['type'];
						$product->media[0]['size'] = $files['media']['size'];
						$product->media[0]['url'] = '/img/product/'.$product->ref.'/'.$files['media']['name'];
					}else{
						$this->Flash->set('le fichier sélectionné n\'a pas pu etre sauvegardé',['class' => 'warning']);
					}
				}
				$product->prix = (float)$product->prix;
				if($this->Product->save($product)){
					$this->Flash->set('ça marche',['class' => 'success']);
					$this->request->redirect(['action'=>'list']);
				}else{
					$this->Flash->set('ça marche pas',['class' => 'error']);
					$this->request->data = $product;
				}
			}else{
				$this->Flash->set('pas valid',['class' => 'error']);
				$this->request->data = $product;
			}
		}
		//$this->view->set([]);
	}

	private function edit($ref = ''){
		$product = $this->Product->findOne(['ref'=>$ref]);
		if($this->request->isPost()){
			$media = $product->media;
			$product = $this->Product->createDocument($this->request->getData());
			$product->media = $media;
			$product->prix = (float)$product->prix;
			if($this->Product->isValid($product)){
				if($this->Product->save($product)){
					$this->Flash->set('ça marche',['class' => 'success']);
					$this->request->redirect(['action'=>'list']);
				}else{
					$this->Flash->set('ça marche pas',['class' => 'error']);
				}
			}else{
				$this->Flash->set('ça marche pas',['class' => 'warning']);
			}
		}
		$this->request->data = $product;
		$this->view->set(['product' => $product]);
	}

	private function delete($_id = ''){
		if(!empty($_id)){
			if($this->Product->remove($_id)){
				$this->Flash->set('ça marche',['class' => 'success']);
			}else{
				$this->Flash->set('ça marche pas',['class' => 'error']);
			}
			$this->request->redirect(['action'=>'list']);
		}
	}

	private function media($ref=''){
		$product = $this->Product->findOne(['ref'=>$ref]);
		$token = new Token();
		Session::set('skankydev.form.csrf',$token);
		$this->view->set(['product' => $product,'token'=>$token]);
	}

	private function addMedia($ref=''){
		$this->view->displayLayout = false;
		$media = [];
		$result = ['statu'=>false];
		if(!empty($ref)){
			$h = getallheaders();
			$dir =  PUBLIC_FOLDER.DS.'img'.DS.'product'.DS.$ref;
			$source = file_get_contents('php://input');
			//todo typede fichier
			$fileName = $dir.DS.$h['X-File-Name'];
			if(!file_exists($fileName)){
				file_put_contents($fileName,$source);
				$media['name'] = $h['X-File-Name'];
				$media['type'] = $h['X-File-Type'];
				$media['size'] = $h['X-File-Size'];
				$media['url'] = '/img/product/'.$ref.'/'.$media['name'] ;
				if($this->Product->addMedia($ref,$media)){
					$result['statu'] = true;
				}
			}else{
				$result['message'] = 'ce fichier exist deja : '.$h['X-File-Name'];
			}
		}
		$this->view->set(['result'=>$result,'media'=>$media]);
	}

	private function deleteMedia($ref = '', $key=false){
		$product = $this->Product->findOne(['ref'=>$ref]);
		$dir = PUBLIC_FOLDER.DS.'img'.DS.'product'.DS.$product->ref;
		unlink($dir.DS.$product->media[$key]['name']);
		unset($product->media[$key]);
		$i = 0;
		$mediaList = $product->media;
		unset($product->media);
		foreach ($mediaList as $media) {
			$product->media[$i] = $media;
			$i++;
		}
		$this->Product->save($product);
		$this->Flash->set('ça marche',['class' => 'success']);
		$this->request->redirect(['action'=>'media','params'=>['ref'=>$product->ref]]);

	}

}
