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
<font size='1'><table class='xdebug-error xe-uncaught-exception' dir='ltr' border='1' cellspacing='0' cellpadding='1'>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Fatal error: Uncaught Error: Class 'Skankydev\I18n\Localization' not found in E:\repository\skankydev\src\App\Template\layout\default.ctp on line <i>2</i></th></tr>
<tr><th align='left' bgcolor='#f57900' colspan="5"><span style='background-color: #cc0000; color: #fce94f; font-size: x-large;'>( ! )</span> Error: Class 'Skankydev\I18n\Localization' not found in E:\repository\skankydev\src\App\Template\layout\default.ctp on line <i>2</i></th></tr>
<tr><th align='left' bgcolor='#e9b96e' colspan='5'>Call Stack</th></tr>
<tr><th align='center' bgcolor='#eeeeec'>#</th><th align='left' bgcolor='#eeeeec'>Time</th><th align='left' bgcolor='#eeeeec'>Memory</th><th align='left' bgcolor='#eeeeec'>Function</th><th align='left' bgcolor='#eeeeec'>Location</th></tr>
<tr><td bgcolor='#eeeeec' align='center'>1</td><td bgcolor='#eeeeec' align='center'>0.0000</td><td bgcolor='#eeeeec' align='right'>368720</td><td bgcolor='#eeeeec'>{main}(  )</td><td title='E:\repository\skankydev\public\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>0</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>2</td><td bgcolor='#eeeeec' align='center'>0.0030</td><td bgcolor='#eeeeec' align='right'>528800</td><td bgcolor='#eeeeec'>SkankyDev\Application->__construct(  )</td><td title='E:\repository\skankydev\public\index.php' bgcolor='#eeeeec'>...\index.php<b>:</b>12</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>3</td><td bgcolor='#eeeeec' align='center'>0.0080</td><td bgcolor='#eeeeec' align='right'>721520</td><td bgcolor='#eeeeec'>SkankyDev\Controller\ErrorController->__construct(  )</td><td title='E:\repository\skankydev\vendor\skank\SkankyDev\Application.php' bgcolor='#eeeeec'>...\Application.php<b>:</b>45</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>4</td><td bgcolor='#eeeeec' align='center'>0.0090</td><td bgcolor='#eeeeec' align='right'>784496</td><td bgcolor='#eeeeec'>SkankyDev\MasterView->render(  )</td><td title='E:\repository\skankydev\vendor\skank\SkankyDev\Controller\ErrorController.php' bgcolor='#eeeeec'>...\ErrorController.php<b>:</b>45</td></tr>
<tr><td bgcolor='#eeeeec' align='center'>5</td><td bgcolor='#eeeeec' align='center'>0.0110</td><td bgcolor='#eeeeec' align='right'>872432</td><td bgcolor='#eeeeec'>require( <font color='#00bb00'>'E:\repository\skankydev\src\App\Template\layout\default.ctp'</font> )</td><td title='E:\repository\skankydev\vendor\skank\SkankyDev\MasterView.php' bgcolor='#eeeeec'>...\MasterView.php<b>:</b>54</td></tr>
</table></font>
</body>
</html>
