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

export async function getCardapioId() {
    try {
        const response = await fetch('idCardapio.php');
        if (!response.ok) {
            throw new Error(`Erro ao buscar o ID, status: ${response.status}`);
        }
        const idCardapio = await response.text();
        return idCardapio;
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

export async function enviarNotificacao(dados) { // notificação de transsferencia

    const response = await fetch('../Controller/refactor.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams(dados).toString()
    });

    if (!response.ok) {
        throw new Error(`Erro ao enviar notificação, status: ${response.status}`);
    }

    const result = await response.json();

    if (result.status === 'success') {
        console.log(result.message);
    } else {
        console.log('Erro ao iniciar envio de notificação:', result.message);
        throw new Error(`Erro ao enviar notificação (refactor)`);
    }

    return result;
}

export async function acceptTransferencia(dados) {
    //try {
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
            //console.error('Erro ao aceitar transferência de reserva:', result.message);
            throw new Error(`Erro ao aceitar transferência de reserva (refactor)`);
        }

        return result;

    /*} catch (error) {
        console.error('Erro:', error.message || error);
        return null;
    }*/
}

export async function cancelTransferencia(dados) {
    //try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(dados).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro ao cancelar transferência de reserva, status: `);
        }

        const result = await response.json();

        if (result.status === 'success') {
            console.log('sucesso');
        } else {
            //console.error('Erro ao aceitar transferência de reserva:', result.message);
            throw new Error(`Erro ao cancelar transferência de reserva (refactor)`);
        }

        return result;

    /*} catch (error) {
        console.error('Erro:', error.message || error);
        return null;
    }*/
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

export async function enviarFormulario(data) {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data).toString()
        })

        if (!response.ok) {
            throw new Error(`Erro 1: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            return true;
        } else {
            return false;
        }
    } catch (error) {
        console.error('Erro 2:', error.message || error);
        return null;
    }
}

export async function enviarFeedback(data) {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams(data).toString()
        })

        if (!response.ok) {
            throw new Error(`Erro 1: ${response.status}`);
        }

        const result = await response.json();

        if (result.status === 'success') {
            return true;
        } else {
            return false;
        }
    } catch (error) {
        console.error('Erro 2:', error.message || error);
        return null;
    }
}

export async function excluirCardapio() {
    try {
        const response = await fetch('../Controller/refactor.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ operacao: 'excluir' }).toString()
        });

        if (!response.ok) {
            throw new Error(`Erro 1: ${response.status}`);
        }

        const result = await response.json();

        return result.status === 'success';
    } catch (error) {
        console.error('Erro 2:', error.message || error);
        return null;
    }
}