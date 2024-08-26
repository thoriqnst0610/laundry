<?php

namespace laundry\Domain;

class User
{
    public string $id;
    public string $name;
    public string $password;
    public ?string $verification_code = null;
    public ?string $is_verified = null;
}
