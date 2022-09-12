<?php
namespace TrainingCenter\Controllers\Preparador;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class AssimetriaController extends MainModel
{
    /**
     * <p>Cadastro de assimetria</p>
     * @param $dados
     * @return string
     */
    public function cadastrarAssimetria($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $dados['flex_joelho_direito'] = str_replace(",",".",$dados['flex_joelho_direito']);
        $dados['flex_joelho_esquerdo'] = str_replace(",",".",$dados['flex_joelho_esquerdo']);
        $dados['exten_joelho_direito'] = str_replace(",",".",$dados['exten_joelho_direito']);
        $dados['exten_joelho_esquerdo'] = str_replace(",",".",$dados['exten_joelho_esquerdo']);
        $dados['relacao_joelho_direito'] = str_replace(",",".",$dados['relacao_joelho_direito']);
        $dados['relacaoiq_joelho_esquerdo'] = str_replace(",",".",$dados['relacaoiq_joelho_esquerdo']);

        $insert = DbModel::insert("assimetrys", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Assimetria cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "preparador/assimetria_cadastro&id=".MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Edição de assimetria</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarAssimetria($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);

        $dados['flex_joelho_direito'] = str_replace(",",".",$dados['flex_joelho_direito']);
        $dados['flex_joelho_esquerdo'] = str_replace(",",".",$dados['flex_joelho_esquerdo']);
        $dados['exten_joelho_direito'] = str_replace(",",".",$dados['exten_joelho_direito']);
        $dados['exten_joelho_esquerdo'] = str_replace(",",".",$dados['exten_joelho_esquerdo']);
        $dados['relacao_joelho_direito'] = str_replace(",",".",$dados['relacao_joelho_direito']);
        $dados['relacaoiq_joelho_esquerdo'] = str_replace(",",".",$dados['relacaoiq_joelho_esquerdo']);

        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('assimetrys', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Assimetria alterada com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "preparador/assimetria_cadastro&id=".MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Lista para assimetria</p>
     * @return array|false
     */
    public function listarAssimetria()
    {
        return $this->consultaSimples("
            SELECT a.id, at.nome_completo
            FROM assimetrys a 
            INNER JOIN athletes at on a.athlete_id = at.id
        ")->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * <p>Recupera um assimetria através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarAssimetria($id)
    {
        return $this->getInfo('assimetrys', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar assimetria</p>
     * @param $id
     * @return string
     */
    public function apagarAssimetria($id):string
    {
        $apagar = $this->apaga("assimetrys",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Assimetria apagada!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'preparador/assimetria_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}
