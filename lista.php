<?php
include "PHPdb.php"; // Inclui o arquivo de conexão

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verifica se o formulário de exclusão foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $conn->real_escape_string($_POST['id']);

    // Prepara e executa a exclusão
    $sql = "DELETE FROM Cadastro WHERE idCad = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redireciona de volta para a lista após a exclusão
        header("Location: lista.php");
        exit();
    } else {
        echo "Erro ao excluir o registro: " . $conn->error;
    }

    $stmt->close();
}

$sql = "SELECT idCad, Nome, Email, DataNasc, Genero, Biografia FROM Cadastro ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários Cadastrados</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="results-container">
        <h1>Usuários Cadastrados</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Data de Nascimento</th>
                        <th>Gênero</th>
                        <th>Biografia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['idCad']); ?></td>
                            <td><?php echo htmlspecialchars($row['Nome']); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td>
                            <td><?php echo htmlspecialchars($row['DataNasc']); ?></td>
                            <td><?php echo htmlspecialchars($row['Genero']); ?></td>
                            <td><?php echo htmlspecialchars($row['Biografia']); ?>
                        <!-- Formulário para exclusão -->
                        <div class="delete-button-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return confirm('Você tem certeza que deseja excluir este registro?');">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['idCad']); ?>">
            <button type="submit">Excluir</button>
        </form>
    </div>
            </td>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Não há usuários cadastrados.</p>
        <?php endif; ?>

        <p><a href="index.php">Voltar ao formulário</a></p>
    </div>

    <?php
    $conn->close();
    ?>
</body>
</html>
