<?php

/**
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    bookmarking
 * @license    LGPL
 */

namespace Contao;

/**
 * Class ContentBookmarking
 *
 * Front end content element "bookmarking".
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    Controller
 */
class ContentBookmarking extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_bookmarking';

	protected function getHrefDelicious($href)
	{
		return "<img src=\"https://delicious.com/img/logo.png\" height=\"16\" width=\"16\" alt=\"Delicious\" />
		<a href=\"#\" onclick=\"window.open('http://delicious.com/save?v=5&provider=Contao&noui&jump=close&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title), 'delicious','toolbar=no,width=550,height=550'); return false;\"> " . $GLOBALS['TL_LANG']['tl_content']['bookmark_delicious'] . "</a>";
	}
	
	protected function getHrefDigg($href)
	{
		return '<script type="text/javascript">'.
		"\n".
		'(function() {'.
		"\n".
		"var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];".
		"\n".
		"s.type = 'text/javascript';".
		"\n".
		"s.async = true;".
		"\n".
		"s.src = 'http://widgets.digg.com/buttons.js';".
		"\n".
		"s1.parentNode.insertBefore(s, s1);".
		"\n".
		"})();".
		"\n".
		"</script>".
		"\n".
		'<a class="DiggThisButton DiggCompact"></a>';
	}
	
	protected function getHrefStumbleupon($href)
	{
		return "<a href=\"http://www.stumbleupon.com/submit?url=" . urlencode($href) . "\"> <img src=\"http://cdn.stumble-upon.com/images/24x24_su.gif\" alt=\"\"> " . $GLOBALS['TL_LANG']['tl_content']['bookmark_stumbleupon'] . "</a>";
	}
	
	protected function getHrefWong($href)
	{
		return "<a href=\"http://www.mister-wong.de/add_url/\" onclick=\"location.href=&quot;http://www.mister-wong.de/index.php?action=addurl&amp;bm_url=&quot;+encodeURIComponent(location.href)+&quot;&amp;bm_description=&quot;+encodeURIComponent(document.title);return false\" title=\"" . $GLOBALS['TL_LANG']['tl_content']['bookmark_wong'] . "\"><img src=\"http://www.mister-wong.de/img/wong.gif\" alt=\"" . $GLOBALS['TL_LANG']['tl_content']['bookmark_wong'] . "\" /></a>";
	}
	
	protected function getHrefAddthis($href)
	{
		$lang = (array_key_exists($GLOBALS['TL_LANGUAGE'], $this->getLanguages())) ? $GLOBALS['TL_LANGUAGE'] : "en";
		return "<script type=\"text/javascript\" src=\"http://s7.addthis.com/js/152/addthis_widget.js\"></script><script type=\"text/javascript\">var addthis_pub=\"" . $this->bookmarking_addthis_publisher . "\";</script>
		<a href=\"http://www.addthis.com/bookmark.php\" onmouseover=\"return addthis_open(this, '', '[URL]', '[TITLE]')\" onmouseout=\"addthis_close()\" onclick=\"return addthis_sendto()\"><img src=\"http://s7.addthis.com/static/btn/lg-share-" . $lang . ".gif\" width=\"125\" height=\"16\" alt=\"Bookmark and Share\" style=\"border:0\"/></a>";
	}
	
	/**
	 * Generate content element
	 */
	protected function compile()
	{
		$this->import('String');
		$this->import('Bookmarks');
		$this->loadLanguageFile('tl_content');

		$arrArticle = $this->Database->prepare("SELECT tl_article.pid FROM tl_article WHERE id=?")
			->limit(1)
			->execute($this->pid)
			->fetchEach('pid');
		if (count($arrArticle) == 1) $pageid = $arrArticle[0];
		if ($pageid > 0)
		{
			$objPage = $this->Database->prepare("SELECT * FROM tl_page WHERE id=?")
				->limit(1)
				->execute($pageid);
			$pageArr = ($objPage->numRows) ? $objPage->fetchAssoc() : array();
			$pageref = ampersand(specialchars($this->Environment->url . $this->Environment->path));
			if (!preg_match("/.*\\/^/", $pageref)) $pageref .= '/';
			$pageref .= ampersand(specialchars($this->generateFrontendUrl($pageArr)));
		}
		else
		{
			$pageref = ampersand(specialchars($this->Environment->url . $this->Environment->scriptName));
		}
		$options = $this->Bookmarks->getBookmarkingOptions();
		$selected = deserialize($this->bookmarking, true);
		$bookmarks = array();

		foreach ($selected as $id)
		{
			$method = 'getHref' . ucfirst($options[$id]);
			$href = (method_exists($this, $method)) ? $this->$method($pageref) : "";
			array_push($bookmarks, $href);
		}
		if ($this->bookmarking_addthis)
		{
			array_push($bookmarks, $this->getHrefAddthis($pageref));
		}
		$this->Template->bookmarks = $bookmarks;
	}
}

?>