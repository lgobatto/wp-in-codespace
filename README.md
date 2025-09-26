# WordPress Stack in Codespace

🚀 Um ambiente de desenvolvimento completo configurado para funcionar no GitHub Codespaces com:

- **Nginx** - Servidor web de alta performance
- **PHP-FPM** - PHP FastCGI Process Manager
- **MariaDB** - Sistema de gerenciamento de banco de dados

## 🏗️ Arquitetura

Este projeto utiliza Docker Compose para orquestrar três serviços principais:

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│    Nginx    │───▶│  PHP-FPM    │───▶│   MariaDB   │
│   :80       │    │   :9000     │    │   :3306     │
└─────────────┘    └─────────────┘    └─────────────┘
```

## 🚀 Como Usar

### No GitHub Codespaces

1. Clique no botão "Code" no repositório
2. Selecione "Create codespace on main"
3. Aguarde a configuração automática do ambiente
4. Acesse a aplicação através da porta 80 que será automaticamente disponibilizada

### Localmente com Docker

1. Clone o repositório:
   ```bash
   git clone https://github.com/lgobatto/wp-in-codespace.git
   cd wp-in-codespace
   ```

2. Configure as variáveis de ambiente:
   ```bash
   cp .env.example .env
   ```

3. Inicie os serviços:
   ```bash
   docker compose up -d
   ```

4. Acesse a aplicação em http://localhost

## 📁 Estrutura do Projeto

```
.
├── .devcontainer/
│   └── devcontainer.json      # Configuração do Codespace
├── config/
│   ├── nginx/
│   │   └── default.conf       # Configuração do Nginx
│   ├── php/
│   │   ├── Dockerfile         # Imagem personalizada do PHP
│   │   └── php.ini           # Configuração do PHP
│   └── mysql/
│       └── init.sql          # Script de inicialização do banco
├── www/
│   ├── index.php             # Página principal de teste
│   └── phpinfo.php           # Informações do PHP
├── docker-compose.yml        # Orquestração dos serviços
├── .env.example             # Exemplo de variáveis de ambiente
└── README.md                # Este arquivo
```

## 🔧 Configuração

### Serviços

- **Nginx**: Porta 80, configurado para proxy reverso com PHP-FPM
- **PHP-FPM**: PHP 8.2 com extensões essenciais (PDO, MySQL, GD, etc.)
- **MariaDB**: Versão 10.11 com banco `wordpress` pré-configurado

### Variáveis de Ambiente

| Variável | Padrão | Descrição |
|----------|--------|-----------|
| `DB_HOST` | mariadb | Host do banco de dados |
| `DB_NAME` | wordpress | Nome do banco de dados |
| `DB_USER` | wp_user | Usuário do banco |
| `DB_PASSWORD` | wp_password | Senha do banco |

### Extensões PHP Incluídas

- PDO MySQL
- GD (manipulação de imagens)
- Mbstring (strings multibyte)
- ZIP (compressão)
- XML (processamento XML)
- Xdebug (debugging)

## 🛠️ Comandos Úteis

### Docker Compose

```bash
# Iniciar serviços
docker compose up -d

# Ver logs
docker compose logs -f

# Parar serviços
docker compose down

# Rebuild dos containers
docker compose up -d --build
```

### Acesso aos Containers

```bash
# PHP container
docker compose exec php bash

# MariaDB container
docker compose exec mariadb mysql -u wp_user -p wordpress

# Nginx container
docker compose exec nginx sh
```

## 📊 Monitoramento

- **Página Principal**: http://localhost (status do sistema)
- **PHP Info**: http://localhost/phpinfo.php
- **MariaDB**: localhost:3306

## 🐛 Debugging

O Xdebug está configurado e ativo no container PHP:

- **Porta**: 9003
- **Host**: host.docker.internal
- **Logs**: /tmp/xdebug.log

## 🔒 Segurança

- Headers de segurança configurados no Nginx
- PHP configurado para desenvolvimento (não use em produção)
- Acesso a arquivos sensíveis bloqueado
- phpinfo() só funciona em ambiente de desenvolvimento

## 📝 Logs

Os logs estão disponíveis através do Docker Compose:

```bash
# Logs de todos os serviços
docker compose logs

# Logs específicos
docker compose logs nginx
docker compose logs php
docker compose logs mariadb
```

## 🤝 Contribuição

1. Fork o projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

## 🚨 Avisos Importantes

- Este ambiente é otimizado para **desenvolvimento**
- **Não use em produção** sem as devidas configurações de segurança
- As senhas padrão devem ser alteradas em ambientes reais
- O Xdebug pode impactar a performance