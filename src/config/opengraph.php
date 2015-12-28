<?php

return array(
	'defaults' => array(
		/**
		 * default title and description
		 * Can be null|string|seotools
		 * If 'seotools' the title will be awarded by MetaGenerator->getTitle()
		 */
		'title'       => 'asd',
		'description' => 'seotools',
		/**
		 * default url
		 * Can be null|string|url
		 * If 'url' the title will be awarded by Input::url()
		 */
		'url'         => null,
		'type'        => false,
		'image'       => array(),
		'site_name'   => 'seotools',
		'fb:admins'    => array(),
		'fb:app_id'   => null
	)
);
