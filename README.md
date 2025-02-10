# carteirinha-remake

Remake do projeto carteirinha IFBA

## Tasks to do:

### Prioridade atual:
- Remover códigos AJAX do topo dos arquivos php e de qualquer outro arquivo. Funções ajax devem ser movidas para o arquivo ajax.js;
- Criação de tabela de para os feedbacks recebidos pelos usuários;
- Opção de marcar notificações como lidas sem precisar abri-las;
- O usuário/administrador deve ser alertado em todos os casos de resposta do servidor onde possa ser: erro, alerta ou sucesso. Em todos os casos deve ser exibida na tela uma notificação elegante sobre a situação em questão;


### Prioridade média:
- Criar popup de Alerta e Sucesso personalizado para funções (criado, mantido por possibilidade de haver problemas ou necessidade de ajustes);
- Organizar texto principal das notificações;

### Prioridade média porém incapacitado:

- Criar Servidor para testes locais;
- Arrumar problema com a camera dos celulares;
- Confirmação de reserva do almoço pelo e-mail(necessita servidor);

### Bugs:

- Horário limite provavelmente contem bugs;

### Otimizações:

- Criar redirecionador para aproveitar apenas um QR Code tanto para agendar reserva quanto para almoçar;

### Pode esperar:

- Adicionar status: "Recebida, voce tem até $horario para aceitar" para evitar bugs;
- Adicionar icone no lugar de "lida" na notificação;
- Ajustar questões de responsividade;
- Tela de Cadastro de usuários;

Versão do ADM:

- Enviar notificação apenas para um estudante com a matricula;
- Caso seja apenas para um estudante, mostrar tela de confirmação com os dados úteis do mesmo;
- Enviar notificação para todos os estudantes;

### Futuramente:

- Fazer um teste de compatibilidade com usuários de IOS;
- Fazer um teste com o pessoal da sala para verificar casos de uso ou possiveis bugs ou necessidades;
- Adicionar feedback ao banco de dados;
- O usuário deve ter acesso a uma página onde pode acessar os registros de suas reservas com status dos últimos 30 dias;

### Feito recentemente(periodo de 5 dias):

- Criar popup de Alerta e Sucesso personalizado para funções;
- Mover todas as popups do footer para a navbar;
- Esconder formulário de contato no Sobre;
- Notificações em popups antigas precisam ser reajustadas (ajustado);
