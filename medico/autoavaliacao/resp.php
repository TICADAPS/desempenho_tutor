<?php
session_start();
require __DIR__ . "/../../source/autoload.php";
// Definir o tipo de conteúdo como JSON
header('Content-Type: application/json');
// Receber o JSON enviado pelo JavaScript através de fetch
$data = json_decode(file_get_contents('php://input'), true);
// Verificar se os dados foram recebidos corretamente
if (isset($data['q1_1']) && isset($data['q1_2']) && isset($data['q1_3']) && isset($data['q1_4'])
    && isset($data['q1_5']) && isset($data['q2_1']) && isset($data['q2_2']) && isset($data['q2_3'])
    && isset($data['q2_4']) && isset($data['q2_5']) && isset($data['q3_1']) && isset($data['q3_2'])
    && isset($data['q3_3']) && isset($data['q4_1']) && isset($data['q4_2']) && isset($data['q4_3'])
    && isset($data['q4_4']) && isset($data['q5_1']) && isset($data['q5_2']) && isset($data['q5_3'])
    && isset($data['q5_4']) && isset($data['q6_1']) && isset($data['q6_2']) && isset($data['q6_3'])
    && isset($data['q7_1']) && isset($data['q7_2']) && isset($data['q7_3']) && isset($data['q7_4'])
    && isset($data['q7_5']) && isset($data['q8_1']) && isset($data['q8_2']) && isset($data['q8_3'])
    && isset($data['q8_4']) && isset($data['q9_1']) && isset($data['q9_2']) && isset($data['q9_3'])
    && isset($data['q9_4'])) {
    $cpf = $data['cpf'];
    $ibge = $data['ibge'];
    $cnes = $data['cnes'];
    $ine = $data['ine'];
    $ano = $data['ano'];
    $ciclo = $data['ciclo'];
    $id = $data['idcp'];
    $p1_1 = $data['pergunta1_1'];
    $p1_2 = $data['pergunta1_2'];
    $p1_3 = $data['pergunta1_3'];
    $p1_4 = $data['pergunta1_4'];
    $p1_5 = $data['pergunta1_5'];
    $p2_1 = $data['pergunta2_1'];
    $p2_2 = $data['pergunta2_2'];
    $p2_3 = $data['pergunta2_3'];
    $p2_4 = $data['pergunta2_4'];
    $p2_5 = $data['pergunta2_5'];
    $p3_1 = $data['pergunta3_1'];
    $p3_2 = $data['pergunta3_2'];
    $p3_3 = $data['pergunta3_3'];
    $p4_1 = $data['pergunta4_1'];
    $p4_2 = $data['pergunta4_2'];
    $p4_3 = $data['pergunta4_3'];
    $p4_4 = $data['pergunta4_4'];
    $p5_1 = $data['pergunta5_1'];
    $p5_2 = $data['pergunta5_2'];
    $p5_3 = $data['pergunta5_3'];
    $p5_4 = $data['pergunta5_4'];
    $p6_1 = $data['pergunta6_1'];
    $p6_2 = $data['pergunta6_2'];
    $p6_3 = $data['pergunta6_3'];
    $p7_1 = $data['pergunta7_1'];
    $p7_2 = $data['pergunta7_2'];
    $p7_3 = $data['pergunta7_3'];
    $p7_4 = $data['pergunta7_4'];
    $p7_5 = $data['pergunta7_5'];
    $p8_1 = $data['pergunta8_1'];
    $p8_2 = $data['pergunta8_2'];
    $p8_3 = $data['pergunta8_3'];
    $p8_4 = $data['pergunta8_4'];
    $p9_1 = $data['pergunta9_1'];
    $p9_2 = $data['pergunta9_2'];
    $p9_3 = $data['pergunta9_3'];
    $p9_4 = $data['pergunta9_4'];
    $q1_1 = $data['q1_1'];
    $q1_2 = $data['q1_2'];
    $q1_3 = $data['q1_3'];
    $q1_4 = $data['q1_4'];
    $q1_5 = $data['q1_5'];
    $q2_1 = $data['q2_1'];
    $q2_2 = $data['q2_2'];
    $q2_3 = $data['q2_3'];
    $q2_4 = $data['q2_4'];
    $q2_5 = $data['q2_5'];
    $q3_1 = $data['q3_1'];
    $q3_2 = $data['q3_2'];
    $q3_3 = $data['q3_3'];
    $q4_1 = $data['q4_1'];
    $q4_2 = $data['q4_2'];
    $q4_3 = $data['q4_3'];
    $q4_4 = $data['q4_4'];
    $q5_1 = $data['q5_1'];
    $q5_2 = $data['q5_2'];
    $q5_3 = $data['q5_3'];
    $q5_4 = $data['q5_4'];
    $q6_1 = $data['q6_1'];
    $q6_2 = $data['q6_2'];
    $q6_3 = $data['q6_3'];
    $q7_1 = $data['q7_1'];
    $q7_2 = $data['q7_2'];
    $q7_3 = $data['q7_3'];
    $q7_4 = $data['q7_4'];
    $q7_5 = $data['q7_5'];
    $q8_1 = $data['q8_1'];
    $q8_2 = $data['q8_2'];
    $q8_3 = $data['q8_3'];
    $q8_4 = $data['q8_4'];
    $q9_1 = $data['q9_1'];
    $q9_2 = $data['q9_2'];
    $q9_3 = $data['q9_3'];
    $q9_4 = $data['q9_4'];

    //envio para o bd
    $cp = (new \Source\Models\Competencias_profissionais())->findById($id);
    if($cp !== null){
        $flagenvio = $cp->flagenvio;
        if($flagenvio !== '1'){
            date_default_timezone_set('America/Sao_Paulo');
            $dthrenv = date('Y-m-d H:i:s');
            $cp->p1_1 = $p1_1;
            $cp->p1_2 = $p1_2;
            $cp->p1_3 = $p1_3;
            $cp->p1_4 = $p1_4;
            $cp->p1_5 = $p1_5;
            $cp->p2_1 = $p2_1;
            $cp->p2_2 = $p2_2;
            $cp->p2_3 = $p2_3;
            $cp->p2_4 = $p2_4;
            $cp->p2_5 = $p2_5;
            $cp->p3_1 = $p3_1;
            $cp->p3_2 = $p3_2;
            $cp->p3_3 = $p3_3;
            $cp->p4_1 = $p4_1;
            $cp->p4_2 = $p4_2;
            $cp->p4_3 = $p4_3;
            $cp->p4_4 = $p4_4;
            $cp->p5_1 = $p5_1;
            $cp->p5_2 = $p5_2;
            $cp->p5_3 = $p5_3;
            $cp->p5_4 = $p5_4;
            $cp->p6_1 = $p6_1;
            $cp->p6_2 = $p6_2;
            $cp->p6_3 = $p6_3;
            $cp->p7_1 = $p7_1;
            $cp->p7_2 = $p7_2;
            $cp->p7_3 = $p7_3;
            $cp->p7_4 = $p7_4;
            $cp->p7_5 = $p7_5;
            $cp->p8_1 = $p8_1;
            $cp->p8_2 = $p8_2;
            $cp->p8_3 = $p8_3;
            $cp->p8_4 = $p8_4;
            $cp->p9_1 = $p9_1;
            $cp->p9_2 = $p9_2;
            $cp->p9_3 = $p9_3;
            $cp->p9_4 = $p9_4;
            $cp->r1_1 = $q1_1;
            $cp->r1_2 = $q1_2;
            $cp->r1_3 = $q1_3;
            $cp->r1_4 = $q1_4;
            $cp->r1_5 = $q1_5;
            $cp->r2_1 = $q2_1;
            $cp->r2_2 = $q2_2;
            $cp->r2_3 = $q2_3;
            $cp->r2_4 = $q2_4;
            $cp->r2_5 = $q2_5;
            $cp->r3_1 = $q3_1;
            $cp->r3_2 = $q3_2;
            $cp->r3_3 = $q3_3;
            $cp->r4_1 = $q4_1;
            $cp->r4_2 = $q4_2;
            $cp->r4_3 = $q4_3;
            $cp->r4_4 = $q4_4;
            $cp->r5_1 = $q5_1;
            $cp->r5_2 = $q5_2;
            $cp->r5_3 = $q5_3;
            $cp->r5_4 = $q5_4;
            $cp->r6_1 = $q6_1;
            $cp->r6_2 = $q6_2;
            $cp->r6_3 = $q6_3;
            $cp->r7_1 = $q7_1;
            $cp->r7_2 = $q7_2;
            $cp->r7_3 = $q7_3;
            $cp->r7_4 = $q7_4;
            $cp->r7_5 = $q7_5;
            $cp->r8_1 = $q8_1;
            $cp->r8_2 = $q8_2;
            $cp->r8_3 = $q8_3;
            $cp->r8_4 = $q8_4;
            $cp->r9_1 = $q9_1;
            $cp->r9_2 = $q9_2;
            $cp->r9_3 = $q9_3;
            $cp->r9_4 = $q9_4;
            $cp->dthrenvio = $dthrenv;
            $cp->flagenvio = 1;
            $respcp = $cp->save();
            if($respcp){
                $response = array(
                    'status' => 'sucesso',
                    'message' => "<h6 class='p-2 rounded' style='background-color: #E2EDD9;'><i class='fas fa-chevron-circle-right'></i>&nbsp; Respostas enviadas com sucesso!</h6>"
                );
            }else{
                $response = array(
                    'status' => 'erro',
                    'message' => "<h6 class='p-2 rounded bg-warning'><i class='fas fa-chevron-circle-right'></i>&nbsp; Erro: Falha na comunicação.</h6>"
                );
            }
        }else{
            $response = array(
                'status' => 'erro',
                'message' => "<h6 class='p-2 rounded bg-warning'><i class='fas fa-chevron-circle-right'></i>&nbsp; Erro: As respostas já foram enviadas anteriormente.</h6>"
            );
        }
    }else{
        $response = array(
            'status' => 'erro',
            'message' => "<h6 class='p-2 rounded bg-warning'><i class='fas fa-chevron-circle-right'></i>&nbsp; Usuário não encontrado!</h6>"
        );
    }
} else {
    // Resposta em caso de erro nos dados
    $response = array(
        'status' => 'erro',
        'message' => "<h6 class='p-2 rounded bg-warning'><i class='fas fa-chevron-circle-right'></i>&nbsp; Erro: É obrigatório o preenchimento dos campos.</h6>"
    );
}

// Enviar a resposta como JSON
echo json_encode($response);

