<?php declare(strict_types=1);

namespace Validator\Request;

use Symfony\Component\Validator\Constraints as Assert;
use Validator\AbstractValidator;

class TariffValidator extends AbstractValidator
{
    public function validate(array $data): array
    {
        $violations = $this->validator->validate($data, [
            new Assert\Collection([
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
                    new Assert\NotBlank(),
                    new Assert\Type(['type' => 'bool']),
                ],
            ])
        ]);

        return $this->process($violations);
    }
}