<?php

namespace laundry\Model;

class UserLoginRequest
{
    public ?string $id = null;
    public ?string $password = null;
    public ?string $capcha = null;
    public ?string $verification_code = null;
}