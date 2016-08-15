<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<?php 
class toLink{
	public function __construct($link){
		$this->link = $link;
	}

	function getLink($result){
		return '<a href="http://www.'.$this->link.'.com">'.$result[0].'</a>';
	}
}

$test = [
	['title'=>'text','link'=>'toupi'],
	['title'=>'Suscipit','link'=>'youpi'],
	['title'=>'adipisicing','link'=>'pasyoupi'],
];

$string ='text Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit eos tempora similique molestias perspiciatis possimus voluptatum, fugit qui soluta laudantium vitae quos aut ad animi placeat dolorum velit minima enim!';

foreach ($test as $row) {
	$call = new toLink($row['link']);
	$string = preg_replace_callback("/".$row['title']."/",[$call,'getLink'], $string);
}
echo $string;

?>	

</body>
</html>

