<?php 

namespace Ewallet\Model\User;
use Ewallet\Domain\User;

class UpdatePasswordRequest {

    public string $oldPassword, $newPassword, $confirmNewPassword;
    public User $user;

    public function __construct(User $user, string $oldPassword, string $newPassword, string $confirmNewPassword) {
        $this->user = $user;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
        $this->confirmNewPassword = $confirmNewPassword;
    }

}