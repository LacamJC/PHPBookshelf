<?php

return function (PDO $conn) {
    $drop =
        "
            DROP TABLE IF EXISTS likes_dislikes;
            DROP TABLE IF EXISTS avaliacoes;
            DROP TABLE IF EXISTS livros;
            DROP TABLE IF EXISTS usuarios;
        "
    ;


    try {
        $conn->exec($drop);

        print "tabelas deletadas com sucesso" . PHP_EOL;
    } catch (\Exception $e) {
        echo $e->getMessage();
        exit(1);
    }
};
