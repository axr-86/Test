<?php
$arUrlRewrite = array(
	array(
		"CONDITION"   =>   "#^/events/([0-9a-zA-Z-_]+)/.*#",
		"RULE"   =>   "ELEMENT_CODE=$1",
		"ID"   =>   "",
		"PATH"   =>   "/events/index.php",
	),
);
