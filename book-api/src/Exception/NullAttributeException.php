<?php

namespace App\Exception;

use Exception;

/**
 * Class NullAttributeException
 * @package App\Exception
 */
class NullAttributeException extends Exception
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var array
     */
    private $params;

    /**
     * NullAttributeException constructor.
     * @param string $key
     * @param string $className
     */
    public function __construct(string $key, string $className)
    {
        $this->key = $key;
        $this->params = array(
            'key' => $key,
            'class' => $className
        );
        parent::__construct("`$key` in `$className` should not be null");
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}