<?php

namespace laundry\Model;

class UserRegisterRequest
{
    public ?string $id = null;
    public ?string $name = null;
    public ?string $password = null;
    public ?string $capcha = null;
    public ?string $verification_code = null;
}