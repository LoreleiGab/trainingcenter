<?php
namespace TrainingCenter\Controllers\Atleta;

use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;

class AtletaController extends MainModel
{
    /**
     * <p>Cadastro de percepção do esforço</p>
     * @param $dados
     * @return string
     */
    public function cadastrarEsforco($dados):string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("efforts", $dados);
        if ($insert->rowCount() >= 1) {
            $id = $this->connection()->lastInsertId();
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Esforço cadastrado!',
                'texto' => 'Dados cadastrados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "atleta/esforco_cadastro&id=".MainModel::encryption($id)
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
     * <p>Edição de percepção do esforço</p>
     * @param $dados
     * @param $id
     * @return string
     */
    public function editarEsforco($dados, $id):string
    {
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $id = MainModel::decryption($id);
        $update = DbModel::update('efforts', $dados, $id);

        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Esforço alterado com sucesso!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "atleta/esforco_cadastro&id=".MainModel::encryption($id)
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
     * <p>Lista para percepção do esforço</p>
     * @return array|false
     */
    public function listarEsforco()
    {
        return DbModel::lista('efforts');
    }

    /**
     * <p>Recupera um percepção do esforço através do id</p>
     * @param int|string $id
     * @return false|mixed|object
     */
    public function recuperarEsforco($id)
    {
        return $this->getInfo('efforts', $this->decryption($id))->fetchObject();
    }
    /**
     * <p>Apagar percepção do esforço</p>
     * @param $id
     * @return string
     */
    public function apagarEsforco($id):string
    {
        $apagar = $this->apaga("efforts",$id);
        if ($apagar->rowCount() >= 1){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Esforço apagado!',
                'texto' => 'Dados alterados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'atleta/esforco_lista'
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
