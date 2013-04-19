<?php

/**
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    bookmarking
 * @license    LGPL
 */

namespace Contao;

/**
 * Class Bookmarks
 *
 * Helper class to create the bookmarking services
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    Controller
 */
class Bookmarks
{
	public function getBookmarkingOptions()
	{
		$options = array(
			1 => 'delicious',
			2 => 'digg',
			4 => 'stumbleupon',
			5 => 'wong'
		);
		return $options;
	}
}
