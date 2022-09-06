<?php

namespace Ewallet\Service;

use Ewallet\Domain\User;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Repository\EmailVerificationRepository;
use Ewallet\Repository\UserRepository;
use Ewallet\Repository\WalletRepository;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase {


    private AuthService $authService;
    private UserRepository $userRepo;

    public function setUp() : void{
        $this->userRepo = new UserRepository;
        $this->authService = new AuthService(new WalletRepository, new EmailVerificationRepository, $this->userRepo);
        $this->userRepo->deleteAll();
    }


    public function testRegisterValidationName() : void{
        // Name is Required
        // $this->expectExceptionMessage("Name is required!");
        // $this->authService->register(new RegisterRequest(null, "arya@gmail.com", "arya", "12345678", "12345678", "123456"));

        // Name must alphabet or space
        // $this->expectExceptionMessage("Name is must alphabet or space!");
        // $this->authService->register(new RegisterRequest("Arya Ashari", "arya@gmail.com", "arya", "12345678", "12345678", "123456"));

         // Name min 3 characters
        //  $this->expectExceptionMessage("Name min 3 characters!");
        //  $this->authService->register(new RegisterRequest("Ar", "arya@gmail.com", "arya", "12345678", "12345678", "123456"));


        // Name max 30 characters
        //  $this->expectExceptionMessage("Name max 30 characters!");
        //  $this->authService->register(new RegisterRequest("Arasdsad asdasdasd asdasdasd asdsadasdasdsads", "arya@gmail.com", "arya", "12345678", "12345678", "123456"));
    }


    public function testRegisterEmailValidation() : void {
        // Email is required
        //  $this->expectExceptionMessage("Email is required!");
        //  $this->authService->register(new RegisterRequest("Arya", "", "arya", "12345678", "12345678", "123456"));

        // Email must be type of email
        // $this->expectExceptionMessage("Email must be type of email!");
        // $this->authService->register(new RegisterRequest("Arya", "arya@gmail", "arya", "12345678", "12345678", "123456"));

        // Email is already exist
        $this->expectExceptionMessage("Email is already exist!");
        $this->userRepo->create(new User(null, "Arya", "arya@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $this->authService->register(new RegisterRequest("Arya", "arya@gmail.com", "arya", "12345678", "12345678", "123456"));
    }


    public function testRegisterUsernameValidation() : void {
        // Username is required
        // $this->expectExceptionMessage("Username is required!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "", "12345678", "12345678", "123456"));

        // Username must be valid(a-z, A-Z, 0-9, _)
        // $this->expectExceptionMessage("Username must be valid(a-z, A-Z, 0-9, _)!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "Arya%123", "12345678", "12345678", "123456"));

        // Username min 3 characters
        // $this->expectExceptionMessage("Username min 3 characters!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "Ar", "12345678", "12345678", "123456"));

        // Username max 10 characters
        // $this->expectExceptionMessage("Username max 10 characters!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "Aryaashariiiiii", "12345678", "12345678", "123456"));

        // Username is already exist
        $this->expectExceptionMessage("Username is already exist!");
        $this->userRepo->create(new User(null, "Arya", "arya@gmail.com", "arya", "12345678", "arya.jpg", false, null));
        $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345678", "123456"));
    }

    public function testRegisterPasswordValidation() : void {
        // Password is required
        // $this->expectExceptionMessage("Password is required!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "", "12345678", "123456"));

        // Password min 8 characters
        $this->expectExceptionMessage("Password min 8 characters!");
        $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "123456", "12345678", "123456"));
    }

    public function testRegisterConfirmPasswordValidation() : void {
        // Password confirmation is required
        // $this->expectExceptionMessage("Password confirmation is required!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "", "123456"));

        // Password confirmation min 8 characters
        // $this->expectExceptionMessage("Password confirmation min 8 characters!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345", "123456"));

        // Password confirmation is not same with password
        $this->expectExceptionMessage("Password confirmation is not same with password!");
        $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345789", "123456"));
    }

    public function testRegisterPinValidation() : void {
        // PIN Number is required
        // $this->expectExceptionMessage("PIN Number is required!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345678", ""));

        // PIN Number must be integer
        // $this->expectExceptionMessage("PIN Number must be integer!");
        // $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345678", "asd"));

        // PIN Number must be 6 characters
        $this->expectExceptionMessage("PIN Number must be 6 characters!");
        $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345678", "12345"));
        $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345678", "1234567"));
    }


    public function testRegisterSendEmail() : void {
        $register = $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "arya", "12345678", "12345678", "123456"));
        $this->assertTrue($register);
    }

}