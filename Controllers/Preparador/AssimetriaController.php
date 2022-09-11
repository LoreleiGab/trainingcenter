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
        return DbModel::lista('assimetrys');
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
