
# To Do List com Laravel

Segunda aplicação em PHP.

Projeto de lista de tarefas em laravel 10

Sendo desenvolvido como forma de ganhar mais familiaridade com PHP e Laravel


## Instalando o projeto na sua máquina:

_Necessário ter o docker instalado para seguir o passo a passa abaixo_

Clonar o repositório para uma pasta local:

```bash
git clone git@github.com:theus-figueiredo/todo-api.git
cd todo-api
```

Iniciar o docker-compose

```bash
docker-compose up -d
```

Gerar a variável de ambiente `APP_KEY`:

```bash
docker-compose exec laravel.test php artisan key:generate
```

Executar as migrations:

```bash
docker-compose exec laravel.test php artisan migrate
```


## Variáveis de ambiente

Para executar o projeto é preciso adicionar algumas variais de ambiente:

`APP_PORT` -> irá definir a porta local em que a aplicação será executada

`FORWARD_DB_PORT` -> irá definir a porta local para qual será mapeado o container com o mysql

`JWT_SECRET` -> para fazer uso das funções do JWT


o username e senha do mysql no container em questão são respectivamente `sail` e `password`

No projeto há um arquivo .env.example com um exemplo do arquivo .env, use-o como base.


## Funções

- Armazenar tarefas à serem feitas
- Marcar tarefas como concluídas
- Salvar datas de entrega de tarefas e datas de conclusão das mesmas



## Endpoints de User

#### Resgatar todos os usuários:

```http
  GET /api/users
```


#### Resgatar um único usuário:

```http
  GET /api/users/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do usuário |


#### Atualizar um usuário

```http
  PUT /api/users/${id}
```

Header:

| Header | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`      | `Bearer token` | **Obrigatório**. Token JWT    |

Query:

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do usuário    |

Body:

| Body      | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`   | `string` | Email do usuário   |
| `password`   | `string` | Senha do usuário   |
| `name`   | `string` | Nome do usuário   |

OBS: Somente o próprio usuário pode atualizar o seu perfil.

#### Criar um novo usuário:

```bash
    POST /api/users
```

| Body      | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `email`   | `string` | *Obrigatório*. Email do usuário   |
| `password`   | `string` | *Obrigatório*. Senha do usuário   |
| `name`   | `string` | *Obrigatório*. Nome do usuário   |


#### Deletar um usuário:



```bash
    DELETE /api/users/${id}
```


| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Obrigatório**. Id do usuário |

Header:

| Header | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `Authorization`      | `Bearer token` | **Obrigatório**. Token JWT    |

OBS: Somente o próprio usuário pode deletar o seu perfil.

