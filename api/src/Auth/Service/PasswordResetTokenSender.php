<?php

namespace App\Auth\Service;

use App\Auth\Entity\User\Email;
use App\Auth\Entity\User\Token;

interface PasswordResetTokenSender
{
    public function send(Email $email, Token $token): void;
}