// ajax agendados

export async function transferirReserva(dados) {
    fetch('../Controller/CardapioController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(dados).toString()
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === "sucesso") {
            return {
                type: 'sucess',
                text: `Reserva transferida com sucesso para o usuário de matrícula ${result.matriculaDestino}!`
            }
            // showNotification(
            //     `Reserva transferida com sucesso para o usuário de matrícula ${result.matriculaDestino}!`,
            //     "success"
            // );
        } else {
            return {
                type: 'error',
                text: `Erro ao transferir a reserva: ${result.mensagem || "Tente novamente mais tarde."}`
            }
            // showNotification(
            //     `Erro ao transferir a reserva: ${result.mensagem || "Tente novamente mais tarde."}`,
            //     "error"
            // );
        }
        // closeAgendadosPopup();
    })
    .catch(error => {
        console.error('Erro:', error);
        // showNotification(
        //     "Ocorreu um erro inesperado ao transferir a reserva. Tente novamente mais tarde.",
        //     "error"
        // );
    });
}

export async function cancelarReserva(motivo) {
    return fetch('../Controller/CardapioController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded' 
        },
        body: new URLSearchParams(motivo).toString() 
    })
    .then(response => response.text())
    .catch(error => {
        console.error('Erro:', error);
    });
}