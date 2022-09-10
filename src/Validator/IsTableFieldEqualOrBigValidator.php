<?php

namespace App\Validator;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsTableFieldEqualOrBigValidator extends ConstraintValidator
{
    private ManagerRegistry $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @param $value
     * @param Constraint $constraint
     * @return void
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\IsTableFieldBig $constraint */

        if (null === $value || '' === $value) {
            // TODO: implement the validation here
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        } else {
            $record = $this->managerRegistry->getRepository($constraint->table)->findOneBy([
                'id' => $constraint->id
            ]);

            if (is_null($record)) { //Entity mevcut degilse exception firlatilir
                throw (new EntityNotFoundException())::fromClassNameAndIdentifier($constraint->table, [$constraint->id]);
            } else {
                if($value > $record->{'get'.ucfirst($constraint->column)}()){
                    throw new Exception($constraint->exceptionMessage);
                }
            }
        }
    }
}
