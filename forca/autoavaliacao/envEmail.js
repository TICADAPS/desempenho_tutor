    /* global fetch */
function envEmailForm(a){
//    event.preventDefault(); // Evita o envio normal do formulário
    let id = document.querySelector('#idemail' + a).value;
    let nome = document.querySelector('#nomeemail' + a).value;
    let cpf = document.querySelector('#cpfemail' + a).value;
    console.log(id, nome, cpf);
    var dados = new FormData();
    dados.append('id', id);
    dados.append('nome', nome);
    dados.append('cpf', cpf);
    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('envEmail.php', {
        method: 'POST',
        body: dados
    })
    .then(response => response.text()) // Processa a resposta em formato JSON
    .then(data => {
        // Exibe o resultado no HTML
        if(data !== ''){
            $('#msg').html(data).fadeIn();
        }
        campoEmail(a);
    })
    .catch(erro => {
        $('#msg').html(erro).fadeIn();
        console.error('Erro:', erro);
    });
}
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