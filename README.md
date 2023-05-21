TestCBC

API de Clubes - README Esta API fornece endpoints para manipulação de clubes e recursos relacionados. Você pode usar esses endpoints para listar clubes, cadastrar um novo clube e consumir recursos de um clube específico. A API foi desenvolvida em PHP e utiliza um banco de dados MySQL para armazenar os dados dos clubes.

Requisitos Antes de iniciar a utilização da API, certifique-se de ter os seguintes requisitos instalados:

PHP (versão 5.6 ou superior) MySQL (ou outro banco de dados compatível) Configuração do Banco de Dados Antes de executar a API, você precisará configurar as informações de conexão com o banco de dados. Abra o arquivo PHP index.php e localize as seguintes linhas de código:

$db_host = "localhost"; 
$db_name = "nomedobanco"; 
$db_user = "usuario"; 
$db_password = "senha";

Executando a API Após configurar corretamente as informações do banco de dados, você pode executar a API seguindo estas etapas:

Coloque os arquivos da API em um servidor PHP compatível.

Certifique-se de que o servidor esteja configurado corretamente para executar o PHP.

Inicie o servidor e verifique se a API está acessível no localhost, usando a porta correta, você pode usar o seguinte comando como exemplo: php -S localhost:8000, assim ele será nossa URL e nossa porta, onde a mesma será usada em nossos testes abaixos.

Endpoints A API possui os seguintes endpoints disponíveis:

Listar todos os clubes Método: GET Endpoint: /clubes ( Este endpoint retorna uma lista de todos os clubes cadastrados ).

Cadastrar um novo clube Método: POST Endpoint: /clube ( Este endpoint permite cadastrar um novo clube no banco de dados. Certifique-se de fornecer os dados corretos do clube no corpo da solicitação ).

Consumir recurso de um clube Método: POST Endpoint: /clubes/{id}/consumir-recurso Substitua {id} pelo ID do clube que deseja consumir o recurso. ( Este endpoint permite consumir um recurso específico de um clube. Forneça os parâmetros necessários no corpo da solicitação ).

Exemplo de Uso Aqui está um exemplo de como você pode usar a API usando a ferramenta cURL:

Listar todos os clubes curl -X GET 
http://localhost:8000/clubes

---------------------------------/------------------------------------/-------------------------------/----------------------------------/-------------------------

Cadastrar um novo clube curl -X POST -H "Content-Type: application/json" -d 
'{
  "nome":"Clube D",
  "saldo_disponivel":"2000.00"
}' 
http://localhost:8000/clube

---------------------------------/------------------------------------/-------------------------------/----------------------------------/-------------------------

Consumir recurso de um clube curl -X POST -H "Content-Type: application/json" -d 
'{
  "clube_id":1, 
  "recurso_id":"1", 
  "valor_consumo":"500.00"
}'
http://localhost:8000/clubes/1/consumir-recurso Certifique-se de substituir http://localhost:8000 pelo URL correto onde a API está sendo executada.
