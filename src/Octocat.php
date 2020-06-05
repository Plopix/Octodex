<?php
/**
 * Octodex Octocat Entity
 *
 * @package   Plopix\Octodex
 * @author    Sébastien Morel aka Plopix <morel.seb@gmail.com>
 * @copyright 2020 Plopix
 * @license   https://github.com/Plopix/Octodex/blob/master/LICENSE MIT Licence
 */

namespace Plopix\Octodex;

use ConvenientImmutability\Immutable;
use JsonSerializable;

final class Octocat implements JsonSerializable
{
    use Immutable;

    public string $name;

    public string $pageUrl;

    public string $imageUrl;

    public string $authorName;

    public string $authorUrl;

    public int $number;

    public function __construct(
        string $name,
        string $pageUrl,
        string $imageUrl,
        string $authorName,
        string $authorUrl,
        int $number
    ) {
        $this->name = $name;
        $this->pageUrl = $pageUrl;
        $this->imageUrl = $imageUrl;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->number = $number;
    }

    public function __toString(): string
    {
        return <<<STRING
            --
            Number: #{$this->number}
            Name: {$this->name}
            Page Url: {$this->pageUrl}
            Image Url: {$this->imageUrl}
            Author Name: {$this->authorName}
            Author Url: {$this->authorUrl}
        STRING;
    }

    public function JsonSerialize(): array
    {
        return [
            'octocat' => [
                'number' => $this->number,
                'name' => $this->name,
                'pageUrl' => $this->pageUrl,
                'authorName' => $this->authorName,
                'authorUrl' => $this->authorUrl,
                'imageUrl' => $this->imageUrl,
            ]
        ];
    }

    public static function createFromJson(string $json): self
    {
        $data = json_decode($json, true);
        $octo = $data['octocat'];

        return new Octocat(
            (string) $octo['name'],
            (string) $octo['pageUrl'],
            (string) $octo['imageUrl'],
            (string) $octo['authorName'],
            (string) $octo['authorUrl'],
            (int) $octo['number'],
        );
    }
}
