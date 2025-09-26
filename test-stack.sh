#!/bin/bash

# WordPress Stack Test Script
echo "🧪 Testando WordPress Stack..."

# Check if Docker is available
if ! command -v docker &> /dev/null; then
    echo "❌ Docker não encontrado!"
    exit 1
fi

# Check if docker-compose.yml exists
if [ ! -f "docker-compose.yml" ]; then
    echo "❌ docker-compose.yml não encontrado!"
    exit 1
fi

echo "✅ Docker encontrado"

# Start services
echo "🚀 Iniciando serviços..."
docker compose up -d

# Wait for services to be ready
echo "⏳ Aguardando serviços ficarem prontos..."
sleep 30

# Check if services are running
echo "🔍 Verificando status dos serviços..."

# Check Nginx
if docker compose ps nginx | grep -q "running"; then
    echo "✅ Nginx: Rodando"
else
    echo "❌ Nginx: Não está rodando"
fi

# Check PHP
if docker compose ps php | grep -q "running"; then
    echo "✅ PHP-FPM: Rodando"
else
    echo "❌ PHP-FPM: Não está rodando"
fi

# Check MariaDB
if docker compose ps mariadb | grep -q "running"; then
    echo "✅ MariaDB: Rodando"
else
    echo "❌ MariaDB: Não está rodando"
fi

# Test HTTP connection
echo "🌐 Testando conexão HTTP..."
if curl -f -s http://localhost > /dev/null; then
    echo "✅ Servidor web respondendo"
else
    echo "❌ Servidor web não está respondendo"
fi

# Test database connection
echo "🗄️ Testando conexão com banco de dados..."
if docker compose exec -T mariadb mysql -u wp_user -pwp_password -e "SELECT 1;" wordpress > /dev/null 2>&1; then
    echo "✅ Conexão com banco de dados funcionando"
else
    echo "❌ Erro na conexão com banco de dados"
fi

echo ""
echo "🎉 Teste concluído!"
echo "📱 Acesse http://localhost para ver a aplicação"
echo "🛑 Para parar os serviços: docker compose down"