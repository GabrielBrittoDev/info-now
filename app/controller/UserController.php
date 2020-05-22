<?php


use Rakit\Validation\Validator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class UserController
{

    use BaseController;

    private $user;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->user = new User;
    }


    public function create(){
        if ($this->guest()) {
            echo $this->renderView('register.html',array());
        }
    }

    public function store($request){
        try {
            if ($this->guest('home.html')) {
                $validator = new Validator;
                $validation = $validator->make($request, [
                    'name' => 'required|min:3|max:100',
                    'username' => 'required|min:3|max:20',
                    'email' => 'required|email',
                    'password' => 'required|min:6|max:20',
                    'confirm_password' => 'required|same:password'
                ]);

                // then validate
                $validation->validate();

                if ($validation->fails()) {
                    $errors = $validation->errors();
                    echo $this->renderView('register.html', ['errors' => $errors->firstOfAll()], 'user');
                    return;
                }
                $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT);

                $response = $this->user->create($request);

                echo $this->renderView('home.html', $response, 'home');
            }
        } catch (\Exception $e){
            echo $this->renderView('register.html', ['errors' => array($e->getMessage())], 'user');
        }
    }

    public function show(int $id){

    }

    public function edit(){}


}