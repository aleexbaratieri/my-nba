## :rocket: Instalação

- Pré-requisitos:
    - :whale: [Docker](https://docs.docker.com/engine/install/)
    - :whale: [Docker Compose](https://docs.docker.com/compose/install/)
    - :sparkles: [Git](https://git-scm.com/install/)
  
```bash
git clone git@github.com:aleexbaratieri/my-nba.git

cd my-nba

cp .env.example .env
```
## :cd: Configuração

:floppy_disk: Edite as variáveis de ambiente.

```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

SESSION_DRIVER=redis
CACHE_STORE=redis

REDIS_CLIENT=predis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=mailhog
MAIL_PORT=1026
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

FORWARD_API_PORT=8080
FORWARD_DATABASE_PORT=3306
FORWARD_REDIS_PORT=6379
IP_DOCKER=172.17.0.1

FORWARD_MAILHOG_SMTP_PORT=1025
FORWARD_MAILHOG_WEB_PORT=8025

BALLDONTLIE_BASE_URL=https://api.balldontlie.io/v1
BALLDONTLIE_API_KEY=your_api_key
```

#### Iniciar Containers

```bash
docker compose up -d

docker compose exec api composer install
docker compose exec api artisan key:generate
docker compose exec api artisan migrate --seed
```

### :computer: [Documentação da Api](http://localhost:8080/docs/api#/)

#### :basketball: Importar dados da api do BallDontLie

Processo pode demorar um pouco pois a api limita a 5 reqs por minuto na versão gratis.

##### :star: Importar Times

```bash
docker compose exec api php artisan balldontlie:import --teams
```

##### :bookmark: Importar Jogos

Parametro `--season` default é temporada passada

```bash
docker compose exec api php artisan balldontlie:import --games --season=2025
```

##### :boy: Importar Jogadores

Esse é o processo mais demorado devido a quantidade de items que precisam ser importados.

```bash
docker compose exec api php artisan balldontlie:import --players
```

Obs: Pode ser feito todos de uma vez, porém a uma chance dos relacionamentos ainda não existirem e alguns itens não serem importados. Caso vc faça a importação mais de uma vez, os itens serão atualizados.

Comando para rodar tudos os processos juntos:

```bash
docker compose exec api php artisan balldontlie:import --season=2025 --teams --games --players
```