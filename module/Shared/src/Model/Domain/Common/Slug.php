<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Domain\Common;

use InvalidArgumentException;
use Transliterator;

class Slug
{
    /** @var string */
    private $slug;

    /**
     * @param string $slug
     */
    public function __construct($slug)
    {
        if (is_string($slug) === false) {
            $type = is_object($slug)
                ? get_class($slug)
                : gettype($slug);
            throw new InvalidArgumentException(sprintf(
                'String value expected; %s given',
                $type
            ));
        }
        if (preg_match('`^[0-9a-z-]+$`', $slug) < 1) {
            throw new InvalidArgumentException(
                "Slug value must contain alphanumeric chars and dash only"
            );
        }
        $this->slug = $slug;
    }

    public static function createFromString($str)
    {
        if (is_string($str) === false) {
            $type = is_object($str)
                ? get_class($str)
                : gettype($str);
            throw new InvalidArgumentException(sprintf(
                'String value expected; %s given',
                $type
            ));
        }
        // Remplace tous les caractères qui ne sont ni des lettres ni des
        // chiffres par "-"
        $str = preg_replace('~[^\\pL\d]+~u', '-', $str);
        // Transliterate + lowercase
        // @see http://php.net/manual/fr/transliterator.transliterate.php#111939
        // @see http://php.net/manual/fr/transliterator.transliterate.php#115162
        $transliterator = Transliterator::create(
            'Any-Latin; Latin-ASCII; [\u0100-\u7fff] Remove; Lower()'
        );
        $str = $transliterator->transliterate($str);
        // Trim les "-" aux extremités
        $str = trim($str, '-');
        // Supprime les doubles "--"
        $str = preg_replace('~[^-\w]+~', '', $str);
        return new self($str);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->slug;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
}
