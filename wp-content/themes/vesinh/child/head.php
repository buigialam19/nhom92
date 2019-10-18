<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		<link href="//www.google-analytics.com" rel="dns-prefetch">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php wp_head(); ?>
		    <script src="<?php bloginfo('template_directory');?>/js/jssor.slider-23.1.5.min.js" type="text/javascript"></script>
			<link href="https://fonts.googleapis.com/css?family=Anton|Old+Standard+TT|Patrick+Hand" rel="stylesheet">
	</head>
	<body <?php body_class(); ?>>