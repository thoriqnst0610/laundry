<?php

namespace laundry\Service;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use laundry\Domain\Session;
use laundry\Domain\User;
use laundry\Repository\SessionRepository;
use laundry\Repository\UserRepository;

class SessionService
{

    public static string $COOKIE_NAME = "Token-Jwt";

    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->userRepository = $userRepository;
    }

    public function create(string $userId): Session
    {
        $session = new Session();
        
        $key = 'iniadalahaplikasilaundry12345';



        $payload = [
            'iss' => 'http://localhost:8080/',  // Issuer untuk pengembangan lokal
            'aud' => 'http://localhost:8080/',  // Audience untuk pengembangan lokal
            'iat' => time(),               // Issued At
            'exp' => time() + 3600        // Expiration Time (1 hour)
        ];
    
        // Encode JWT
        $jwt = JWT::encode($payload, $key, 'HS256');
        $session->id = $jwt;
    
        // Set JWT as a cookie



        
        $session->userId = $userId;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $jwt, time() + 3600, '/'); // Cookie expires in 1 hour

        return $session;
    }

    public function destroy()
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/");
    }

    public function current(): ?User
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $secret_key = 'iniadalahaplikasilaundry12345';

        $session = $this->sessionRepository->findById($sessionId);
        if($session == null){
            return null;
        }

        try {
            
            $decoded = JWT::decode($sessionId, new Key($secret_key, 'HS256'));
    
        } catch (Exception $e) {
            return null;
        }

        return $this->userRepository->findById($session->userId);
    }

}