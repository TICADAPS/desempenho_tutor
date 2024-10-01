
function tabelaAcp(a,c){ 
    let tbcp = document.querySelector('#tbcp');
    tbcp.innerHTML = '';
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
                dados.results.forEach(dado => {
                    let cpf = `${dado.cpf}`;
                    cpf = formataCPF(cpf);
                    let ivs = '';
                    if(`${dado.ivs}` !== null){
                        ivs = `${dado.ivs}`;
                    }
                    html += '<tr>';
                    // verifica se já enviou ou não o formulário
                    let flagenvio = `${dado.flagenvio}`;
                    if(flagenvio === '1'){
                        html += `<td class="text-center"><a class="btn btn-light" href="detalhes/index.php?id=${dado.id}" target="_blank" title="Mais detalhes..."><i class="fas fa-info-circle"></i></a></td>`;
                    }else{
                        let flagenvemail = `${dado.flagenvemail}`;
                        if(flagenvemail !== '1'){
                            html += `<td class="text-center"><button type="button" onclick="funcBtEB();" class="btn btn-outline-warning text-dark" data-toggle="modal" data-target="#modalEmail${dado.id}"><i class="fas fa-mail-bulk"></i>&nbsp; Enviar E-Mail</button></td>`;
                        }else{
                            let dthrenvemail = `${dado.dthrenvemail}`;
                            let dtenv = dthrenvemail.substring(0,9);
                            let hrenv = dthrenvemail.substring(10,14);
                            html += `<td class="text-center">E-Mail enviado - ${dtenv} às ${hrenv}.</td>`;
                        }
                    }
                    html += `<td>${dado.nome}</td>`;
                    html += '<td>'+cpf+'</td>';
                    html += `<td>${dado.tipologia}</td>`;
                    html += '<td>'+ivs+'</td>';
                    html += `<td>${dado.municipio}</td>`;
                    html += `<td>${dado.uf}</td>`;
                    html += `<td>${dado.ibge}</td>`;
                    html += `<td>${dado.cnes}</td>`;
                    html += `<td>${dado.ine}</td>`;
                    //modal de envio de e-mail padrão para atrasos
                    html += `<div class="modal fade modalEmail" id="modalEmail${dado.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">`;
                    html += '    <div class="modal-dialog">';
                    html += '     <div class="modal-content">';
                    html += '       <div class="modal-header bg-warning">';
                    html += '         <h5 class="modal-title text-dark" id="exampleModalLabel"><i class="fas fa-mail-bulk"></i>&nbsp; Alerta de tempo limite</h5>';
                    html += '         <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                    html += '           <span aria-hidden="true">&times;</span>';
                    html += '         </button>';
                    html += '       </div>';
                    html += '       <div class="modal-body">';
                    html += '         Deseja alertar o tutor para a realização da autoavaliação?';
                    html += '         <div class="loadingEmail mt-3">';
                    html += '          <p class="text-center"><img src="../../img/carregando.gif" width="40" height="40" /></p>';
                    html += '         </div>';
                    html += '       </div>';
                    html += '       <div class="modal-footer">';
                    html += `       <form id="envEmailForm${dado.id}">`;
                    html += `         <input type="hidden" name="idemail" value="${dado.id}">`;
                    html += `         <input type="hidden" name="nomeemail" value="${dado.nome}">`;
                    html += `         <input type="hidden" name="cpfemail" value="${cpf}">`;
                    html += '         <button type="button" class="btn btn-secondary" data-dismiss="modal">FECHAR</button>';
                    html += `         <button type="submit" onclick="funcBtEnvEB(${dado.id});" class="btn btn-primary">ENVIAR</button>`;
                    html += '       </form>';
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