<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/tokenizer.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/authManager.php';

class AuthController {
    protected $authManager;

    public function __construct() {
        $this->authManager = new AuthManager();
    }

    public function login() {
        $request = json_decode(file_get_contents('php://input'), true);

        // TODO: handle missing/optional datas
        $email = filter_var(trim($request["email"]), FILTER_VALIDATE_EMAIL);
        $password = isset($request['password'])? $request["password"] : '';

        if(!$email) return ['success'=>false, 'message' => 'Invalid email address'];

        $matches = $this->authManager->checkUser($email, $password);

        if ($matches){
            $token = Tokenizer::generateToken($email);

            setcookie("auth_token", $token, [
                "httponly" => true,  // Prevent XSS atack via Javascript
                "samesite" => "Strict", // Prevent CSRF attacks
                "expires" => time() + (60 * 60 * 24 * 30) // 30 days
            ]);
    
            return ['success'=>true, 'message'=>'Succesfully connected'];
        }
        
        return ['success'=>false, 'message' => 'Email or password is incorrect'];
    }

    public function signup() {
        $request = json_decode(file_get_contents('php://input'), true);
        
        // TODO: handle missing/optional datas
        $names = filter_var(trim($request["fnames"]), FILTER_SANITIZE_STRING);
        $surnames = isset($request["lnames"]) ? filter_var(trim($request["lnames"]), FILTER_SANITIZE_STRING) : null;
        $email = filter_var(trim($request["email"]), FILTER_VALIDATE_EMAIL);
        $phone = filter_var(trim($request["phone"], FILTER_SANITIZE_STRING));
        $birth_date = isset($request["birth_date"]) ? filter_var($request["birth_date"], FILTER_SANITIZE_STRING) : null;
        $gender = isset($request["gender"]) ? filter_var($request["gender"], FILTER_SANITIZE_STRING) : null;
        $role = filter_var($request["role"], FILTER_SANITIZE_STRING);
        $password = isset($request["password"])? $request["password"]: "";

        if(!$email) return ['success'=>false, 'message' => 'Invalid email address'];
        if(!$role) return ['success'=>false, 'message' => 'A role must be specified'];
        if(!$phone) return ['success'=>false, 'message' => 'A phone number must be specified'];
        
        if ($this->authManager->getUserByEmail($email)) {
            return ['success'=>true, 'message' => 'A user with that email address already exists'];
        }
        
        $userId = $this->authManager->createUser(
            $names, $surnames, $email, $phone, $birth_date, $gender, $role, $password
        );
        
        if ($userId) {
            $token = Tokenizer::generateToken($email);

            setcookie("auth_token", $token, [
                "httponly" => true,  // Prevent XSS atack via Javascript
                "samesite" => "Strict", // Prevent CSRF attacks
                "expires" => time() + (60 * 60 * 24 * 30) // 30 days
            ]);
    
            return ['success'=>true, 'message'=>'Sign up succesfull'];
        }
        return ['success'=>false, 'message' => 'Signup failed'];
    }

    public function logout() {
        // TODO: create this for the logout page backend
        setcookie("auth_token", "", [
            "expires" => time() - 3600,
            "path" => "/",
            "httponly" => true,
            "samesite" => "Strict"
        ]);

        return  ["success" => "Succesfully disconnected"];
    }

    public function checkAuthentification() {
        if(isset($_COOKIE['auth_token'])) {
            $token = $_COOKIE['auth_token'];
            $payload = Tokenizer::decodeToken($token);

            if($payload != null && isset($payload["expires"]) && $payload['expires']>time()) {
                if(isset($payload["email"])) {
                    return $this->authManager->getUserByEmail($payload["email"]);
                }
            }
            else if(isset($payload["expires"]) && $payload['expires']<time()) {
                // logout();
            }
        }

        return null;
    }
}
?>