<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class TableRecordExists extends Constraint
{
    public string $message = 'The value "{{ value }}" is not valid.';
    public string $table = '';
    public ?string $id = null;
    public function __construct(string $table, $options = null, array $groups = null, $payload = null)
    {
        $options['table'] = $table;
        parent::__construct($options, $groups, $payload);
    }

    /**
     * @return string
     */
    public function getDefaultOption(): string
    {
        return 'table';
    }

    /**
     * @return string[]
     */
    public function getRequiredOptions(): array
    {
        return ['table'];
    }
}
