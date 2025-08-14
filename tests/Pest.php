<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

// pest()->extend(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

use App\Database\UserGateway;
use App\Models\User;
use App\Models\ValueObjects\Password;
use App\Services\UserService;
// use Tests\TestCase;

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}



pest()->beforeEach(function () {
    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    senha TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)
");
    $this->gateway = new UserGateway($this->pdo);
    $this->service = new UserService($this->gateway);

    $this->validUser = new User([
        'nome' => 'João',
        'email' => 'joao@gmail.com',
        'senha' => new Password('Aa123123')
    ]);

    $this->fiveUsersModel = [
        new User([
            'nome' => 'João',
            'email' => 'joao@gmail.com',
            'senha' => new Password('Aa123123')
        ]),
        new User([
            'nome' => 'Maria',
            'email' => 'maria@gmail.com',
            'senha' => new Password('Bb234234')
        ]),
        new User([
            'nome' => 'Carlos',
            'email' => 'carlos@gmail.com',
            'senha' => new Password('Cc345345')
        ]),
        new User([
            'nome' => 'Ana',
            'email' => 'ana@gmail.com',
            'senha' => new Password('Dd456456')
        ]),
        new User([
            'nome' => 'Pedro',
            'email' => 'pedro@gmail.com',
            'senha' => new Password('Ee567567')
        ]),
    ];

})->afterEach(function() {
    $this->pdo->exec("DELETE FROM usuarios");
})->group('feature-users-arrange');
