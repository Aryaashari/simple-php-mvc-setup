<?php

namespace Ewallet\Service;

use Ewallet\Config\App;
use Ewallet\Domain\User;
use Ewallet\Exception\ValidationException;
use Ewallet\Model\User\UpdatePasswordRequest;
use Ewallet\Model\User\UpdateUserRequest;
use Ewallet\Repository\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserService {

    private UserRepository $userRepo;

    public function __construct(UserRepository $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function getByUsername(string $username) : ?User {
        try {
            return $this->userRepo->findByUsername($username);
        } catch(\Exception $e) {
            throw $e;
        }
    }


    public function edit(UpdateUserRequest $request) : void {
        try {
            // validasi request
            if($request->name == "") {
                throw new ValidationException("Name is required!");
            } else if (!preg_match_all('/^[a-zA-Z\s]*$/',$request->name)) {
                throw new ValidationException("Name is must alphabet or space!");
            } else if(strlen($request->name) < 3) {
                throw new ValidationException("Name min 3 characters!");
            } else if(strlen($request->name) > 30) {
                throw new ValidationException("Name max 30 characters!");
            }

            if($request->newUsername == "") {
                throw new ValidationException("Username is required!");
            } else if(!preg_match_all('/^[a-zA-Z_0-9]*$/', $request->newUsername)) {
                throw new ValidationException("Username must be valid(a-z, A-Z, 0-9, _)!");
            } else if(strlen($request->newUsername) < 3) {
                throw new ValidationException("Username min 3 characters!");
            } else if(strlen($request->newUsername) > 10) {
                throw new ValidationException("Username max 10 characters!");
            } else if($this->userRepo->findByUsername($request->newUsername) != null && $request->oldUserData->username != $request->newUsername) {
                throw new ValidationException("Username is already exist!");
            }


            // upload file
            // var_dump($request->profilePhoto);
            if ($request->profilePhoto["size"] != 0) {

                // validasi file
                if ($request->profilePhoto["type"] != "image/jpg" && $request->profilePhoto["type"] != "image/jpeg" && $request->profilePhoto["type"] != "image/png") {
                    throw new ValidationException("File type must be jpg,jpeg, or png!");
                } else if ($request->profilePhoto["size"] > 5*1000000) {
                    throw new ValidationException("Max file size must be 5MB!");
                }

                // check user profile is default photo
                if ($request->oldUserData->profile_photo != "user.png") {
                    if (!unlink(dirname(getcwd())."/public/assets/img/profile/".$request->oldUserData->profile_photo)) {
                        throw new \Exception("Error deleting files");
                    }
                }

                // store to directory
                $fileName = $request->newUsername."-".time().".png";
                $targetPath = dirname(getcwd())."/public/assets/img/profile/".$fileName;

                if (!move_uploaded_file($request->profilePhoto["tmp_name"], $targetPath)) {

                    throw new \Exception("Error store file!");

                }

                $request->oldUserData->profile_photo = $fileName;
                
            }

            $this->userRepo->update(new User($request->name, $request->oldUserData->email, $request->newUsername, $request->oldUserData->password, $request->oldUserData->profile_photo, $request->oldUserData->email_verified, $request->oldUserData->email_verified_time, $request->oldUserData->create_time, null), $request->oldUserData->username);

            // update JWT token username value
            $existingToken = $_COOKIE["APP_AUTH_SESSION"];
            $decodedToken = JWT::decode($existingToken, new Key(App::$appKey, "HS256"));

            // Modify the desired claims or payload data
            $decodedToken->username = $request->newUsername;

            // Generate a new JWT token using the modified claims or payload
            $payload = [
                "session_id" => $decodedToken->session_id,
                "username" => $decodedToken->username
            ];

            $newToken = JWT::encode($payload, App::$appKey, 'HS256');

            setcookie("APP_AUTH_SESSION", $newToken, 0, "/");

        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function editPassword(UpdatePasswordRequest $request) : User {
        try {

            if($request->oldPassword == "") {
                throw new ValidationException("Old password is required!");
            } else if(strlen($request->oldPassword) < 8) {
                throw new ValidationException("Old password min 8 characters!");
            } else if(!password_verify($request->oldPassword, $request->user->password)) {
                throw new ValidationException("Old password invalid!");
            }

            if($request->newPassword == "") {
                throw new ValidationException("Password confirmation is required!");
            } else if(strlen($request->newPassword) < 8) {
                throw new ValidationException("Password confirmation min 8 characters!");
            } else if($request->newPassword !== $request->confirmNewPassword) {
                throw new ValidationException("Password confirmation is not same with password!");
            }

            $request->user->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $user = $this->userRepo->update($request->user, $request->user->username);

            return $user;

        } catch (\Exception $e) {
            throw $e;
        }
    }

}