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
     * @Assert\NotBlank(message="Name cannot be empty")
     *
     * @Groups({"safe"})
     */
    public $name;

    /**
     * @var string
     *
     * @Groups({"safe"})
     */
    public $lastName;

    /**
     * @var string
     *
     * @Assert\NotBlank("Email cannot be empty")
     * @Assert\Email()
     *
     * @Groups({"safe"})
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Password cannot be empty")
     * @Assert\Length(min=8, max=32)
     * @Password()
     *
     */
    public $password;

    /**
     * @var string
     *
     * @Assert\EqualTo(propertyPath="password", message="Password confirmation should be equal to password")
     */
    public $confirmation;
}
