<?php
/**
 * Octodex Provider
 *
 * @package   Plopix\Octodex
 * @author    Sébastien Morel aka Plopix <morel.seb@gmail.com>
 * @copyright 2015 Plopix
 * @license   https://github.com/Plopix/Octodex/blob/master/LICENSE MIT Licence
 */

namespace Plopix\Octodex;

use DOMDocument;
use DOMXpath;

/**
 * Class Provider
 */
class Provider
{

    /**
     * The HTML URL
     *
     * @var string
     */
    protected $url = "https://octodex.github.com";

    /**
     * Cache Directory Path
     *
     * @var string
     */
    protected $cacheDirPath;


    /**
     * Cache Expiry
     *
     * @var integer
     */
    protected $cacheExpiry;

    /**
     * Data
     *
     * @var array
     */
    protected $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cacheDirPath = sys_get_temp_dir();
        $this->data         = null;
        $this->cacheExpiry  = 86400; // 1 day
    }

    /**
     * Get the CacheDirPath
     *
     * @return string
     */
    protected function getCacheDirPath()
    {
        return $this->cacheDirPath;
    }

    /**
     * Set the CacheDirPath
     *
     * @param string $cacheDirPath cacheDirPath
     *
     * @return $this
     */
    public function setCacheDirPath($cacheDirPath)
    {
        $this->cacheDirPath = $cacheDirPath;

        return $this;
    }

    /**
     * Set the Expiry
     *
     * @param integer $expiry expiry in seconds
     *
     * @return $this
     */
    public function setCacheExpiry($expiry)
    {
        $this->cacheExpiry = $expiry;

        return $this;
    }

    /**
     * Return the presumed cache file path
     *
     * @return string
     */
    private function getCachedFilePath()
    {
        return rtrim($this->getCacheDirPath(), "/") . "/plopix_octodex.json";
    }

    /**
     * Fetch and Parse the content
     *
     * @return array
     */
    protected function fetch()
    {
        $filePath = $this->getCachedFilePath();
        if (file_exists($filePath)) {
            $cachedData = unserialize(file_get_contents($filePath));
            if ($cachedData['expiry'] > time()) {
                return $cachedData['data'];
            }
        }

        $data = [ ];
        $doc  = new DOMDocument();
        @$doc->loadHTMLFile($this->url);
        $xpath    = new DOMXpath($doc);
        $elements = $xpath->query("//*/div[contains(@class, 'post')]");

        if (is_null($elements)) {
            return [ ];
        }
        foreach ($elements as $element) {
            /** @var DOMDocument $element * */
            $octocat = new Octocat();

            $aTags   = $element->getElementsByTagName('a');
            $imgTags = $element->getElementsByTagName('img');
            $spanTags = $element->getElementsByTagName('span');
            $octocat
                ->setName(trim($aTags->item(1)->nodeValue))
                ->setPageUrl("https://octodex.github.com" . trim($aTags->item(1)->getAttribute('href')))
                ->setImageUrl("https://octodex.github.com" . trim($imgTags->item(0)->getAttribute('data-src')))
                ->setAuthorName(trim($imgTags->item(1)->getAttribute('alt')))
                ->setAuthorUrl(trim($aTags->item(2)->getAttribute('href')))
                ->setNumber(trim($spanTags->item(0)->nodeValue, " #\n\t\r:"));

            if ($octocat->getAuthorName() == '') {
                $octocat->setAuthorName("Simon Oxley");
                $octocat->setAuthorUrl("http://www.idokungfoo.com");
            }

            if ($octocat->getAuthorName() == "Author") {
                $octocat->setAuthorName(
                    preg_replace("#^https://github.com/(.*)$#uism", "$1", $octocat->getAuthorUrl())
                );
            }
            $data[] = $octocat;
        }
        $cachedData = [ 'expiry' => (time() + $this->cacheExpiry), 'data' => $data ];
        file_put_contents($filePath, serialize($cachedData));

        return $data;
    }

    /**
     * Fetch the data from the URL if empty
     *
     * @return $this
     */
    protected function load()
    {
        if ($this->data === null) {
            $this->data = $this->fetch();
        }

        return $this;
    }

    /**
     * Random
     *
     * @return Octocat
     */
    public function getRandom()
    {
        $this->load();
        $count = count($this->data);

        return $this->data[rand(0, $count - 1)];
    }

    /**
     * Return the good Octocat
     *
     * @param integer $number Desired number
     *
     * @return Octocat
     */
    public function getNumber($number)
    {
        $this->load();
        $count = count($this->data);

        if ($number > $count) {
            return null;
        }

        return $this->data[$count - $number];
    }
}
