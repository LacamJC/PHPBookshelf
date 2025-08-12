<?php

namespace App\Controllers;

use App\Core\LoggerTXT;
use App\Core\Response;
use App\Core\View;
use App\Database\Connection;
use App\Database\LivroGateway;
use App\Database\UserGateway;
use App\Interfaces\LoggerInterface;
use App\Middlewares\AuthMiddleware;
use App\Services\AuthService;
use App\Services\AvaliacaoService;
use App\Services\LivroService;
use App\Services\UserService;
use InvalidArgumentException;

class PageController
{
    private LivroService $LivroService;
    private UserService $UserService;
    private AuthService $AuthService;

    public function __construct(?LivroService $LivroService = null, ?UserService $UserService = null, ?AuthService $AuthService = null)
    {
        if($LivroService === null){
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $userGateway = new UserGateway($conn);
            $livroGateway = new LivroGateway($conn);

            $LivroService = new LivroService($livroGateway);
            $UserService = new UserService($userGateway);
            $AuthService = new AuthService();
        }
        $this->LivroService = $LivroService;
        $this->UserService = $UserService;
        $this->AuthService = $AuthService;
    }

    public function home(): Response
    {
        try{
            AuthMiddleware::handle();
            return Response::view('home');
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@home: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function lista(): Response
    {
        try{
            AuthMiddleware::handle();
            return Response::view('livros/lista');
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@lista: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }

    }

    public function cadastro(): Response
    {
        try{
            return Response::view('cadastro');
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@cadastro: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function cadastrarLivro(): Response
    {
        try{
            AuthMiddleware::handle();
            return Response::view('livros/cadastro');
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@cadastrarLivro: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function view(array $params = []): Response
    {
        try{
            AuthMiddleware::handle();
            $id = $params['id'] ?? null;
            return Response::view('livros/visualizar', [
                'livro' => $this->LivroService->findById($id),
                'comentarios' => AvaliacaoService::buscarComentarios($id)
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@view: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function editarAvaliacao($params = [])
    {
        $id = $params['id'];
        if ($id == null) {
            Response::redirect("livros/{$id}", 'Erro ao acessar comentario para edição', 'warning');
        }

        $result = AvaliacaoService::editarComentario($id);
        // não desenvolvido
    }

    public function edit($params = []): Response
    {
        try{
            AuthMiddleware::handle();
            $id = $params['id'] ?? null;
            return Response::view('livros/editar', [
                'livro' => $this->LivroService->findById($id)
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@edit: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function login(): Response
    {
        return Response::view('login');
    }

    public function editUser($params = []): Response
    {
        try{
            $id = $params['id'];
            $token = $params['token'];
            AuthMiddleware::handle();
            AuthMiddleware::token($token);
            $user = $this->UserService->findById($id);
            $this->AuthService->setForm($user);
            return Response::view('usuarios/editar', [
                'user' => $user
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@editUser: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }
}
