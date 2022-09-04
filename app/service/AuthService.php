<?php

namespace Ewallet\Service;

use Ewallet\Exception\ValidationException;
use Ewallet\Model\Auth\RegisterRequest;

class AuthService {


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
        }
        
        if($request->username == "") {
            throw new ValidationException("Username is required!");
        } else if(!preg_match('/^[a-zA-Z_0-9]$/', $request->username)) {
            throw new ValidationException("Username must be valid(a-z, A-Z, 0-9, _)!");
        } else if(strlen($request->username) < 3) {
            throw new ValidationException("Username min 3 characters!");
        } else if(strlen($request->username) > 10) {
            throw new ValidationException("Username max 10 characters!");
        }


        if($request->password == "") {
            throw new ValidationException("Password is required!");
        } else if(strlen($request->password) < 8) {
            throw new ValidationException("Password min 8 characters!");
        }

        if($request->confirmPassword == "") {
            throw new ValidationException("Password confirmation is required!");
        } else if(strlen($request->confirmPassword) < 8) {
            throw new ValidationException("Confirmation password min 8 characters!");
        } else if($request->password !== $request->confirmPassword) {
            throw new ValidationException("Confirmation password is not same with password!");
        }

        // Create Data User

        // Send verification link to user's email

        // Return Response

    }


}