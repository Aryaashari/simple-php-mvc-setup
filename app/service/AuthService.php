<?php

namespace Ewallet\Service;

use Ewallet\Domain\User;
use Ewallet\Exception\ValidationException;
use Ewallet\Model\Auth\RegisterRequest;
use Ewallet\Repository\UserRepository;

class AuthService {

    private UserRepository $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(RegisterRequest $request) {

        // Validasi request
        if($request->name == "") {
            throw new ValidationException("Name is required!");
        } else if (!preg_match_all('/^[a-zA-Z\s]*$/',$request->name)) {
            throw new ValidationException("Name is must alphabet or space!");
        } else if(strlen($request->name) < 3) {
            throw new ValidationException("Name min 3 characters!");
        } else if(strlen($request->name) > 30) {
            throw new ValidationException("Name max 30 characters!");
        }

        
        if($request->email == "") {
            throw new ValidationException("Email is required!");
        } else if(!preg_match('/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $request->email)) {
            throw new ValidationException("Email must be type of email!");
        } else if($this->userRepo->findByEmail($request->email) != null) {
            throw new ValidationException("Email is already exist!");
        }
        
        if($request->username == "") {
            throw new ValidationException("Username is required!");
        } else if(!preg_match_all('/^[a-zA-Z_0-9]*$/', $request->username)) {
            throw new ValidationException("Username must be valid(a-z, A-Z, 0-9, _)!");
        } else if(strlen($request->username) < 3) {
            throw new ValidationException("Username min 3 characters!");
        } else if(strlen($request->username) > 10) {
            throw new ValidationException("Username max 10 characters!");
        } else if($this->userRepo->findByUsername($request->username) != null) {
            throw new ValidationException("Username is already exist!");
        }


        if($request->password == "") {
            throw new ValidationException("Password is required!");
        } else if(strlen($request->password) < 8) {
            throw new ValidationException("Password min 8 characters!");
        }

        if($request->confirmPassword == "") {
            throw new ValidationException("Password confirmation is required!");
        } else if(strlen($request->confirmPassword) < 8) {
            throw new ValidationException("Password confirmation min 8 characters!");
        } else if($request->password !== $request->confirmPassword) {
            throw new ValidationException("Password confirmation is not same with password!");
        }


        if($request->pin == "") {
            throw new ValidationException("PIN Number is required!");
        } else if (!preg_match_all('/^[0-9]*$/',$request->pin)) {
            throw new ValidationException("PIN Number must be integer!");
        } else if(strlen($request->pin) != 6) {
            throw new ValidationException("PIN Number must be 6 characters!");
        }

        // Create Data User
        $user = $this->userRepo->create(new User(null, $request->name, $request->email, $request->username, password_hash($request->password, PASSWORD_BCRYPT), "user.jpg", false, null));

        // Create wallet for user

        // Send verification link to user's email

        // Return Response

    }


}