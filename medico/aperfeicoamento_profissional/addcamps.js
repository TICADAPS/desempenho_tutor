
function addAtvLongDuracao(a){ //add campos em Atividade de Longa Duração
    let num = (a-2);
//    console.log(num);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/get_atv_long_duracao/')
        .then(response => {
//            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let divLongDuracao = document.querySelector("#divLongDuracao1");
                divLongDuracao.innerHTML = "";
//                console.log(divLongDuracao);
                let html = '';
                html += `<div class="col-md-5 pr-2 pl-2 divLongDuracao" id="atvLongDur${num}">`;
                html += '   <div class="col-md-12"><b>Tipo de atividade</b></div>';
                html += '   <div class="col-md-12">';
                html += `       <select class="form-control" required="required" id="slLongaDuracao${num}" name="slLongaDuracao${num}">`;
                html += '           <option value="">[--SELECIONE--]</option>';
                dados.results.forEach(d => {
                    html += `       <option value="${d.idl}">${d.descl}</option>`;
                });
                html += '       </select>';
                html += '   </div>';
                html += '</div>';
                html += `<div class="col-md-2 pr-2 pl-2" required="required" id="cargaLongDur${num}">`;
                html += '   <div class="col-md-12"><b>Carga Horária</b></div>';
                html += `   <div class="col-md-12"><input type="number" min="1" class="form-control" required="required" id="cargahrLongaDuracao${num}" name="cargahrLongaDuracao${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-md-4 pr-2 pl-2" id="anexoLongDur${num}">`;
                html += '   <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp; * Favor juntar os documentos em um único arquivo PDF.</small></div>';
                html += `   <div class="col-md-12"><input type="file" class="form-control" required="required" id="anexoLongaDuracao${num}" name="anexoLongaDuracao${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-md-1 pr-2 pl-2" id="btnLongDur${num}">`;
                html += `  <div class="col-md-12"><button class="btn btn-outline-danger mt-4 form-control" id="btnLongaDuracao${num}" onclick="retiraAtvLongDur(${num})"><i class="fas fa-times-circle"></i></button></div>`;
                html += '</div>';
                divLongDuracao.innerHTML += html;
                
                console.log(divLongDuracao);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addQualiClinica(a){ //add campos em Qualificação Clínica
    let num = a;
//    console.log(num);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/get_quali_clinica/')
        .then(response => {
//            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let divQualiClinica1 = document.querySelector("#divQualiClinica1");
                divQualiClinica1.innerHTML = "";
//                console.log(divQualiClinica1);
                let html = '';
                let x = 1;
                for(x=1; x<=num;x++){
                    html += `<div class="col-md-9 pr-2 pl-2 divQualiClinica mt-3" id="qualiClinica${x}">`;
                    html += '   <div class="col-md-12"><b>Tipo de atividade</b></div>';
                    html += '   <div class="col-md-12">';
                    html += `       <select class="form-control" onchange="slqcall(${x});" required="required" id="slQualiClinica${x}" name="slQualiClinica${x}">`;
                    html += '           <option value="">[--SELECIONE--]</option>';
                    dados.results.forEach(d => {
                        html += `       <option value="${d.idq}">${d.descq}</option>`;
                    });
                    html += '       </select>';
                    html += '   </div>';
                    html += '</div>';
                    html += `<div class="col-md-3 pr-2 pl-2 mt-3" id="divcargaQualiClinica${x}">`;
                    html += `   <div class="col-md-12" id="qcch${x}"><b>Carga Horária</b></div>`;
                    html += `   <div class="col-md-12"><input type="number" min="1" class="form-control" required="required" id="cargahrQualiClinica${x}" name="cargahrQualiClinica${x}" onchange="chqcall(${x});"/></div>`;
                    html += '</div>';
                    html += `<div class="col-md-9 pr-2 pl-2" id="divinfoQualiClinica${x}">`;
                    html += '   <div class="col-md-12"><b>Informação</b></div>';
                    html += `   <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infoqc${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-3 pr-2 pl-2" id="divpontoQualiClinica${x}">`;
                    html += '   <div class="col-md-12"><b>Pontuação Estimada</b></div>';
                    html += `   <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoqc${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-5 pr-2 pl-2" id="divtituloQualiClinica${x}">`;
                    html += '   <div class="col-md-12"><b>Título da atividade</b></div>';
                    html += `   <div class="col-md-12"><input type="text" class="form-control" required="required" id="tituloQualiClinica${x}" name="tituloQualiClinica${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-5 pr-2 pl-2" id="divanexoQualiClinica${x}">`;
                    html += '   <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp; * Favor juntar os documentos em um único arquivo PDF.</small></div>';
                    html += `   <div class="col-md-12"><input type="file" class="form-control" required="required" id="anexoQualiClinica${x}" name="anexoQualiClinica${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-2 pr-2 pl-2" id="divbtnQualiClinica${x}">`;
                    html += `  <div class="col-md-12"><button class="btn btn-outline-danger mt-4 form-control" id="btQualiClinica${x}" onclick="retiraQualiClinica(${x})">REMOVER <i class="fas fa-times-circle"></i></button></div>`;
                    html += '</div>';
                }
                divQualiClinica1.innerHTML += html;
//                console.log(divLongDuracao);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addGesEnsPesExt(a){ //add campos em Qualificação Clínica
    let num = a;
//    console.log(num);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/get_ges_ens_pes_ext/')
        .then(response => {
//            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let divGesEnsPesExt1 = document.querySelector("#divGesEnsPesExt1");
                divGesEnsPesExt1.innerHTML = "";
//                console.log(divQualiClinica1);
                let html = '';
                let x = 1;
                for(x=1; x<=num;x++){
                    html += `<div class="col-md-9 pr-2 pl-2 divGesEnsPesExt mt-3" id="gesEnsPesExt${x}">`;
                    html += '   <div class="col-md-12"><b>Tipo de atividade</b></div>';
                    html += '   <div class="col-md-12">';
                    html += `       <select class="form-control" onchange="slgepeall(${x});" required="required" id="slGesEnsPesExt${x}" name="slGesEnsPesExt${x}">`;
                    html += '           <option value="">[--SELECIONE--]</option>';
                    dados.results.forEach(d => {
                        html += `       <option value="${d.idg}">${d.descg}</option>`;
                    });
                    html += '       </select>';
                    html += '   </div>';
                    html += '</div>';
                    html += `<div class="col-md-3 pr-2 pl-2 mt-3" id="divcargaGesEnsPesExt${x}">`;
                    html += `   <div class="col-md-12" id="gepech${x}"><b>Carga Horária</b></div>`;
                    html += `   <div class="col-md-12"><input type="number" min="1" class="form-control" required="required" id="cargahrGesEnsPesExt${x}" name="cargahrGesEnsPesExt${x}" onchange="chgepeall(${x});"/></div>`;
                    html += '</div>';
                    html += `<div class="col-md-9 pr-2 pl-2" id="divinfoGesEnsPesExt${x}">`;
                    html += '   <div class="col-md-12"><b>Informação</b></div>';
                    html += `   <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infogepe${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-3 pr-2 pl-2" id="divpontoGesEnsPesExt${x}">`;
                    html += '   <div class="col-md-12"><b>Pontuação Estimada</b></div>';
                    html += `   <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontogepe${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-5 pr-2 pl-2" id="divtituloGesEnsPesExt${x}">`;
                    html += '   <div class="col-md-12"><b>Título da atividade</b></div>';
                    html += `   <div class="col-md-12"><input type="text" class="form-control" required="required" id="tituloGesEnsPesExt${x}" name="tituloGesEnsPesExt${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-5 pr-2 pl-2" id="divanexoGesEnsPesExt${x}">`;
                    html += '   <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp; * Favor juntar os documentos em um único arquivo PDF.</small></div>';
                    html += `   <div class="col-md-12"><input type="file" class="form-control" required="required" id="anexoGesEnsPesExt${x}" name="anexoGesEnsPesExt${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-2 pr-2 pl-2" id="divbtnGesEnsPesExt${x}">`;
                    html += `  <div class="col-md-12"><button class="btn btn-outline-danger mt-4 form-control" id="btGesEnsPesExt${x}" onclick="retiraGesEnsPesExt(${x})">REMOVER <i class="fas fa-times-circle"></i></button></div>`;
                    html += '</div>';
                }
                divGesEnsPesExt1.innerHTML += html;
//                console.log(divLongDuracao);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addInovTec(a){ //add campos em Qualificação Clínica
    let num = a;
//    console.log(num);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/get_inov_tec/')
        .then(response => {
//            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let divInovTec1 = document.querySelector("#divInovTec1");
                divInovTec1.innerHTML = "";
//                console.log(divQualiClinica1);
                let html = '';
                let x = 1;
                for(x=1; x<=num;x++){
                    html += `<div class="col-md-9 pr-2 pl-2 divInovTec mt-3" id="inovTec${x}">`;
                    html += '   <div class="col-md-12"><b>Tipo de atividade</b></div>';
                    html += '   <div class="col-md-12">';
                    html += `       <select class="form-control" onchange="slitall(${x});" required="required" id="slInovTec${x}" name="slInovTec${x}">`;
                    html += '           <option value="">[--SELECIONE--]</option>';
                    dados.results.forEach(d => {
                        html += `       <option value="${d.idi}">${d.desci}</option>`;
                    });
                    html += '       </select>';
                    html += '   </div>';
                    html += '</div>';
                    html += `<div class="col-md-3 pr-2 pl-2 mt-3" id="divcargaInovTec${x}">`;
                    html += '   <div class="col-md-12"><b>Carga Horária</b></div>';
                    html += `   <div class="col-md-12"><input type="number" min="1" class="form-control" required="required" id="cargahrInovTec${x}" name="cargahrInovTec${x}" onchange="chitall(${x});"/></div>`;
                    html += '</div>';
                    html += `<div class="col-md-9 pr-2 pl-2" id="divinfoInovTec${x}">`;
                    html += '   <div class="col-md-12"><b>Informação</b></div>';
                    html += `   <div class="col-md-12"><input type="text" disabled="disabled" class="form-control" id="infoit${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-3 pr-2 pl-2" id="divpontoInovTec${x}">`;
                    html += '   <div class="col-md-12"><b>Pontuação Estimada</b></div>';
                    html += `   <div class="col-md-12"><input type="text" class="form-control" disabled="disabled" id="pontoit${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-5 pr-2 pl-2" id="divtituloInovTec${x}">`;
                    html += '   <div class="col-md-12"><b>Título da atividade</b></div>';
                    html += `   <div class="col-md-12"><input type="text" class="form-control" required="required" id="tituloInovTec${x}" name="tituloInovTec${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-5 pr-2 pl-2" id="divanexoInovTec${x}">`;
                    html += '   <div class="col-md-12"><b>Anexar documento</b><small class="text-danger">&nbsp;&nbsp; * Favor juntar os documentos em um único arquivo PDF.</small></div>';
                    html += `   <div class="col-md-12"><input type="file" class="form-control" required="required" id="anexoInovTec${x}" name="anexoInovTec${x}" /></div>`;
                    html += '</div>';
                    html += `<div class="col-md-2 pr-2 pl-2" id="divbtnInovTec${x}">`;
                    html += `  <div class="col-md-12"><button class="btn btn-outline-danger mt-4 form-control" id="btInovTec${x}" onclick="retiraInovTec(${x})">REMOVER <i class="fas fa-times-circle"></i></button></div>`;
                    html += '</div>';
                }
                divInovTec1.innerHTML += html;
//                console.log(divLongDuracao);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
