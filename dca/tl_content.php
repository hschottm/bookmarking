<?php

/**
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    bookmarking
 * @license    LGPL
 */

class tl_content_bookmarking extends Backend
{
}


/**
 * Table tl_content
 */

array_insert($GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'], 1, 'bookmarking_addthis');
$GLOBALS['TL_DCA']['tl_content']['palettes']['bookmarking'] = '{type_legend},type,headline;{bookmarking_legend},bookmarking;{addthis_legend},bookmarking_addthis;{protected_legend:hide},protected;{expert_legend},{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['bookmarking_addthis'] = 'bookmarking_addthis_publisher';


$GLOBALS['TL_DCA']['tl_content']['fields']['bookmarking'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bookmarking'],
	'default'                 => 0,
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('Bookmarks', 'getBookmarkingOptions'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_content']['bookmarking'],
	'eval'                    => array('multiple'=>true, 'helpwizard' => true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bookmarking_addthis'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bookmarking_addthis'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['bookmarking_addthis_publisher'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['bookmarking_addthis_publisher'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'maxlength'=> 64),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

?>