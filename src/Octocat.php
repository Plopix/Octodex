<?php
/**
 * Octodex Octocat Entity
 *
 * @package   Plopix\Octodex
 * @author    Sébastien Morel aka Plopix <morel.seb@gmail.com>
 * @copyright 2015 Plopix
 * @license   https://github.com/Plopix/Octodex/blob/master/LICENSE MIT Licence
 */

namespace Plopix\Octodex;

/**
 * Class Octocat
 */
class Octocat implements \Serializable
{

    /**
     * Name
     *
     * @var string
     */
    protected $name;

    /**
     * Page URL
     *
     * @var string
     */
    protected $pageUrl;

    /**
     * Image URL
     *
     * @var string
     */
    protected $imageUrl;

    /**
     * Author Name
     *
     * @var string
     */
    protected $authorName;

    /**
     * Number
     *
     * @var integer
     */
    protected $number;

    /**
     * Author URL
     *
     * @var string
     */
    protected $authorUrl;

    /**
     * Get the Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the Name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the PageUrl
     *
     * @return string
     */
    public function getPageUrl()
    {
        return $this->pageUrl;
    }

    /**
     * Set the PageUrl
     *
     * @param string $pageUrl pageUrl
     *
     * @return $this
     */
    public function setPageUrl($pageUrl)
    {
        $this->pageUrl = $pageUrl;

        return $this;
    }

    /**
     * Get the ImageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set the ImageUrl
     *
     * @param string $imageUrl imageUrl
     *
     * @return $this
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get the AuthorName
     *
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set the AuthorName
     *
     * @param string $authorName authorName
     *
     * @return $this
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get the Number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the Number
     *
     * @param int $number number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get the AuthorUrl
     *
     * @return string
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * Set the AuthorUrl
     *
     * @param string $authorUrl authorUrl
     *
     * @return $this
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;

        return $this;
    }

    /**
     * String conversion
     *
     * @return string
     */
    public function __toString()
    {
        return "--\n" .
               "Number: #{$this->getNumber()}\n" .
               "Name: {$this->getName()}\n" .
               "Page Url: {$this->getPageUrl()}\n" . "Image Url: {$this->getImageUrl()}\n" .
               "Author Name: {$this->getAuthorName()}\n" . "Author Url: {$this->getAuthorUrl()}\n";

    }

    /**
     * Serialize the object
     *
     * @return string
     */
    public function serialize()
    {
        return json_encode(
            [
                'octocat' => [
                    'number'     => $this->getNumber(),
                    'name'       => $this->getName(),
                    'pageUrl'    => $this->getPageUrl(),
                    'authorName' => $this->getAuthorName(),
                    'authorUrl'  => $this->getAuthorUrl(),
                    'imageUrl'   => $this->getImageUrl(),
                ]
            ]
        );
    }

    /**
     * UnSerialize the object
     *
     * @param string $data data
     */
    public function unserialize($data)
    {
        $data = json_decode($data, true);
        $octo = $data['octocat'];
        $this->setName($octo['name']);
        $this->setNumber($octo['number']);
        $this->setAuthorUrl($octo['authorUrl']);
        $this->setAuthorName($octo['authorName']);
        $this->setImageUrl($octo['imageUrl']);
        $this->setPageUrl($octo['pageUrl']);
    }
}
