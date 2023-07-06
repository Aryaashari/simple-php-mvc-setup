<?php

namespace Ewallet\Model\User;
use Ewallet\Domain\User;


class UpdateUserRequest {
    public string $newUsername, $name;
    public User $oldUserData;
    public array $profilePhoto;

    public function __construct(User $oldUserData, string $newUsername, string $name, array $profilePhoto) {
        $this->oldUserData = $oldUserData;
        $this->newUsername = $newUsername;
        $this->name = $name;
        $this->profilePhoto = $profilePhoto;
    }
}