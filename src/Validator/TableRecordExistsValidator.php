<?php

namespace App\Validator;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TableRecordExistsValidator extends ConstraintValidator
{

    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof TableRecordExists) {
            throw new UnexpectedTypeException($constraint, TableRecordExists::class);
        }

        if (null === $value || '' === $value) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        } else {
            if (is_null($this->managerRegistry->getRepository($constraint->table)->findOneBy([
                'id' => $value ?? $constraint->id
            ]))) { //Entity mevcut degilse exception firlatilir
                throw (new EntityNotFoundException())::fromClassNameAndIdentifier($constraint->table, [$value]);
            }
        }
    }
}
