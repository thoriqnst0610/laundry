<?php

namespace laundry\Service;

session_start();

use Exception;
use Gregwar\Captcha\CaptchaBuilder;


use laundry\Config\Database;
use laundry\Domain\User;
use laundry\Exception\ValidationException;
use laundry\Model\UserLoginRequest;
use laundry\Model\UserLoginResponse;
use laundry\Model\UserPasswordUpdateRequest;
use laundry\Model\UserPasswordUpdateResponse;
use laundry\Model\UserProfileUpdateRequest;
use laundry\Model\UserProfileUpdateResponse;
use laundry\Model\UserRegisterRequest;
use laundry\Model\UserRegisterResponse;
use laundry\Repository\UserRepository;
use PHPMailer\PHPMailer\PHPMailer;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->validateUserRegistrationRequest($request);

        $builder = new CaptchaBuilder;
        $builder->build();
        $phrase = $_SESSION['reg'];
        $userCaptcha = $request->capcha;

        if (strcasecmp($phrase, $userCaptcha) === 0) {
        } else {

            throw new ValidationException("Captcha Tidak Valid");
        }

        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->id);
            if ($user != null) {
                throw new ValidationException("User Id already exists");
            }

            $user = new User();
            $user->id = $request->id;
            $user->name = $request->name;
            $user->password = password_hash($request->password, PASSWORD_BCRYPT);
            $user->verification_code = $request->verification_code;

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;

            $this->kirim_email($request->verification_code);

            Database::commitTransaction();
            return $response;
        } catch (\Exception $exception) {
            Database::rollbackTransaction();
            throw $exception;
        }
    }

    private function validateUserRegistrationRequest(UserRegisterRequest $request)
    {
        if (
            $request->id == null || $request->name == null || $request->password == null ||
            trim($request->id) == "" || trim($request->name) == "" || trim($request->password) == ""
        ) {
            throw new ValidationException("Id, Name, Password tidak boleh kosong");
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse
    {

        $this->validateUserLoginRequest($request);

        $builder = new CaptchaBuilder;
        $builder->build();
        $phrase = $_SESSION['phrase'];
        $userCaptcha = $request->capcha;

        if (strcasecmp($phrase, $userCaptcha) === 0) {

            $user = $this->userRepository->findById($request->id);
            if ($user == null) {
                throw new ValidationException("Id atau password salah");
            }

            if($user->is_verified == 0){
                throw new ValidationException("Akun Belum Aktif");
            }
        } else {

            throw new ValidationException("Captcha Tidak Valid");
        }



        if (password_verify($request->password, $user->password)) {

            $response = new UserLoginResponse();
            $response->user = $user;

            return $response;
        } else {
            throw new ValidationException("Id or password is wrong");
        }
    }

    private function validateUserLoginRequest(UserLoginRequest $request)
    {
        if (
            $request->id == null || $request->password == null ||
            trim($request->id) == "" || trim($request->password) == ""
        ) {
            throw new ValidationException("Id atau password tidak boleh kosong");
        }
    }

    public function kirim_email(string $verification_code)
    {


            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'nstbotak@gmail.com';
                $mail->Password   = 'hmkn vlkp kywq dvsl';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('nstbotak@gmail.com', 'Botak Nst');
                $mail->addAddress('nstbotak@gmail.com', 'Thoriq Unsam');

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Verifikasi Email';
                $mail->Body    = 'http://localhost:8080/admin/verifikasi?verifikasi=' . $verification_code;

                $mail->send();
            } catch (Exception $e) {

                 throw $e;
                
            }
    }

    public function verifikasi(string $verifikasi):void
    {
        try{

            $this->userRepository->verifikasi($verifikasi);

        }catch(Exception $ex){

            throw $ex;

        }
        
    }
}
