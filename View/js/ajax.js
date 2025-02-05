// ajax agendados
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
        const response = await fetch('../Controller/refactor.php', {
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

export async function transferirReserva(dados) {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(dados).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro ao transferir reserva, status: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            console.log(result.message);
        } else {
            console.error('Erro ao iniciar solicitação de transferência de reserva:', result.message);
        }

        return result;

    } catch (error) {
        console.error('Erro:', error.message || error);
        return null;
    }
}

export async function acceptTransferencia(dados) {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(dados).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro ao aceitar transferência de reserva, status: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            console.log(result.message);
        } else {
            console.error('Erro ao aceitar transferência de reserva:', result.message);
        }

        return result;

    } catch (error) {
        console.error('Erro:', error.message || error);
        return null;
    }
}

export async function getNotification(dados) {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(dados).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro ao encontrar notificações: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            return result.array[0];
        } else {
            console.error('Erro ao encontrar notificações 2:', result.message);
        }

        return result;

    } catch (error) {
        console.error('Erro:', error.message || error);
        return null;
    }
}

export async function readNotification(dados) {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(dados).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro 1: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            return true;
        } 
    } catch (error) {
        console.error('Erro 2:', error.message || error);
        return null;
    }
}