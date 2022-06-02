<?php
namespace TrainingCenter\Controllers\Administrativo;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class LocalDorController extends MainModel
{
    /**
     * <p>Cadastro de tipo de grupo</p>
     * @param $dados
     * @return string
     */
    public function cadastrarLocalDor($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("sitepains", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Local da dor cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/local_dor_cadastro&id=".MainModel::encryption($id)
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
     * <p>Edição de tipo de grupo</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarLocalDor($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('sitepains', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Local da dor alterado com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/local_dor_cadastro&id=".MainModel::encryption($id)
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
     * <p>Lista para tipo de grupo</p>
     * @return array|false
     */
    public function listarLocalDor()
    {
        return DbModel::lista('sitepains');
    }

    /**
     * <p>Recupera um membro através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarLocalDor($id)
    {
        return $this->getInfo('sitepains', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar tipo de grupo</p>
     * @param $id
     * @return string
     */
    public function apagarLocalDor($id):string
    {
        $apagar = $this->apaga("sitepains",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Local da dor apagado!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/local_dor_lista'
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
