    /* global fetch */
function envDemonstrativo(ano,ciclo){
    var dados = new FormData();
    dados.append('ano', ano);
    dados.append('ciclo', ciclo);
//    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('envDemonstrativo.php', {
        method: 'POST',
        body: dados
    })
    .then(response => {
        //response.text()
        if (response.headers.get("Content-Type") === "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            return response.blob();  // Recebe o arquivo como blob
        } else {
            return response.text();  // Recebe uma resposta JSON
        }
    }) // Processa a resposta em formato JSON
    .then(data => {
        if (data instanceof Blob) {
            const url = window.URL.createObjectURL(data);
            const a = document.createElement("a");
            a.href = url;
            a.download = "arquivo.xlsx";
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        } else {
            // Lógica para tratar a resposta JSON
            console.log("Resposta: ", data.toString());
        }
    })
    .catch(erro => {
        console.error('Erro: ', erro);
    });
}