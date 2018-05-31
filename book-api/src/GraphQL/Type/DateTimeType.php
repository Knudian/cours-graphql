<?php

namespace App\GraphQL\Type;

use DateTime;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;

/**
 * Class DateTimeType
 * @package App\GraphQL\Type
 */
class DateTimeType extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     *
     * @param DateTime $value
     * @return mixed
     */
    public function serialize($value)
    {
        return $value->format('Y-m-d');
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     *
     * @param mixed $value
     * @return mixed
     */
    public function parseValue($value)
    {
        return new DateTime($value);
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input
     *
     * @param Node $valueNode
     * @return mixed
     */
    public function parseLiteral($valueNode)
    {
        return new DateTime($valueNode->value);
    }
}