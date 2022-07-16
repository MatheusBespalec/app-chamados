function callStatus(statusNumber) {
    const status = {
        1: 'Iniciado',
        2: 'Em Resolução',
        3: 'Temporariamente Parado',
        4: 'Finalizado',
    };
    return status[statusNumber];
}

export { callStatus }
