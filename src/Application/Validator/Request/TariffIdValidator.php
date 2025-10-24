<?php

declare(strict_types=1);

namespace Application\Validator\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Application\Validator\AbstractValidator;

class TariffIdValidator extends AbstractValidator
{
    public function validate(mixed $id): array
    {
        $violations = $this->validator->validate($id, [
            new Assert\NotBlank(),
            new Assert\Type(['type' => 'numeric']),
            new Assert\Positive(),
        ]);

        return $this->process($violations);
    }
}