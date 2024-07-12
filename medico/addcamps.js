
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
//                console.log(divLongDuracao);
                let html = '';
                html += `<div class="col-sm-5 pr-2 pl-2 divLongDuracao" id="atvLongDur${num}">`;
                html += '   <b>Tipo de atividade</b>';
                html += '   <div class="col-sm-12">';
                html += `       <select class="form-control" id="slLongaDuracao${num}" name="slLongaDuracao${num}">`;
                html += '           <option value="">[--SELECIONE--]</option>';
                dados.results.forEach(d => {
                    html += `       <option value="${d.idl}">${d.descl}</option>`;
                });
                html += '       </select>';
                html += '   </div>';
                html += '</div>';
                html += `<div class="col-sm-2 pr-2 pl-2" id="cargaLongDur${num}">`;
                html += '   <b>Carga Horária</b>';
                html += `   <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrLongaDuracao${num}" name="cargahrLongaDuracao${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-4 pr-2 pl-2" id="anexoLongDur${num}">`;
                html += '   <b>Anexar documento</b>';
                html += `   <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoLongaDuracao${num}" name="anexoLongaDuracao${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-1 pr-2 pl-2" id="btnLongDur${num}">`;
                html += `  <div class="col-sm-12"><button class="btn btn-outline-danger mt-4 form-control" id="btnLongaDuracao${num}" onclick="retiraAtvLongDur(${num})"><i class="fas fa-times-circle"></i></button></div>`;
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
    let num = (a-1);
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
//                console.log(divQualiClinica1);
                let html = '';
                html += `<div class="col-sm-8 pr-2 pl-2 divQualiClinica mt-3" id="qualiClinica${num}">`;
                html += '   <b>Tipo de atividade</b>';
                html += '   <div class="col-sm-12">';
                html += `       <select class="form-control" id="slQualiClinica${num}" name="slQualiClinica${num}">`;
                html += '           <option value="">[--SELECIONE--]</option>';
                dados.results.forEach(d => {
                    html += `       <option value="${d.idq}">${d.descq}</option>`;
                });
                html += '       </select>';
                html += '   </div>';
                html += '</div>';
                html += `<div class="col-sm-3 pr-2 pl-2 mt-3" id="divcargaQualiClinica${num}">`;
                html += '   <b>Carga Horária</b>';
                html += `   <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrQualiClinica${num}" name="cargahrQualiClinica${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-6 pr-2 pl-2" id="divtituloQualiClinica${num}">`;
                html += '   <b>Título da atividade</b>';
                html += `   <div class="col-sm-12"><input type="text" class="form-control" value="" id="tituloQualiClinica${num}" name="tituloQualiClinica${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-5 pr-2 pl-2" id="divanexoQualiClinica${num}">`;
                html += '   <b>Anexar documento</b>';
                html += `   <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoaQualiClinica${num}" name="anexoaQualiClinica${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-1 pr-2 pl-2" id="divbtnQualiClinica${num}">`;
                html += `  <div class="col-sm-12"><button class="btn btn-outline-danger mt-4 form-control" id="btQualiClinica${num}" onclick="retiraQualiClinica(${num})"><i class="fas fa-times-circle"></i></button></div>`;
                html += '</div>';
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
    let num = (a-1);
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
//                console.log(divQualiClinica1);
                let html = '';
                html += `<div class="col-sm-8 pr-2 pl-2 divGesEnsPesExt mt-3" id="gesEnsPesExt${num}">`;
                html += '   <b>Tipo de atividade</b>';
                html += '   <div class="col-sm-12">';
                html += `       <select class="form-control" id="slGesEnsPesExt${num}" name="slGesEnsPesExt${num}">`;
                html += '           <option value="">[--SELECIONE--]</option>';
                dados.results.forEach(d => {
                    html += `       <option value="${d.idg}">${d.descg}</option>`;
                });
                html += '       </select>';
                html += '   </div>';
                html += '</div>';
                html += `<div class="col-sm-3 pr-2 pl-2 mt-3" id="divcargaGesEnsPesExt${num}">`;
                html += '   <b>Carga Horária</b>';
                html += `   <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrGesEnsPesExt${num}" name="cargahrGesEnsPesExt${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-6 pr-2 pl-2" id="divtituloGesEnsPesExt${num}">`;
                html += '   <b>Título da atividade</b>';
                html += `   <div class="col-sm-12"><input type="text" class="form-control" value="" id="tituloGesEnsPesExt${num}" name="tituloGesEnsPesExt${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-5 pr-2 pl-2" id="divanexoGesEnsPesExt${num}">`;
                html += '   <b>Anexar documento</b>';
                html += `   <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoaGesEnsPesExt${num}" name="anexoaGesEnsPesExt${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-1 pr-2 pl-2" id="divbtnGesEnsPesExt${num}">`;
                html += `  <div class="col-sm-12"><button class="btn btn-outline-danger mt-4 form-control" id="btGesEnsPesExt${num}" onclick="retiraGesEnsPesExt(${num})"><i class="fas fa-times-circle"></i></button></div>`;
                html += '</div>';
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
    let num = (a-1);
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
//                console.log(divQualiClinica1);
                let html = '';
                html += `<div class="col-sm-8 pr-2 pl-2 divInovTec mt-3" id="inovTec${num}">`;
                html += '   <b>Tipo de atividade</b>';
                html += '   <div class="col-sm-12">';
                html += `       <select class="form-control" id="slInovTec${num}" name="slInovTec${num}">`;
                html += '           <option value="">[--SELECIONE--]</option>';
                dados.results.forEach(d => {
                    html += `       <option value="${d.idi}">${d.desci}</option>`;
                });
                html += '       </select>';
                html += '   </div>';
                html += '</div>';
                html += `<div class="col-sm-3 pr-2 pl-2 mt-3" id="divcargaInovTec${num}">`;
                html += '   <b>Carga Horária</b>';
                html += `   <div class="col-sm-12"><input type="number" class="form-control" value="" id="cargahrInovTec${num}" name="cargahrInovTec${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-6 pr-2 pl-2" id="divtituloInovTec${num}">`;
                html += '   <b>Título da atividade</b>';
                html += `   <div class="col-sm-12"><input type="text" class="form-control" value="" id="tituloInovTec${num}" name="tituloInovTec${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-5 pr-2 pl-2" id="divanexoInovTec${num}">`;
                html += '   <b>Anexar documento</b>';
                html += `   <div class="col-sm-12"><input type="file" class="form-control" value="" id="anexoInovTec${num}" name="anexoInovTec${num}" /></div>`;
                html += '</div>';
                html += `<div class="col-sm-1 pr-2 pl-2" id="divbtnInovTec${num}">`;
                html += `  <div class="col-sm-12"><button class="btn btn-outline-danger mt-4 form-control" id="btInovTec${num}" onclick="retiraInovTec(${num})"><i class="fas fa-times-circle"></i></button></div>`;
                html += '</div>';
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