<?php
$amount = elgg_extract('amount', $vars, 0);

if($amount >= 0){
	echo "<span class=\"positive\">+$amount</span>";
} else {
	echo "<span class=\"negative\">+$amount</span>";
}
