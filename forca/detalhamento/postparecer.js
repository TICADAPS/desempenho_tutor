    /* global fetch */
function postparecerlongd(){
//    event.preventDefault(); // Evita o envio normal do formulário
    let cpfpost = document.querySelector('#cpfpost').value;
    let ibgepost = document.querySelector('#ibgepost').value;
    let cnespost = document.querySelector('#cnespost').value;
    let inepost = document.querySelector('#inepost').value;
    let idappost = document.querySelector('#idappost').value;
    let anopost = document.querySelector('#anopost').value;
    let ciclopost = document.querySelector('#ciclopost').value;
    let parecerap = document.querySelector('#parecerap').value;
    let iduserpost = document.querySelector('#iduserpost').value;
    console.log(parecerap);
    let flagparecerap = null;
    if($('#flagparecerap1').is(':checked')){
        flagparecerap = 1;
    }
    if($('#flagparecerap2').is(':checked')){
        flagparecerap = 0;
    }
    if(flagparecerap === null){
        swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no parecer da Atividade de Longa Duração.",
                icon: "warning",
                button: "OK"
            });
            return;
    }
    if(parecerap === null){
        parecerap = '';
    }
//    console.log(cpfpost, ibgepost, cnespost,inepost,idappost,anopost,ciclopost,parecerap,flagparecerap,iduserpost);
    var dados = new FormData();
    dados.append('cpf', cpfpost);
    dados.append('ibge', ibgepost);
    dados.append('cnes', cnespost);
    dados.append('ine', inepost);
    dados.append('idap', idappost);
    dados.append('ano', anopost);
    dados.append('ciclo', ciclopost);
    dados.append('parecerap', parecerap);
    dados.append('flagparecerap', flagparecerap);
    dados.append('iduser', iduserpost);
