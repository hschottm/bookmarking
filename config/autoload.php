<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Bookmarking
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\Bookmarks'          => 'system/modules/bookmarking/classes/Bookmarks.php',

	// Elements
	'Contao\ContentBookmarking' => 'system/modules/bookmarking/elements/ContentBookmarking.php',

	// Modules
	'Contao\ModuleBookmarking'  => 'system/modules/bookmarking/modules/ModuleBookmarking.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_bookmarking'  => 'system/modules/bookmarking/templates',
	'mod_bookmarking' => 'system/modules/bookmarking/templates',
));
