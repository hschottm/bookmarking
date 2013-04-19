<?php

/**
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    bookmarking
 * @license    LGPL
 */

namespace Contao;

/**
 * Class ModuleBookmarking
 *
 * @copyright  Helmut Schottmüller 2009-2013
 * @author     Helmut Schottmüller <https://github.com/hschottm/bookmarking>
 * @package    Controller
 */
class ModuleBookmarking extends Module
{
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_bookmarking';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');
			$objTemplate->wildcard = '### BOOKMARKS ###';

			return $objTemplate->parse();
		}

		return parent::generate();
	}

	/**
	 * Generate module
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
				$pageref = ampersand(specialchars(\Environment::get('url') . \Environment::get('path')));
				if (!preg_match("/.*\\/^/", $pageref)) $pageref .= '/';
				$pageref .= ampersand(specialchars($this->generateFrontendUrl($pageArr)));
			}
			else
			{
				$pageref = ampersand(specialchars(\Environment::get('url') . \Environment::get('scriptName')));
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
}

?>