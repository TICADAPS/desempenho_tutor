    /* global fetch */

document.getElementById('avaliacaoForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita o envio normal do formulário

        let cpf = document.querySelector('#cpf').value;
        let ibge = document.querySelector('#ibge').value;
        let cnes = document.querySelector('#cnes').value;
        let ine = document.querySelector('#ine').value;
        let ano = document.querySelector('#ano').value;
        let ciclo = document.querySelector('#ciclo').value;
        let idcp = document.querySelector('#idcp').value;
        // Obtém os conteúdos das perguntas
        let pergunta1_1 = document.querySelector('#pergunta1_1').value;
        let pergunta1_2 = document.querySelector('#pergunta1_2').value;
        let pergunta1_3 = document.querySelector('#pergunta1_3').value;
        let pergunta1_4 = document.querySelector('#pergunta1_4').value;
        let pergunta1_5 = document.querySelector('#pergunta1_5').value;
        let pergunta2_1 = document.querySelector('#pergunta2_1').value;
        let pergunta2_2 = document.querySelector('#pergunta2_2').value;
        let pergunta2_3 = document.querySelector('#pergunta2_3').value;
        let pergunta2_4 = document.querySelector('#pergunta2_4').value;
        let pergunta2_5 = document.querySelector('#pergunta2_5').value;
        let pergunta3_1 = document.querySelector('#pergunta3_1').value;
        let pergunta3_2 = document.querySelector('#pergunta3_2').value;
        let pergunta3_3 = document.querySelector('#pergunta3_3').value;
        let pergunta4_1 = document.querySelector('#pergunta4_1').value;
        let pergunta4_2 = document.querySelector('#pergunta4_2').value;
        let pergunta4_3 = document.querySelector('#pergunta4_3').value;
        let pergunta4_4 = document.querySelector('#pergunta4_4').value;
        let pergunta5_1 = document.querySelector('#pergunta5_1').value;
        let pergunta5_2 = document.querySelector('#pergunta5_2').value;
        let pergunta5_3 = document.querySelector('#pergunta5_3').value;
        let pergunta5_4 = document.querySelector('#pergunta5_4').value;
        let pergunta6_1 = document.querySelector('#pergunta6_1').value;
        let pergunta6_2 = document.querySelector('#pergunta6_2').value;
        let pergunta6_3 = document.querySelector('#pergunta6_3').value;
        let pergunta7_1 = document.querySelector('#pergunta7_1').value;
        let pergunta7_2 = document.querySelector('#pergunta7_2').value;
        let pergunta7_3 = document.querySelector('#pergunta7_3').value;
        let pergunta7_4 = document.querySelector('#pergunta7_4').value;
        let pergunta7_5 = document.querySelector('#pergunta7_5').value;
        let pergunta8_1 = document.querySelector('#pergunta8_1').value;
        let pergunta8_2 = document.querySelector('#pergunta8_2').value;
        let pergunta8_3 = document.querySelector('#pergunta8_3').value;
        let pergunta8_4 = document.querySelector('#pergunta8_4').value;
        let pergunta9_1 = document.querySelector('#pergunta9_1').value;
        let pergunta9_2 = document.querySelector('#pergunta9_2').value;
        let pergunta9_3 = document.querySelector('#pergunta9_3').value;
        let pergunta9_4 = document.querySelector('#pergunta9_4').value;
        
        // Obtém os valores das respostas
        let question1_1 = document.querySelector('input[name="question1_1"]:checked');
        let question1_2 = document.querySelector('input[name="question1_2"]:checked');
        let question1_3 = document.querySelector('input[name="question1_3"]:checked');
        let question1_4 = document.querySelector('input[name="question1_4"]:checked');
        let question1_5 = document.querySelector('input[name="question1_5"]:checked');
        let question2_1 = document.querySelector('input[name="question2_1"]:checked');
        let question2_2 = document.querySelector('input[name="question2_2"]:checked');
        let question2_3 = document.querySelector('input[name="question2_3"]:checked');
        let question2_4 = document.querySelector('input[name="question2_4"]:checked');
        let question2_5 = document.querySelector('input[name="question2_5"]:checked');
        let question3_1 = document.querySelector('input[name="question3_1"]:checked');
        let question3_2 = document.querySelector('input[name="question3_2"]:checked');
        let question3_3 = document.querySelector('input[name="question3_3"]:checked');
        let question4_1 = document.querySelector('input[name="question4_1"]:checked');
        let question4_2 = document.querySelector('input[name="question4_2"]:checked');
        let question4_3 = document.querySelector('input[name="question4_3"]:checked');
        let question4_4 = document.querySelector('input[name="question4_4"]:checked');
        let question5_1 = document.querySelector('input[name="question5_1"]:checked');
        let question5_2 = document.querySelector('input[name="question5_2"]:checked');
        let question5_3 = document.querySelector('input[name="question5_3"]:checked');
        let question5_4 = document.querySelector('input[name="question5_4"]:checked');
        let question6_1 = document.querySelector('input[name="question6_1"]:checked');
        let question6_2 = document.querySelector('input[name="question6_2"]:checked');
        let question6_3 = document.querySelector('input[name="question6_3"]:checked');
        let question7_1 = document.querySelector('input[name="question7_1"]:checked');
        let question7_2 = document.querySelector('input[name="question7_2"]:checked');
        let question7_3 = document.querySelector('input[name="question7_3"]:checked');
        let question7_4 = document.querySelector('input[name="question7_4"]:checked');
        let question7_5 = document.querySelector('input[name="question7_5"]:checked');
        let question8_1 = document.querySelector('input[name="question8_1"]:checked');
        let question8_2 = document.querySelector('input[name="question8_2"]:checked');
        let question8_3 = document.querySelector('input[name="question8_3"]:checked');
        let question8_4 = document.querySelector('input[name="question8_4"]:checked');
        let question9_1 = document.querySelector('input[name="question9_1"]:checked');
        let question9_2 = document.querySelector('input[name="question9_2"]:checked');
        let question9_3 = document.querySelector('input[name="question9_3"]:checked');
        let question9_4 = document.querySelector('input[name="question9_4"]:checked');
        
        let q1_1 = null;
        let q1_2 = null;
        let q1_3 = null;
        let q1_4 = null;
        let q1_5 = null;
        let q2_1 = null;
        let q2_2 = null;
        let q2_3 = null;
        let q2_4 = null;
        let q2_5 = null;
        let q3_1 = null;
        let q3_2 = null;
        let q3_3 = null;
        let q4_1 = null;
        let q4_2 = null;
        let q4_3 = null;
        let q4_4 = null;
        let q5_1 = null;
        let q5_2 = null;
        let q5_3 = null;
        let q5_4 = null;
        let q6_1 = null;
        let q6_2 = null;
        let q6_3 = null;
        let q7_1 = null;
        let q7_2 = null;
        let q7_3 = null;
        let q7_4 = null;
        let q7_5 = null;
        let q8_1 = null;
        let q8_2 = null;
        let q8_3 = null;
        let q8_4 = null;
        let q9_1 = null;
        let q9_2 = null;
        let q9_3 = null;
        let q9_4 = null;
        
        //verifica se o campo não foi selecionado
        if(question1_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 1.1",
                icon: "warning",
                button: "OK"
            });
            showPage(1);
            return;
        }else{
            q1_1 = question1_1.value;
        }
        if(question1_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 1.2",
                icon: "warning",
                button: "OK"
            });
            return;
            showPage(1);
        }else{
            q1_2 = question1_2.value;
        }
        if(question1_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 1.3",
                icon: "warning",
                button: "OK"
            });
            showPage(1);
            return;
        }else{
            q1_3 = question1_3.value;
        }
        if(question1_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 1.4",
                icon: "warning",
                button: "OK"
            });
            showPage(1);
            return;
        }else{
            q1_4 = question1_4.value;
        }
        if(question1_5 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 1.5",
                icon: "warning",
                button: "OK"
            });
            showPage(1);
            return;
        }else{
            q1_5 = question1_5.value;
        }
        if(question2_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 2.1",
                icon: "warning",
                button: "OK"
            });
            showPage(2);
            return;
        }else{
            q2_1 = question2_1.value;
        }
        if(question2_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 2.2",
                icon: "warning",
                button: "OK"
            });
            showPage(2);
            return;
        }else{
            q2_2 = question2_2.value;
        }
        if(question2_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 2.3",
                icon: "warning",
                button: "OK"
            });
            showPage(2);
            return;
        }else{
            q2_3 = question2_3.value;
        }
        if(question2_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 2.4",
                icon: "warning",
                button: "OK"
            });
            showPage(2);
            return;
        }else{
            q2_4 = question2_4.value;
        }
        if(question2_5 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 2.5",
                icon: "warning",
                button: "OK"
            });
            showPage(2);
            return;
        }else{
            q2_5 = question2_5.value;
        }
        if(question3_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 3.1",
                icon: "warning",
                button: "OK"
            });
            showPage(3);
            return;
        }else{
            q3_1 = question3_1.value;
        }
        if(question3_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 3.2",
                icon: "warning",
                button: "OK"
            });
            showPage(3);
            return;
        }else{
            q3_2 = question3_2.value;
        }
        if(question3_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 3.3",
                icon: "warning",
                button: "OK"
            });
            showPage(3);
            return;
        }else{
            q3_3 = question3_3.value;
        }
        if(question4_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 4.1",
                icon: "warning",
                button: "OK"
            });
            showPage(4);
            return;
        }else{
            q4_1 = question4_1.value;
        }
        if(question4_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 4.2",
                icon: "warning",
                button: "OK"
            });
            showPage(4);
            return;
        }else{
            q4_2 = question4_2.value;
        }
        if(question4_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 4.3",
                icon: "warning",
                button: "OK"
            });
            showPage(4);
            return;
        }else{
            q4_3 = question4_3.value;
        }
        if(question4_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 4.4",
                icon: "warning",
                button: "OK"
            });
            showPage(4);
            return;
        }else{
            q4_4 = question4_4.value;
        }
        if(question5_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 5.1",
                icon: "warning",
                button: "OK"
            });
            showPage(5);
            return;
        }else{
            q5_1 = question5_1.value;
        }
        if(question5_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 5.2",
                icon: "warning",
                button: "OK"
            });
            showPage(5);
            return;
        }else{
            q5_2 = question5_2.value;
        }
        if(question5_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 5.3",
                icon: "warning",
                button: "OK"
            });
            showPage(5);
            return;
        }else{
            q5_3 = question5_3.value;
        }
        if(question5_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 5.4",
                icon: "warning",
                button: "OK"
            });
            showPage(5);
            return;
        }else{
            q5_4 = question5_4.value;
        }
        if(question6_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 6.1",
                icon: "warning",
                button: "OK"
            });
            showPage(6);
            return;
        }else{
            q6_1 = question6_1.value;
        }
        if(question6_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 6.2",
                icon: "warning",
                button: "OK"
            });
            showPage(6);
            return;
        }else{
            q6_2 = question6_2.value;
        }
        if(question6_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 6.3",
                icon: "warning",
                button: "OK"
            });
            showPage(6);
            return;
        }else{
            q6_3 = question6_3.value;
        }
        if(question7_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 7.1",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q7_1 = question7_1.value;
        }
        if(question7_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 7.2",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q7_2 = question7_2.value;
        }
        if(question7_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 7.3",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q7_3 = question7_3.value;
        }
        if(question7_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 7.4",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q7_4 = question7_4.value;
        }
        if(question7_5 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 7.5",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q7_5 = question7_5.value;
        }
        if(question8_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 8.1",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q8_1 = question8_1.value;
        }
        if(question8_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 8.2",
                icon: "warning",
                button: "OK"
            });
            showPage(7);
            return;
        }else{
            q8_2 = question8_2.value;
        }
        if(question8_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 8.3",
                icon: "warning",
                button: "OK"
            });
            showPage(8);
            return;
        }else{
            q8_3 = question8_3.value;
        }
        if(question8_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 8.4",
                icon: "warning",
                button: "OK"
            });
            showPage(8);
            return;
        }else{
            q8_4 = question8_4.value;
        }
        if(question9_1 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 9.1",
                icon: "warning",
                button: "OK"
            });
            showPage(9);
            return;
        }else{
            q9_1 = question9_1.value;
        }
        if(question9_2 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 9.2",
                icon: "warning",
                button: "OK"
            });
            showPage(9);
            return;
        }else{
            q9_2 = question9_2.value;
        }
        if(question9_3 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 9.3",
                icon: "warning",
                button: "OK"
            });
            showPage(9);
            return;
        }else{
            q9_3 = question9_3.value;
        }
        if(question9_4 === null){
            swal({
                title: "Atenção!",
                text: "Marque uma das alternativas no item 9.4",
                icon: "warning",
                button: "OK"
            });
            showPage(9);
            return;
        }else{
            q9_4 = question9_4.value;
        }

        // Cria um objeto com os dados
        const dados = {
            cpf: cpf,
            ibge: ibge,
            cnes: cnes,
            ine: ine,
            ano: ano,
            ciclo: ciclo,
            idcp: idcp,
            pergunta1_1: pergunta1_1,
            pergunta1_2: pergunta1_2,
            pergunta1_3: pergunta1_3,
            pergunta1_4: pergunta1_4,
            pergunta1_5: pergunta1_5,
            pergunta2_1: pergunta2_1,
            pergunta2_2: pergunta2_2,
            pergunta2_3: pergunta2_3,
            pergunta2_4: pergunta2_4,
            pergunta2_5: pergunta2_5,
            pergunta3_1: pergunta3_1,
            pergunta3_2: pergunta3_2,
            pergunta3_3: pergunta3_3,
            pergunta4_1: pergunta4_1,
            pergunta4_2: pergunta4_2,
            pergunta4_3: pergunta4_3,
            pergunta4_4: pergunta4_4,
            pergunta5_1: pergunta5_1,
            pergunta5_2: pergunta5_2,
            pergunta5_3: pergunta5_3,
            pergunta5_4: pergunta5_4,
            pergunta6_1: pergunta6_1,
            pergunta6_2: pergunta6_2,
            pergunta6_3: pergunta6_3,
            pergunta7_1: pergunta7_1,
            pergunta7_2: pergunta7_2,
            pergunta7_3: pergunta7_3,
            pergunta7_4: pergunta7_4,
            pergunta7_5: pergunta7_5,
            pergunta8_1: pergunta8_1,
            pergunta8_2: pergunta8_2,
            pergunta8_3: pergunta8_3,
            pergunta8_4: pergunta8_4,
            pergunta9_1: pergunta9_1,
            pergunta9_2: pergunta9_2,
            pergunta9_3: pergunta9_3,
            pergunta9_4: pergunta9_4,
            q1_1: q1_1,
            q1_2: q1_2,
            q1_3: q1_3,
            q1_4: q1_4,
            q1_5: q1_5,
            q2_1: q2_1,
            q2_2: q2_2,
            q2_3: q2_3,
            q2_4: q2_4,
            q2_5: q2_5,
            q3_1: q3_1,
            q3_2: q3_2,
            q3_3: q3_3,
            q4_1: q4_1,
            q4_2: q4_2,
            q4_3: q4_3,
            q4_4: q4_4,
            q5_1: q5_1,
            q5_2: q5_2,
            q5_3: q5_3,
            q5_4: q5_4,
            q6_1: q6_1,
            q6_2: q6_2,
            q6_3: q6_3,
            q7_1: q7_1,
            q7_2: q7_2,
            q7_3: q7_3,
            q7_4: q7_4,
            q7_5: q7_5,
            q8_1: q8_1,
            q8_2: q8_2,
            q8_3: q8_3,
            q8_4: q8_4,
            q9_1: q9_1,
            q9_2: q9_2,
            q9_3: q9_3,
            q9_4: q9_4
        };
//        console.log(dados);
        // Envia os dados via AJAX usando fetch
        fetch('resp.php', {
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
