<?php

namespace Ewallet\Service;

use Ewallet\Domain\User;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class AuthServiceTest extends TestCase {


    private AuthService $authService;
    private UserRepository $userRepo;

    public function setUp() : void{
        $this->userRepo = new UserRepository;
        $this->authService = new AuthService($this->userRepo);
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
        $this->expectExceptionMessage("Username is required!");
        $this->authService->register(new RegisterRequest("Arya", "aryaashari@gmail.com", "", "12345678", "12345678", "123456"));
    }


}