    /* global fetch */
function envEmailForm(a){
    console.log("passou aqui: "+ a);
    document.getElementById('envEmailForm'+a).addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o envio normal do formulário
        let id= document.querySelector('#idemail').value;
        let nome = document.querySelector('#nomeemail').value;
        let cpf = document.querySelector('#cpfemail').value;   
        console.log(id,nome,cpf);
        const dados = {
            id: id,
            nome: nome,
            cpf: cpf
        };
        // Envia os dados via AJAX usando fetch
        fetch('envEmail.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        })
        .then(response => response.json()) // Processa a resposta em formato JSON
        .then(data => {
           // Exibe o resultado no HTML
            document.getElementById('resultado').innerHTML = '' + data.message;
            $('#resultado').fadeIn(400);
        })
        .catch(erro => {
            console.error('Erro:', erro);
        });
    }); 
}