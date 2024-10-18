
function addciclo(a){ 
    let ano = a;
    console.log(ano);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getciclo/index.php?a='+a)
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
                let cicloap = document.querySelector("#cicloap");
                removerTodasAsOptions(cicloap);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                cicloap.appendChild(option1);    
                console.log(cicloap);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.ciclo;
                    option.textContent = d.ciclo+"º ciclo";
                    cicloap.appendChild(option);
                });
                cicloap.innerHTML += html;
                console.log(cicloap);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function removerTodasAsOptions(select) {
    while (select.options.length > 0) {
        select.remove(0);
    }
}
function addciclo2(a){ 
    let ano = a;
    console.log(ano);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getciclo/index.php?a='+a)
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
                let cicloav = document.querySelector("#cicloav");
                removerTodasAsOptions(cicloav);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                cicloav.appendChild(option1); 
                console.log(cicloav);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.ciclo;
                    option.textContent = d.ciclo+"º ciclo";
                    cicloav.appendChild(option);
                });
                cicloav.innerHTML += html;
                console.log(cicloav);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addciclo3(a){ 
    console.log(a);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getciclo/index.php?a='+a)
        .then(response => {
            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let ciclod = document.querySelector("#ciclod");
                removerTodasAsOptions(ciclod);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                ciclod.appendChild(option1); 
                console.log(ciclod);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.ciclo;
                    option.textContent = d.ciclo+"º ciclo";
                    ciclod.appendChild(option);
                });
                ciclod.innerHTML += html;
                console.log(ciclod);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addciclo4(a){ 
    console.log(a);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getciclo/index.php?a='+a)
        .then(response => {
            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let cicloaf = document.querySelector("#cicloaf");
                removerTodasAsOptions(cicloaf);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                cicloaf.appendChild(option1); 
                console.log(cicloaf);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.ciclo;
                    option.textContent = d.ciclo+"º ciclo";
                    cicloaf.appendChild(option);
                });
                cicloaf.innerHTML += html;
                console.log(cicloaf);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addciclo5(a){ 
    console.log(a);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getciclo/index.php?a='+a)
        .then(response => {
            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let cicloab = document.querySelector("#cicloab");
                removerTodasAsOptions(cicloab);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                cicloab.appendChild(option1); 
                console.log(cicloab);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.ciclo;
                    option.textContent = d.ciclo+"º ciclo";
                    cicloab.appendChild(option);
                });
                cicloab.innerHTML += html;
                console.log(cicloab);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addciclo6(a){ 
    console.log(a);
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getciclo/index.php?a='+a)
        .then(response => {
            console.log(response);
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let cicloab = document.querySelector("#cicloc");
                removerTodasAsOptions(cicloab);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                cicloab.appendChild(option1); 
                console.log(cicloab);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.ciclo;
                    option.textContent = d.ciclo+"º ciclo";
                    cicloab.appendChild(option);
                });
                cicloab.innerHTML += html;
                console.log(cicloab);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
function addperiodo(a,c){ 
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/getperiodo/index.php?a='+a+'&c='+c)
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
                let periodod = document.querySelector("#periodod");
                removerTodasAsOptions(periodod);
                var option1 = document.createElement('option');
                    option1.value = "";
                    option1.textContent = "[--SELECIONE--]";
                periodod.appendChild(option1); 
                console.log(periodod);
                let html = '';
                dados.results.forEach(d => {
                    var option = document.createElement('option');
                    option.value = d.fkperiodo;
                    option.textContent = d.descricaoperiodo;
                    periodod.appendChild(option);
                });
                periodod.innerHTML += html;
                console.log(periodod);
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro: '+err);
        });
}
