<?php

declare(strict_types=1);

namespace Application\Validator\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Application\Validator\AbstractValidator;

class TariffValidator extends AbstractValidator
{
    public function validate(array $data): array
    {
        $violations = $this->validator->validate($data, [
            new Assert\Collection([
                'id' => new Assert\Optional([
                    new Assert\Type(['type' => 'numeric']),
                    new Assert\Positive(),
                ]),
                'typeId' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'numeric']),
                    new Assert\Positive(),
                ],
                'name' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'string']),
                ],
                'description' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'string']),
                ],
                'price' => [
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'numeric']),
                    new Assert\Positive(),
                ],
                'is_active' => [
                    new Assert\Type(['type' => 'bool']),
                    new Assert\Choice([true, false]),
                ],
            ])
        ]);

        return $this->process($violations);
    }
}