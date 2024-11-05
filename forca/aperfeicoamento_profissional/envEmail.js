    /* global fetch */
function envEmailAll(ano,ciclo){
    var dados = new FormData();
    dados.append('ano', ano);
    dados.append('ciclo', ciclo);
//    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('envEmailAll.php', {
        method: 'POST',
        body: dados
    })
    .then(response => response.text()) // Processa a resposta em formato JSON
    .then(data => {
        // Exibe o resultado no HTML
        let numeros = data.toString().split('');
        numeros.forEach(function(numero) {
            if(numero !== 0){
                campoEmail(numero);
            }
        });
    })
    .catch(erro => {
        console.error('Erro:', erro);
    });
}