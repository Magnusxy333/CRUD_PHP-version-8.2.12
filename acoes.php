<?php 
session_start();
require 'conexao.php'; // Certifique-se que este arquivo define $conn

if (isset($_POST['create_usuario'])) {
    // 1. Limpeza dos dados e uso da variável correta ($conn)
    $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conn, trim($_POST['data_nascimento']));
    $senha_bruta = trim($_POST['senha']);

    // 2. VALIDAÇÃO: Impede que campos vazios sejam enviados ao banco
    if (empty($nome) || empty($email) || empty($senha_bruta)) {
        $_SESSION['mensagem'] = 'Usuário não foi criado >:3';
        header('Location: index.php');
        exit;
    }

    // 3. Criptografia da senha correta
    $senha = password_hash($senha_bruta, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, data_nascimento, senha) VALUES ('$nome', '$email', '$data_nascimento', '$senha')";

    // Executa a query usando $conn
    if (mysqli_query($conn, $sql)) {
        $_SESSION['mensagem'] = 'Usuário criado com sucesso :3';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Usuário não foi criado >:3';
        header('Location: index.php');
        exit;
    }
}

    if (isset($_POST['update_usuario'])) {
        
        $usuario_id = mysqli_real_escape_string($conn, $_POST['usuario_id']);

        $nome = mysqli_real_escape_string($conn, trim($_POST['nome']));
        $email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $data_nascimento = mysqli_real_escape_string($conn, trim($_POST['data_nascimento']));
        $senha = mysqli_real_escape_string($conn, trim($_POST['senha']));

        $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento'";

        if (!empty($senha)) {
            $sql .= ", senha ='" . password_hash ($senha, PASSWORD_DEFAULT) . "'";
        }

        $sql .= " WHERE id = '$usuario_id'";

        mysqli_query($conn, $sql);

        if (mysqli_affected_rows($conn) > 0) {
            $_SESSION['mensagem'] = 'Usuário Atualizado com sucesso owo';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Usuário não foi Atualizado com sucesso çwç';
            header('Location: index.php');
            exit;
        }
    }

    if(isset($_POST['delete_usuario'])) {
        $usuario_id = mysqli_real_escape_string($conn, $_POST['delete_usuario']);
        
        $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";

        mysqli_query($conn, $sql);

        if(mysqli_affected_rows($conn) > 0 ) {
            $_SESSION['message'] = 'Usuario deletado com sucesso!!! OWO';
            header('Location: index.php');
            exit;
        } else {
            $_SESSION['message'] = 'Usuarionão foi deletado ~w~';
            header('Location: index.php');
            exit;
        }
    }
?>