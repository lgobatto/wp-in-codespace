<?php
/**
 * WordPress Stack Test Page
 * 
 * This page tests the nginx + PHP-FPM + MariaDB stack
 */

// Database configuration
$db_host = $_ENV['DB_HOST'] ?? 'mariadb';
$db_name = $_ENV['DB_NAME'] ?? 'wordpress';
$db_user = $_ENV['DB_USER'] ?? 'wp_user';
$db_password = $_ENV['DB_PASSWORD'] ?? 'wp_password';

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress Stack - Codespace</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #0073aa;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .status {
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        .code {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🚀 WordPress Stack - Codespace</h1>
            <p>Nginx + PHP-FPM + MariaDB</p>
        </div>

        <h2>📊 Informações do Sistema</h2>
        <table>
            <tr>
                <th>Componente</th>
                <th>Versão/Status</th>
            </tr>
            <tr>
                <td>PHP</td>
                <td><?php echo phpversion(); ?></td>
            </tr>
            <tr>
                <td>Servidor Web</td>
                <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Nginx (via PHP-FPM)'; ?></td>
            </tr>
            <tr>
                <td>Sistema Operacional</td>
                <td><?php echo php_uname(); ?></td>
            </tr>
        </table>

        <h2>🔌 Teste de Conexão com Banco de Dados</h2>
        <?php
        try {
            $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            echo '<div class="status success">';
            echo '<strong>✅ Conexão com MariaDB estabelecida com sucesso!</strong><br>';
            echo "Host: $db_host<br>";
            echo "Database: $db_name<br>";
            echo "Usuário: $db_user";
            echo '</div>';
            
            // Get database version
            $stmt = $pdo->query('SELECT VERSION()');
            $version = $stmt->fetchColumn();
            echo "<div class='info'><strong>Versão do MariaDB:</strong> $version</div>";
            
            // Test sample data
            $stmt = $pdo->query('SELECT COUNT(*) FROM sample_table');
            $count = $stmt->fetchColumn();
            echo "<div class='info'><strong>Registros na tabela sample_table:</strong> $count</div>";
            
            if ($count > 0) {
                echo '<h3>📋 Dados de Exemplo</h3>';
                echo '<table>';
                echo '<tr><th>ID</th><th>Nome</th><th>Email</th><th>Criado em</th></tr>';
                
                $stmt = $pdo->query('SELECT * FROM sample_table ORDER BY id');
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            
        } catch (PDOException $e) {
            echo '<div class="status error">';
            echo '<strong>❌ Erro na conexão com o banco de dados:</strong><br>';
            echo htmlspecialchars($e->getMessage());
            echo '</div>';
        }
        ?>

        <h2>🔧 Extensões PHP Instaladas</h2>
        <div class="code">
            <?php
            $extensions = get_loaded_extensions();
            sort($extensions);
            echo implode(', ', $extensions);
            ?>
        </div>

        <h2>⚙️ Informações do PHP</h2>
        <div class="info">
            <strong>Informações detalhadas do PHP:</strong>
            <a href="phpinfo.php" target="_blank">Ver phpinfo()</a>
        </div>

        <h2>🐳 Variáveis de Ambiente</h2>
        <table>
            <?php
            $env_vars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'PATH', 'PHP_VERSION'];
            foreach ($env_vars as $var) {
                $value = $_ENV[$var] ?? 'Não definida';
                if ($var === 'DB_PASSWORD') continue; // Skip password for security
                echo "<tr><td>$var</td><td>" . htmlspecialchars($value) . "</td></tr>";
            }
            ?>
        </table>

        <div class="header" style="margin-top: 40px; border-top: 2px solid #0073aa; border-bottom: none; padding-top: 20px;">
            <p>🎉 Stack configurado e funcionando no GitHub Codespaces!</p>
        </div>
    </div>
</body>
</html>