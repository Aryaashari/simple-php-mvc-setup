<?php

namespace Ewallet\Controller;

use Ewallet\App\View;
use Ewallet\Exception\ValidationException;
use Ewallet\Helper\Auth;
use Ewallet\Helper\FlashMessage;
use Ewallet\Model\User\UpdatePasswordRequest;
use Ewallet\Model\User\UpdateUserRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Service\UserService;

class UserController {

    private UserService $userService;

    public function __construct(){
        $this->userService = new UserService(new UserRepository, new EmailVerificationRepository);
    }

    public function profile() {
        try {

            $user = Auth::User();
            $data = [
                "fullName" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                "photo" => $user->profile_photo
            ];
    
            View::render('/../view/user/profile.php', $data);

        } catch(\Exception $e) {
            var_dump("Error 500");
            var_dump($e);
            exit();
        }
    }

    public function editProfile() {

        $name = htmlspecialchars($_POST["name"]) ?? "";
        $username = htmlspecialchars($_POST["username"]) ?? "";


        try {

            $profilePhoto = $_FILES["profilePhoto"];
    
    
            $user = Auth::User();
    
            $this->userService->edit(new UpdateUserRequest($user, $username, $name, $profilePhoto));
            
            View::redirect('/users/profile');
        } catch(ValidationException $e) {
            FlashMessage::Send('error', $e->getMessage());
            View::redirect('/users/profile');
        } catch(\Exception $e) {
            var_dump("Error 500");
            var_dump($e);
            exit();
        }


    }



    public function changePasswordView() : void {
        View::render('/../view/user/change-password.php');
    }

    public function changePassword() : void {
        $oldPassword = htmlspecialchars($_POST["oldPassword"]);
        $newPassword = htmlspecialchars($_POST["newPassword"]);
        $confirmNewPassword = htmlspecialchars($_POST["confirmNewPassword"]);


        try {
            $user = Auth::User();
            $this->userService->editPassword(new UpdatePasswordRequest($user, $oldPassword, $newPassword, $confirmNewPassword));

            View::redirect('/');
            FlashMessage::Send('success', 'Change password successfully');
        } catch(ValidationException $e) {
            View::redirect('/password/change');
            FlashMessage::Send('error', $e->getMessage());
        } catch(\Exception $e) {
            var_dump("Error 500");
            var_dump($e);
            exit();
        }

    }

    public function forgotPasswordView() : void {
        View::render('/../view/user/forgot-password.php');
    }

    public function forgotPassword() : void {
        $email = trim($_POST["email"]) ?? "";


    }

    public function resetPasswordView() : void {
        View::render('/../view/user/reset-password.php');
    }


}