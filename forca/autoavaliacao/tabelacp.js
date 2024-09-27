
window.onload = () => {
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getcompprof/')
    .then(response => {
        if (response.status === 200) {
            return response.json();
        } else {
            throw Error('Dados não encontrados');
        }
    })
    .then(dados => {
//        console.log(dados);
        let tbcp = tbcp = document.querySelector('#tbcp');
        tbcp = '';
        let html = '';
        if (dados.status === 'success') {
            if(dados.affected_rows === 0){
                html += '<tr>';
                html += '<td colspan="82"><i class="fas fa-chevron-circle-right"></i>&nbsp; Não existem usuários para apresentar.</td>';
                html += '</tr>';
            }else{
                dados.results.forEach(user => {
                    let cpf = `${user.cpf}`;
                    cpf = formataCPF(cpf);
                    let ivs = '';
                    if(`${user.ivs}` !== null){
                        ivs = `${user.ivs}`;
                    }
                    html += '<tr>';
                    html += `<td>${user.nome}</td>`;
                    html += '<td>'+cpf+'</td>';
                    html += `<td>${user.municipio}-${user.uf}</td>`;
                    html += '<td>'+ivs+'</td>';
                    html += `<td>${user.ibge}</td>`;
                    html += `<td>${user.cnes}</td>`;
                    html += `<td>${user.ine}</td>`;
                    // PAREI AQUI...... 27/09/2024
                    html += `<td><a href="detalhes/index.php?id=${user.id}" target="_blank" title="Mais detalhes...">Detalhes</a></td>`;
                    html += '</tr>';
                });
                //coloca os dados na tabela
                let e = document.querySelector('#tbcp').innerHTML = html;
                document.querySelector('.error.opacity-75').textContent = '';
                document.querySelector('#table_users').classList.remove('d-none');
            }
        } else {
            html += '<tr>';
            html += '<td colspan="82" class="bg-warning"><i class="fas fa-chevron-circle-right"></i>&nbsp; Erro: Não foi possível carregar os dados dos usuários.</td>';
            html += '</tr>';
//            throw Error('Não foi possível carregar os dados dos usuários.');
        }
    })
    .catch(error => {
        document.querySelector('.error').classList.remove('d-none');
    });
};
function formataCPF(cpf){
  //retira os caracteres indesejados...
  cpf = cpf.replace(/[^\d]/g, "");
  
  //realizar a formatação...
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
}