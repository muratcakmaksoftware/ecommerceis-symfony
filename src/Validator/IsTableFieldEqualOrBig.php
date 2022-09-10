<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class IsTableFieldEqualOrBig extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid.';
    public string $table = '';
    public string $column = '';
    public int $id;
    public string $exceptionMessage;

    public function __construct(string $table, string $column, int $id, string $exceptionMessage, $options = null, array $groups = null, $payload = null)
    {
        $options['table'] = $table;
        $options['column'] = $column;
        $options['id'] = $id;
        $options['exceptionMessage'] = $exceptionMessage;
        parent::__construct($options, $groups, $payload);
    }
}
