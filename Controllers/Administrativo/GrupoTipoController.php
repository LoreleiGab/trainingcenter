<?php
namespace TrainingCenter\Controllers\Administrativo;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class GrupoTipoController extends MainModel
{
    /**
     * <p>Cadastro de tipo de grupo</p>
     * @param $dados
     * @return string
     */
    public function cadastrarGrupoTipo($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("group_types", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Tipo de Grupo cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/grupo_tipo_cadastro&id=".MainModel::encryption($id)
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
    public function editarGrupoTipo($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('group_types', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Tipo de Grupo alterado com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/grupo_tipo_cadastro&id=".MainModel::encryption($id)
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
    public function listarGrupoTipo()
    {
        return DbModel::lista('group_types');
    }

    /**
     * <p>Recupera um membro através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarGrupoTipo($id)
    {
        return $this->getInfo('group_types', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar tipo de grupo</p>
     * @param $id
     * @return string
     */
    public function apagarGrupoTipo($id):string
    {
        $apagar = $this->apaga("group_types",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Tipo de Grupo apagado!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/grupo_tipo_lista'
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
