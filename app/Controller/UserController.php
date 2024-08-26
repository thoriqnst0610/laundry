<?php

namespace laundry\Controller;

require_once __DIR__ . '/../../vendor/autoload.php';

use Exception;
use Gregwar\Captcha\CaptchaBuilder;


use laundry\App\View;
use laundry\Config\Database;
use laundry\Exception\ValidationException;
use laundry\Model\UserLoginRequest;
use laundry\Model\UserPasswordUpdateRequest;
use laundry\Model\UserProfileUpdateRequest;
use laundry\Model\UserRegisterRequest;
use laundry\Repository\SessionRepository;
use laundry\Repository\UserRepository;
use laundry\Service\SessionService;
use laundry\Service\UserService;

class UserController
{
    private UserService $userService;
    private SessionService $sessionService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    public function register()
    {

        header('Content-Type: image/jpeg');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');

        $builder = new CaptchaBuilder;
        $builder->build();
        $_SESSION['reg'] = $builder->getPhrase();
        $builder->output();
    }

    public function postRegister()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');



        try {

            $this->userService->cek_data_register();

            $request = new UserRegisterRequest();
            $request->id = $_POST['id'];
            $request->name = $_POST['name'];
            $request->capcha = $_POST['captcha'];

            $request->password = $_POST['password'];
            $request->verification_code = bin2hex(random_bytes(16));

            $this->userService->register($request);
            http_response_code(200);
            echo json_encode(['message' => 'menunggu admin mengaktifkan akun']);
        } catch (ValidationException $exception) {

            http_response_code(400);
            echo json_encode(['message' => $exception->getMessage()]);
        }
    }

    public function verifikasi()
    {

        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');

        try {

            $this->userService->verifikasi(htmlspecialchars($_GET['verifikasi']));

            http_response_code(200);
            echo json_encode(['message' => 'verifikasi berhasil']);
        } catch (Exception $ex) {

            http_response_code(400);
            echo json_encode(['message' => 'verifikasi gagal', 'error' => $ex->getMessage()]);
        }
    }

    public function login()
    {

        header('Content-Type: image/jpeg');
        header('Access-Control-Allow-Methods: GET');
        header('Access-Control-Allow-Origin: *');

        $builder = new CaptchaBuilder;
        $builder->build();
        $_SESSION['phrase'] = $builder->getPhrase();

        header('Content-type: image/jpeg');
        $builder->output();
    }

    public function postLogin()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Origin: *');



        try {

            $this->userService->cek_data_login();

            $request = new UserLoginRequest();
            $request->id = $_POST['id'];
            $request->password = $_POST['password'];
            $request->capcha = $_POST['captcha'];

            $response = $this->userService->login($request);
            $this->sessionService->create($response->user->id);

            http_response_code(200);
            echo json_encode(['message' => 'berhasil login']);
        } catch (ValidationException $exception) {

            http_response_code(400);
            echo json_encode(['message' => 'gagal login', 'pesan' => $exception->getMessage()]);
        }
    }

    public function logout()
    {
        $this->sessionService->destroy();
        View::redirect("/");
    }
}
