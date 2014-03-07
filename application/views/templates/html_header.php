<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?php if (isset($style)) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('/media/css/' . $style); ?>"/>
	<?php } ?>
</head>
<body>