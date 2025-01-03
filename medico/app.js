window.onload = () => {
    var codMunicipio = "";
    // buscar os dados dos estados
    fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/get_all_estados')
        .then(response => {
            console.log(response)
            if (response.status === 200) {
                return response.json();
            } else {
                throw Error('erro');
            }
        })
        .then(dados => {
            //console.log(dados);
            if (dados.status === 'success') {
                let select_estado = document.querySelector("#select_estado");
                dados.results.forEach(uf => {
                    let option = document.createElement('option');
                    option.value = uf.cod_uf;
                    option.textContent = uf.UF;
                    select_estado.appendChild(option);
                });
            } else {
                throw Error('erro');
            }
        })
        .catch(err => {
            console.log('Erro');
        })
    // adicionar evento change no select
    select_estado.addEventListener('change', () => {
        let id = select_estado.value;

        if (id !== 0) {
            fetch('http://localhost:83/desempenho_tutor/recursos_online/api/v1/get_all_municipios/?id=' + id)
                .then(response => {
                    if (response.status === 200) {
                        return response.json();
                    } else {
                        throw Error('erro');
                    }
                })
                .then(data => {
                    //console.log(data)
                    let posts = data.results;
                    let municipio_posts = document.querySelector("#municipio_posts");
                    let no_posts = document.querySelector("#no_posts");
                    municipio_posts.innerHTML = null;

                    if (posts.length == 0) {
                        municipio_posts.classList.add("d-none");
                        no_posts.classList.remove("d-none");
                    } else {
                        let html = ' <h4 class="mt-5">Selecione o Município</h4><hr>';
                        html += `<select id="select_municipio" class="form-select w-75">`;
                        html += ` <option value="0">[--SELECIONE--]</option>`;
                        posts.forEach(post => {
                            html += `<option value="${post.cod_munc}">${post.Municipio}</option>`;
                        })
                        html += `</select>`;

                        let post_div = document.createElement('div');
                        post_div.innerHTML = html;
                        municipio_posts.appendChild(post_div);

                        var select = document.getElementById('select_municipio')
                        select.addEventListener('change', function () {
                            //console.log(select)
                            // obtendo o codigo do municipio
                            codMunicipio = select.value;

                            if (codMunicipio !== 0) {
                                fetch('../recursos_online/api/v1/get_all_medicos/?ibge=' + codMunicipio)
                                    .then(response => {
                                        //console.log(response)
                                        if (response.status === 200) {
                                            return response.json();
                                        } else {
                                            throw Error('erro');
                                        }
                                    })
                                    .then(data => {
                                        //console.log(data)
                                        let posts = data.results;
                                        let medico_posts = document.querySelector("#medico_posts");
                                        let no_posts_medico = document.querySelector("#no_posts_medico");
                                        medico_posts.innerHTML = null;

                                        if (posts == 0) {
                                            medico_posts.classList.add("d-none");
                                            no_posts_medico.classList.remove("d-none");
                                        } else {
                                            let html = ' <h4 class="mt-5">Selecione o INE do médico</h4><hr>';
                                            html += `<select id="select_medico" class="form-select w-75">`;
                                            html += ` <option value="0">[--SELECIONE--]</option>`;
                                            posts.forEach(post => {
                                                //console.log(post)
                                                html += `<option value="${post.ine}">${post.ine}</option>`;
                                                //html += ` `;
                                            })

                                            html += `</select>`;
                                            let post_div = document.createElement('div');
                                            post_div.innerHTML = html;
                                            medico_posts.appendChild(post_div);
                                            medico_posts.classList.remove("d-none");
                                            no_posts_medico.classList.add("d-none");

                                            var select = document.getElementById('select_medico');

                                            select.addEventListener('change', function () {
                                                var ineTutor = (select.value);
                                                document.getElementById("btnAvaliacao").innerHTML = `<a class="btn btn-outline-primary mt-4" href="http://localhost/desempenho_tutor/gestor/qa.php?i=${ineTutor}"  target="_blank">Desempenho do médico tutor</a>`;
                                            });
                                        }
                                    });
                            }

                        })
                        municipio_posts.classList.remove("d-none");
                        no_posts.classList.add("d-none");
                    }
                })
                .catch(() => {
                    console.log('erro');
                })
        }
    })
    // selecionar os médicos por estado e município
}