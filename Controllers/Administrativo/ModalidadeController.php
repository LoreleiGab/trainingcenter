<?php
namespace TrainingCenter\Controllers\Administrativo;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class ModalidadeController extends MainModel
{
    /**
     * <p>Cadastro de cargo</p>
     * @param $dados
     * @return string
     */
    public function cadastrarModalidade($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("modalities", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Modalidade cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/modalidade_cadastro&id=".MainModel::encryption($id)
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
     * <p>Edição de modalidade</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarModalidade($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('modalities', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Modalidade alterada com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/modalidade_cadastro&id=".MainModel::encryption($id)
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
     * <p>Lista para modalidade</p>
     * @return array|false
     */
    public function listarModalidade()
    {
        return DbModel::lista('modalities');
    }

    /**
     * <p>Recupera um modalidade através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarModalidade($id)
    {
        return $this->getInfo('modalities', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar modalidade</p>
     * @param $id
     * @return string
     */
    public function apagarModalidade($id):string
    {
        $apagar = $this->apaga("modalities",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Modalidade apagada!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/modalidade_lista'
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
