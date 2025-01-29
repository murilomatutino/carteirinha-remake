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

export async function getUserId() {
    try {
        const response = await fetch('idUser.php');
        if (!response.ok) {
            throw new Error(`Erro ao buscar o ID, status: ${response.status}`);
        }
        const userId = await response.text();
        return userId;
    } catch (error) {
        console.error('Erro ao pegar ID:', error);
        return null;  
    }
}

export async function cancelarReserva(data) {
    try {
        const response = await fetch('../Controller/CardapioController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(data).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro ao cancelar reserva, status: ${response.status}`);
        }

        const result = await response.json();
        
        if (result.status === 'success') {
            console.log('Reserva cancelada:', result.message);
        } else {
            console.error('Erro ao cancelar reserva:', result.message);
        }

        return result;
    } catch (error) {
        console.error('Erro:', error);
        return null;  
    }
}