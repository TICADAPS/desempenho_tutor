
function tabelaAcp(a,c){ 
    let tbcp = document.querySelector('#tbcp');
    let html = '';
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getcompprof/index.php?a='+a+'&c='+c)
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
                html += '<tr>';
                html += '<td colspan="82" class="bg-warning text-dark"><i class="fas fa-chevron-circle-right"></i>&nbsp; Não existem tutores para o '+c+'º ciclo.</td>';
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
                    // verifica se já enviou ou não o formulário
                    let flagenvio = `${user.flagenvio}`;
                    if(flagenvio === '1'){
                        html += `<td><a class="btn btn-light" href="detalhes/index.php?id=${user.id}" target="_blank" title="Mais detalhes..."><i class="fas fa-info-circle"></i></a></td>`;
                    }else{
                        html += `<td></td>`;
                    }
                    html += `<td><button type="button" class="btn btn-outline-primary"  data-bs-toggle="modal" data-bs-target="#modalEmail${user.id}"><i class="fas fa-mail-bulk"></i>&nbsp; Enviar E-Mail</button></td>`;
                    html += `<td>${user.nome}</td>`;
                    html += '<td>'+cpf+'</td>';
                    html += `<td>${user.tipologia}</td>`;
                    html += '<td>'+ivs+'</td>';
                    html += `<td>${user.municipio}</td>`;
                    html += `<td>${user.uf}</td>`;
                    html += `<td>${user.ibge}</td>`;
                    html += `<td>${user.cnes}</td>`;
                    html += `<td>${user.ine}</td>`;
                    //modal de envio de e-mail padrão para atrasos
                    html += `<div class="modal fade" id="modalEmail${user.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">`;
                    html += '    <div class="modal-dialog">';
                    html += '     <div class="modal-content">';
                    html += '       <div class="modal-header">';
                    html += '         <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>';
                    html += '         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                    html += '       </div>';
                    html += '       <div class="modal-body">';
                    html += '         ...';
                    html += '       </div>';
                    html += '       <div class="modal-footer">';
                    html += '         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
                    html += '         <button type="button" class="btn btn-primary">Understood</button>';
                    html += '       </div>';
                    html += '     </div>';
                    html += '   </div>';
                    html += '</div>';
                    html += '</tr>';
//                    console.log(html);
                });
            }
            tbcp.innerHTML = html;
        } else {
            html += '<tr><td colspan="9">Não é possível carregar os dados do tutor</td></tr>';
        }
        //coloca os dados na tabela
        
    })
    .catch(error => {
        html += `<tr><td colspan="9">Erro: ${error}</td></tr>`;
    });
}
function formataCPF(cpf){
  //retira os caracteres indesejados...
  cpf = cpf.replace(/[^\d]/g, "");
  
  //realizar a formatação...
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
}