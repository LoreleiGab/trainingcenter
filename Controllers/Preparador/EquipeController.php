<?php
namespace TrainingCenter\Controllers\Preparador;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class EquipeController extends MainModel
{
    /**
     * <p>Cadastro de equipe</p>
     * @param $dados
     * @return string
     */
    public function cadastrarEquipe($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("teams", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Equipe cadastrada!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "preparador/equipe_cadastro&id=".MainModel::encryption($id)
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
     * <p>Edição de equipe</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarEquipe($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('teams', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Equipe alterada com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "preparador/equipe_cadastro&id=".MainModel::encryption($id)
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
     * <p>Lista para equipe</p>
     * @return array|false
     */
    public function listarEquipe()
    {
        return DbModel::lista('teams');
    }

    /**
     * <p>Recupera um equipe através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarEquipe($id)
    {
        return $this->getInfo('teams', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar equipe</p>
     * @param $id
     * @return string
     */
    public function apagarEquipe($id):string
    {
        $apagar = $this->apaga("teams",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Equipe apagada!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'preparador/equipe_lista'
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
