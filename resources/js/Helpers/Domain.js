function callStatus(statusNumber) {
    const status = {
        1: 'Em Aberto',
        2: 'Finalizado',
    };
    return status[statusNumber];
}

export { callStatus }
