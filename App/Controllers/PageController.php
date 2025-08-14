<?php

namespace App\Controllers;

use App\Core\LoggerTXT;
use App\Core\Response;
use App\Core\View;
use App\Database\AvaliacaoGateway;
use App\Database\Connection;
use App\Database\LivroGateway;
use App\Database\UserGateway;
use App\Interfaces\LoggerInterface;
use App\Middlewares\AuthMiddleware;
use App\Services\AuthService;
use App\Services\AvaliacaoService;
use App\Services\LivroService;
use App\Services\UserService;
use App\Widgets\Card;
use DomainException;
use InvalidArgumentException;

class PageController
{
    private LivroService $LivroService;
    private UserService $UserService;
    private AuthService $AuthService;
    private AvaliacaoService $AvaliacaoService;

    public function __construct(?LivroService $LivroService = null, ?UserService $UserService = null, ?AuthService $AuthService = null, ?AvaliacaoService $AvaliacaoService = null)
    {
        if($LivroService === null){
            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $userGateway = new UserGateway($conn);
            $livroGateway = new LivroGateway($conn);
            $avaliacaoGateway = new AvaliacaoGateway($conn);

            $LivroService = new LivroService($livroGateway);
            $UserService = new UserService($userGateway);
            $AvaliacaoService = new AvaliacaoService($avaliacaoGateway);
            $AuthService = new AuthService();
        }
        $this->LivroService = $LivroService;
        $this->UserService = $UserService;
        $this->AuthService = $AuthService;
        $this->AvaliacaoService = $AvaliacaoService;
    }

    public function teste(): Response{
        return Response::view('teste', ['nome' => 'joao']);
    }

    public function home(): Response
    {
        try{
            AuthMiddleware::handle();
            return Response::view('home', [
                'pageTitle' => 'Home'
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@home: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function lista(): Response
    {
        try{
            AuthMiddleware::handle();

            $conn = Connection::open($_ENV['CONNECTION_NAME']);
            $gateway = new LivroGateway($conn);
            $service = new LivroService($gateway);
            $selfPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $data = $service->all($selfPage);
            $lastPageValue = $selfPage > 1 ? $selfPage - 1 : 1;
            $nextPageValue = $selfPage < $data['totalPages'] ? $selfPage + 1 : $data['totalPages'];

            return Response::view('livros/lista', [
                'livros' => $data['livros'],
                'ant' => $lastPageValue,
                'next' => $nextPageValue,
                'totalPages' => $data['totalPages'],
                'currentPage' => $data['page'],
                'pageTitle' => 'Livros',
                'card' => new Card()
            ]);
        }catch(InvalidArgumentException $e){
            return Response::redirect('home', $e->getMessage(), 'warning');
        } catch(\Exception $e){
            LoggerTXT::log('PageController@lista: ' . $e->getMessage(), 'error');
            return Response::redirect('home', 'Desculpe houve um erro interno no sistema', 'danger');
        }
    }

    public function cadastro(): Response
    {
        try{
            return Response::view('cadastro', [
                'pageTitle' => 'Cadastro'
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@cadastro: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function cadastrarLivro(): Response
    {
        try{
            AuthMiddleware::handle();
            return Response::view('livros/cadastro', [
                'pageTitle' => 'Cadastro de livros'
            ]);
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
            $livro = $this->LivroService->findById($id);
            return Response::view('livros/visualizar', [
                'livro' => $livro,
                'capa' => '/' . ($livro->capa_path)
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
                'livro' => $this->LivroService->findById($id),
                'pageTitle' => 'Editar Livro'
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@edit: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }

    public function login(): Response
    {
        return Response::view('login', [
            'pageTitle' => 'Login'
        ]);
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
                'user' => $user,
                'token' => $_ENV['EDIT_TOKEN']
            ]);
        }catch(InvalidArgumentException $e){
            LoggerTXT::log('PageController@editUser: ' . $e->getMessage(), 'error');
            return Response::redirect('login', 'Desculpe tivemos um erro ao acessar está página', 'danger');
        }
    }
}
