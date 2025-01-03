    /* global fetch */
function envEmailForm(a){
//    event.preventDefault(); // Evita o envio normal do formulário
    let id = document.querySelector('#idemail' + a).value;
    let nome = document.querySelector('#nomeemail' + a).value;
    let cpf = document.querySelector('#cpfemail' + a).value;
    //console.log(id, nome, cpf);
    var dados = new FormData();
    dados.append('id', id);
    dados.append('nome', nome);
    dados.append('cpf', cpf);
    //console.log(dados);
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
function campoEmail(a){ 
    console.log(a);
    let divemail = document.querySelector('.email'+a);
    divemail.innerHTML = '';
    let html = '';
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getaperfprofEmail/index.php?id='+a)
    .then(response => {
//        console.log(response.json());
        if (response.status === 200) {
            return response.json();
        } else {
            throw Error('Dados não encontrados');
        }
        
    })
    .then(dados => {
//        console.log(dados);
        if (dados.status === 'success') {
            
            if(dados.affected_rows === 0){
                html += '<i class="fas fa-chevron-circle-right"></i>&nbsp; Dado inexistente.';
            }else{
                dados.results.forEach(dado => {
                    // verifica se já enviou ou não o formulário
                    let flagenvemail = `${dado.flagenvemail}`;
                    if(flagenvemail=== '1'){
                        let dthrenvemail = `${dado.dthrenvemail}`;
                        let dtenv = dthrenvemail.substring(0, 10);
                        let hrenv = dthrenvemail.substring(10, 16);
                        html += `<button type="button" class="btn btn-outline-warning shadow-sm border-warning text-dark" data-toggle="modal" data-target="#modalEmail${a}"><b><i class="fas fa-mail-bulk"></i>&nbsp; Enviar E-Mail</b></button><br><label class="text-info mt-2">E-Mail enviado:<br>${dtenv} às ${hrenv}</label>`;
                    }
                    console.log(html);
                });
            }
            divemail.innerHTML = html;
        } else {
            html += 'Não é possível carregar os dados do tutor.';
        }
        //coloca os dados na tabela
        
    })
    .catch(error => {
        html += `Erro: ${error}`;
    });
}