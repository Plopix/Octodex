<?php
/**
 * Octodex Provider
 *
 * @package   Plopix\Octodex
 * @author    Sébastien Morel aka Plopix <morel.seb@gmail.com>
 * @copyright 2020 Plopix
 * @license   https://github.com/Plopix/Octodex/blob/master/LICENSE MIT Licence
 */

namespace Plopix\Octodex;

use DOMDocument;
use DOMXPath;

final class Provider
{
    private string $url = "https://octodex.github.com";

    private string $cacheDirPath;

    private int $cacheExpiry;

    private array $data;

    public function __construct(?string $cacheDir = null, int $cacheExpiry = 86400)
    {
        $this->cacheDirPath = $cacheDir ?? sys_get_temp_dir();
        $this->data = [];
        $this->cacheExpiry = $cacheExpiry;
    }

    private function cachedFilePath(): string
    {
        return rtrim($this->cacheDirPath, "/")."/plopix_octodex.json";
    }

    protected function fetch(): array
    {
        $filePath = $this->cachedFilePath();
        if (file_exists($filePath)) {
            $cachedData = unserialize(file_get_contents($filePath));
            if ($cachedData['expiry'] > time()) {
                return $cachedData['data'];
            }
        }

        $data = [];
        $doc = new DOMDocument();
        @$doc->loadHTMLFile($this->url);
        $xpath = new DOMXpath($doc);
        $elements = $xpath->query("//*/div[contains(@class, 'post')]");

        if (\is_null($elements)) {
            return [];
        }
        foreach ($elements as $element) {
            /** @var DOMDocument $element * */
            $aTags = $element->getElementsByTagName('a');
            $imgTags = $element->getElementsByTagName('img');
            $spanTags = $element->getElementsByTagName('span');

            $octocat = new Octocat(
                trim($aTags->item(1)->nodeValue),
                "https://octodex.github.com".trim($aTags->item(1)->getAttribute('href')),
                "https://octodex.github.com".trim($imgTags->item(0)->getAttribute('data-src')),
                trim($imgTags->item(1)->getAttribute('alt')),
                trim($aTags->item(2)->getAttribute('href')),
                trim($spanTags->item(0)->nodeValue, " #\n\t\r:")
            );
            $data[] = json_encode($octocat);
        }
        $cachedData = ['expiry' => (time() + $this->cacheExpiry), 'data' => $data];
        file_put_contents($filePath, serialize($cachedData));

        return $data;
    }

    private function load(): void
    {
        if ($this->data === []) {
            $this->data = $this->fetch();
        }
    }

    public function getRandom(): Octocat
    {
        $this->load();
        $count = \count($this->data);

        return Octocat::createFromJson($this->data[random_int(0, $count - 1)]);
    }

    public function getNumber(int $number = 1): Octocat
    {
        $this->load();
        $count = \count($this->data);

        return Octocat::createFromJson($this->data[abs(($count - $number) % $count)]);
    }
}
