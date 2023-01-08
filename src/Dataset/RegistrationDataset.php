<?php

namespace App\Dataset;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\Validator\Password;

class RegistrationDataset implements DatasetInterface
{

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Groups({"safe"})
     */
    public $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Groups({"safe"})
     */
    public $lastName;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @Groups({"safe"})
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min=8, max=32)
     * @Password()
     *
     */
    public $password;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @Assert\EqualTo(propertyPath="password")
     */
    public $confirmation;
}
