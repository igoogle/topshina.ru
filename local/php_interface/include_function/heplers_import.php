<?php

function calcPrice($rozn = 0,$opt = 0){
	$price = 0;
	if ($rozn>0){
		$price = $rozn;
	}elseif($opt>0){
		$price = $opt;
	}else{
		$price = 0;
	}
	return $price;
}