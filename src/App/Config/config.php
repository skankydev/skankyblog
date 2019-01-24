<?php 

return [
	'default' => [
		'namespace'=>'App',
		'action'   =>'index'
	],
	'paginator'=>[
		'limit'=>25,
		'range'=>5
	],
	'routes' =>[
		'/' => [
			'options'=>[
				'controller' => 'Home',
				'action'     => 'index',
				'namespace'  => 'App'
			]
		]
	],
	'form'=>[
		'class'=>[
			'div'      => 'field',
			'input'    => 'field-input',
			'label'    => 'field-label',
			'textarea' => 'field-textarea',
			'button'   => 'btn-submit'
		]
	],
	'Auth'=>[
		'redirectAction' => [
			'controller' => 'User',
			'action'     => 'login',
			'namespace'  => 'App'
		],
		'cookieTimer'      => TIME_WEEK,
		'accessDenied'     => false,
		'userEntity'       => 'App\Model\Document\User',
		'permissionEntity' => 'App\Model\Document\Permission',
		'defaultRole'      => 'default',
	],
	'class' => [
		'helper' => [
			'Size'    => 'App\View\Helper\SizeHelper',
			'Sociaux' => 'App\View\Helper\SociauxHelper',
			'Images'  => 'App\View\Helper\ImagesHelper',
		],
		'behavior' => [
			'Owner' => 'App\Model\Behavior\OwnerBehavior'
		],
		'listener' => [
			'Users' => 'App\Listener\UsersListener'
		],
		'tools' => [
			'Mail'   => 'App\Controller\Tools\MailTool',
			'Paypal' => 'App\Controller\Tools\PaypalTool',
			'Upload' => 'App\Controller\Tools\UploadTool',
			'Image'  => 'App\Controller\Tools\ImageTool',
		],
		'formElement' => [
			'Wysiwyg' => 'App\View\FormElement\WysiwygElement'
		]
	],
	'listener'=> [
		'Debug',
		'Users',
	],
	'timehelper'=> [
		'format'=>'H:i:s d/m/Y',
		'timezone'=>'Europe/Paris'
	],
	'upload'=>[
		'image' =>['jpg','JPG','jpeg','JPEG','gif','png'],
		'folder'=> 'upload'.DS,
	],
];
