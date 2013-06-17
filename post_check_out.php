<?php

require_once 'class.header.php';
require_once 'class.home.php';

$head=new header();
$head->show_header("Home");
?>
<div class='row-fluid'>
<div class='span6 offset3'>
	<img src='./img/done.jpg'>
</div>
</div>
<?php
$head->show_footer("home.js");
?>