//    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('https://agsusbrasil.org/desempenho_tutor/forca/detalhamento/controller/parecerlongd.php', {
        method: 'POST',
        body: dados
    })
    .then(response => response.text()) // Processa a resposta em formato JSON
    .then(data => {
        // Exibe o resultado no HTML
        if(data !== ''){
            swal({
                title: "Atenção!",
                text: "Erro: " + data,
                icon: "warning",
                button: "OK"
            });
            return;
        }
    })
    .catch(erro => {
//        $('#msg').html(erro).fadeIn();
        swal({
            title: "Atenção!",
            text: "Erro: " + erro,
            icon: "warning",
            button: "OK"
        });
        return;
    });
}
function envqaform(a){
//    event.preventDefault(); // Evita o envio normal do formulário
    let cpfqa = document.querySelector('#cpfqa'+a).value;
    let ibgeqa = document.querySelector('#ibgeqa'+a).value;
    let cnesqa = document.querySelector('#cnesqa'+a).value;
    let ineqa = document.querySelector('#ineqa'+a).value;
    let idapqa = document.querySelector('#idapqa'+a).value;
    let anoqa = document.querySelector('#anoqa'+a).value;
    let cicloqa = document.querySelector('#cicloqa'+a).value;
    let qcidqa = document.querySelector('#qcid'+a).value;
    let qcch= document.querySelector('#qcch'+a).value;
    let iduserqa = document.querySelector('#iduserqa'+a).value;
    let qcparecerqa = document.querySelector('#qcparecerqa'+a).value;
//    console.log(qcparecerqa);
    let qcflagparecer = null;
    if($('#qcflagparecer1'+a).is(':checked')){
        qcflagparecer = 1;
    }
    if($('#qcflagparecer2'+a).is(':checked')){
        qcflagparecer = 0;
    }
    if(qcflagparecer === null){
        swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no parecer da Atividade Qualificação Clínica.",
                icon: "warning",
                button: "OK"
            });
            return;
    }
    if(qcparecerqa === null){
        qcparecerqa = '';
    }
    var dados = new FormData();
    dados.append('cpf', cpfqa);
    dados.append('ibge', ibgeqa);
    dados.append('cnes', cnesqa);
    dados.append('ine', ineqa);
    dados.append('idap', idapqa);
    dados.append('ano', anoqa);
    dados.append('ciclo', cicloqa);
    dados.append('qcid', qcidqa);
    dados.append('qcch', qcch);
    dados.append('qcparecerqa', qcparecerqa);
    dados.append('qcflagparecer', qcflagparecer);
    dados.append('iduser', iduserqa);
    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('https://agsusbrasil.org/desempenho_tutor/forca/detalhamento/controller/parecerqc.php', {
        method: 'POST',
        body: dados
    })
    .then(response => response.text()) // Processa a resposta em formato JSON
    .then(data => {
        // Exibe o resultado no HTML
        if(data !== ''){
            swal({
                title: "Atenção!",
                text: "Erro: " + data,
                icon: "warning",
                button: "OK"
            });
            return;
        }
    })
    .catch(erro => {
//        $('#msg').html(erro).fadeIn();
        swal({
            title: "Atenção!",
            text: "Erro: " + erro,
            icon: "warning",
            button: "OK"
        });
        return;
    });
}
function envgepeform(a){
//    event.preventDefault(); // Evita o envio normal do formulário
    let cpfgepe = document.querySelector('#cpfgepe'+a).value;
    let ibgegepe = document.querySelector('#ibgegepe'+a).value;
    let cnesgepe = document.querySelector('#cnesgepe'+a).value;
    let inegepe = document.querySelector('#inegepe'+a).value;
    let idapgepe = document.querySelector('#idapgepe'+a).value;
    let anogepe = document.querySelector('#anogepe'+a).value;
    let ciclogepe = document.querySelector('#ciclogepe'+a).value;
    let gepeid = document.querySelector('#gepeid'+a).value;
    let gepech= document.querySelector('#gepech'+a).value;
    let idusergepe = document.querySelector('#idusergepe'+a).value;
    let gepeparecer = document.querySelector('#gepeparecer'+a).value;
//    console.log(qcparecerqa);
    let gepeflagparecer = null;
    if($('#gepeflagparecer1'+a).is(':checked')){
        gepeflagparecer = 1;
    }
    if($('#gepeflagparecer2'+a).is(':checked')){
        gepeflagparecer = 0;
    }
    if(gepeflagparecer === null){
        swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no parecer da Atividade Gestão, Ensino, Pesquisa e Extensão.",
                icon: "warning",
                button: "OK"
            });
            return;
    }
    if(gepeparecer === null){
        gepeparecer = '';
    }
    var dados = new FormData();
    dados.append('cpf', cpfgepe);
    dados.append('ibge', ibgegepe);
    dados.append('cnes', cnesgepe);
    dados.append('ine', inegepe);
    dados.append('idap', idapgepe);
    dados.append('ano', anogepe);
    dados.append('ciclo', ciclogepe);
    dados.append('gepeid', gepeid);
    dados.append('gepech', gepech);
    dados.append('gepeparecer', gepeparecer);
    dados.append('gepeflagparecer', gepeflagparecer);
    dados.append('iduser', idusergepe);
    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('https://agsusbrasil.org/desempenho_tutor/forca/detalhamento/controller/parecergepe.php', {
        method: 'POST',
        body: dados
    })
    .then(response => response.text()) // Processa a resposta em formato JSON
    .then(data => {
        // Exibe o resultado no HTML
        if(data !== ''){
            swal({
                title: "Atenção!",
                text: "Erro: " + data,
                icon: "warning",
                button: "OK"
            });
            return;
        }
    })
    .catch(erro => {
//        $('#msg').html(erro).fadeIn();
        swal({
            title: "Atenção!",
            text: "Erro: " + erro,
            icon: "warning",
            button: "OK"
        });
        return;
    });
}
function envitform(a){
//    event.preventDefault(); // Evita o envio normal do formulário
    let cpfit = document.querySelector('#cpfit'+a).value;
    let ibgeit = document.querySelector('#ibgeit'+a).value;
    let cnesit = document.querySelector('#cnesit'+a).value;
    let ineit = document.querySelector('#ineit'+a).value;
    let idapit = document.querySelector('#idapit'+a).value;
    let anoit = document.querySelector('#anoit'+a).value;
    let cicloit = document.querySelector('#cicloit'+a).value;
    let itid = document.querySelector('#itid'+a).value;
    let itch= document.querySelector('#itch'+a).value;
    let iduserit = document.querySelector('#iduserit'+a).value;
    let itparecer = document.querySelector('#itparecer'+a).value;
//    console.log(qcparecerqa);
    let itflagparecer = null;
    if($('#itflagparecer1'+a).is(':checked')){
        itflagparecer = 1;
    }
    if($('#itflagparecer2'+a).is(':checked')){
        itflagparecer = 0;
    }
    if(itflagparecer === null){
        swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no parecer da Atividade Gestão, Ensino, Pesquisa e Extensão.",
                icon: "warning",
                button: "OK"
            });
            return;
    }
    if(itparecer === null){
        itparecer = '';
    }
    var dados = new FormData();
    dados.append('cpf', cpfit);
    dados.append('ibge', ibgeit);
    dados.append('cnes', cnesit);
    dados.append('ine', ineit);
    dados.append('idap', idapit);
    dados.append('ano', anoit);
    dados.append('ciclo', cicloit);
    dados.append('itid', itid);
    dados.append('itch', itch);
    dados.append('itparecer', itparecer);
    dados.append('itflagparecer', itflagparecer);
    dados.append('iduser', iduserit);
    console.log(dados);
    // Envia os dados via AJAX usando fetch
    fetch('https://agsusbrasil.org/desempenho_tutor/forca/detalhamento/controller/parecerit.php', {
        method: 'POST',
        body: dados
    })
    .then(response => response.text()) // Processa a resposta em formato JSON
    .then(data => {
        // Exibe o resultado no HTML
        if(data !== ''){
            swal({
                title: "Atenção!",
                text: "Erro: " + data,
                icon: "warning",
                button: "OK"
            });
            return;
        }
    })
    .catch(erro => {
//        $('#msg').html(erro).fadeIn();
        swal({
            title: "Atenção!",
            text: "Erro: " + erro,
            icon: "warning",
            button: "OK"
        });
        return;
    });
}

