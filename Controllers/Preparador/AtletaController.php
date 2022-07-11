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
        return $this->consultaSimples("
            SELECT a.id, a.nome_completo, a.apelido, a.data_nascimento, t.equipe, m.modalidade, p.posicao, m2.membro_dominante, u.id as user_id
            FROM athletes a
            LEFT JOIN teams t on t.id = a.team_id
            LEFT JOIN modalities m on a.modality_id = m.id
            LEFT JOIN positions p on a.position_id = p.id
            LEFT JOIN members m2 on a.member_id = m2.id
            INNER JOIN users u on a.user_id = u.id
        ")->fetchAll(\PDO::FETCH_OBJ);
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

    public function geraOpcaoNovoAtleta($selected = "")
    {
        $consulta = $this->consultaSimples("
            SELECT u.id, u.apelido
            FROM users u 
            LEFT JOIN athletes a on u.id = a.user_id
            WHERE a.id IS NULL ORDER BY u.apelido
        ");
        if ($consulta->rowCount() >= 1) {
            $options = $consulta->fetchAll(\PDO::FETCH_NUM);
            foreach ($options as $option) {
                if ($option[0] == $selected) {
                    echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
                } else {
                    echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
                }
            }
        }
    }
}
