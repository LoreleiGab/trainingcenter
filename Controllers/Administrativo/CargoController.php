<?php
namespace TrainingCenter\Controllers\Administrativo;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class CargoController extends MainModel
{
    /**
     * <p>Cadastro de cargo</p>
     * @param $dados
     * @return string
     */
    public function cadastrarCargo($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("cargos", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/cargo_cadastro&id=".MainModel::encryption($id)
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
     * <p>Edição de cargo</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarCargo($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('cargos', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo alterado com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "administrativo/cargo_cadastro&id=".MainModel::encryption($id)
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
     * <p>Lista para cargo</p>
     * @return array|false
     */
    public function listarCargo()
    {
        return DbModel::listaPublicado('cargos');
    }

    /**
     * <p>Recupera um cargo através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarCargo($id)
    {
        return $this->getInfo('cargos', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar cargo</p>
     * @param $id
     * @return string
     */
    public function apagarCargo($id):string
    {
        $apagar = $this->apaga("cargos",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cargo apagado!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/cargo_lista'
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
