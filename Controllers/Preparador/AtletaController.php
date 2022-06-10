<?php
namespace TrainingCenter\Controllers\Preparador;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class AtletaController extends MainModel
{
    /**
     * <p>Cadastro de atleta</p>
     * @param $dados
     * @return string
     */
    public function cadastrarAtleta($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("athletes", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Atleta cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "preparador/atleta_cadastro&id=".MainModel::encryption($id)
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
     * <p>Edição de atleta</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarAtleta($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('athletes', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Atleta alterado com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "preparador/atleta_cadastro&id=".MainModel::encryption($id)
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
     * <p>Lista para atleta</p>
     * @return array|false
     */
    public function listarAtleta()
    {
        return DbModel::lista('athletes');
    }

    /**
     * <p>Recupera um atleta através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarAtleta($id)
    {
        return $this->getInfo('athletes', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar atleta</p>
     * @param $id
     * @return string
     */
    public function apagarAtleta($id):string
    {
        $apagar = $this->apaga("athletes",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Atleta apagado!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'preparador/atleta_lista'
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
