<?php
namespace TrainingCenter\Controllers\Pessoa;

use TrainingCenter\Models\Pessoa\PessoaModel;
use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;
use PDO;

class PessoaController extends PessoaModel
{
    /**
     * <p>Cadastro de funcionário</p>
     * @return string
     */
    public function cadastrar():string
    {
        $dadosLimpos = PessoaModel::limparStringPF($_POST);

        /* cadastro */
        $insere = DbModel::insert('pessoas', $dadosLimpos['pf']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if(isset($dadosLimpos['bc'])){
                if (count($dadosLimpos['bc']) > 0) {
                    $dadosLimpos['bc']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_bancos', $dadosLimpos['bc']);
                }
            }

            if (isset($dadosLimpos['cn'])) {
                if (count($dadosLimpos['cn']) > 0) {
                    $dadosLimpos['cn']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_cnhs', $dadosLimpos['cn']);
                }
            }

            if (isset($dadosLimpos['co'])) {
                if (count($dadosLimpos['co']) > 0) {
                    $dadosLimpos['co']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_conjuges', $dadosLimpos['co']);
                }
            }

            if (isset($dadosLimpos['cr'])){
                if (count($dadosLimpos['cr']) > 0) {
                    $dadosLimpos['cr']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_cursos', $dadosLimpos['cr']);
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $dadosLimpos['en']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_enderecos', $dadosLimpos['en']);
                }
            }

            if (isset($dadosLimpos['ma'])){
                if (count($dadosLimpos['ma']) > 0) {
                    $dadosLimpos['ma']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_maes', $dadosLimpos['ma']);
                }
            }

            if (isset($dadosLimpos['pa'])){
                if (count($dadosLimpos['pa']) > 0) {
                    $dadosLimpos['pa']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_pais', $dadosLimpos['pa']);
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['pessoa_id'] = $id;
                    DbModel::insert('pessoa_telefones', $telefone);
                }
            }

            if (isset($dadosLimpos['ti'])){
                if (count($dadosLimpos['ti']) > 0) {
                    $dadosLimpos['ti']['pessoa_id'] = $id;
                    DbModel::insert('pessoa_titulo_eleitores', $dadosLimpos['ti']);
                }
            }

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'pessoa/funcionario_cadastro&id=' . parent::encryption($id)
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'pessoa/funcionario_cadastro'
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Edição de funcionário</p>
     * @param $id
     * @return string
     */
    public function editar($id):string
    {
        $idDecryp = MainModel::decryption($id);

        $dadosLimpos = PessoaModel::limparStringPF($_POST);

        $edita = DbModel::update('pessoas', $dadosLimpos['pf'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['bc'])) {
                if (count($dadosLimpos['bc']) > 0) {
                    $banco_existe = DbModel::consultaSimples("SELECT * FROM pessoa_bancos WHERE pessoa_id = '$idDecryp'");
                    if ($banco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pessoa_bancos', $dadosLimpos['bc'], "pessoa_id", $idDecryp);
                    } else {
                        $dadosLimpos['bc']['pessoa_id'] = $idDecryp;
                        DbModel::insert('pessoa_bancos', $dadosLimpos['bc']);
                    }
                }
            }

            if (isset($dadosLimpos['cn'])) {
                if (isset($dadosLimpos['cn'])) {
                    if (count($dadosLimpos['cn']) > 0) {
                        $cnh_existe = DbModel::consultaSimples("SELECT * FROM pessoa_cnhs WHERE pessoa_id = '$idDecryp'");
                        if ($cnh_existe->rowCount() > 0) {
                            DbModel::updateEspecial('pessoa_cnhs', $dadosLimpos['cn'], "pessoa_id", $idDecryp);
                        } else {
                            $dadosLimpos['cn']['pessoa_id'] = $idDecryp;
                            DbModel::insert('pessoa_cnhs', $dadosLimpos['cn']);
                        }
                    }
                }
            }

            if (isset($dadosLimpos['co'])) {
                if (isset($dadosLimpos['co'])) {
                    if (count($dadosLimpos['co']) > 0) {
                        $conjuge_existe = DbModel::consultaSimples("SELECT * FROM pessoa_conjuges WHERE pessoa_id = '$idDecryp'");
                        if ($conjuge_existe->rowCount() > 0) {
                            DbModel::updateEspecial('pessoa_conjuges', $dadosLimpos['co'], "pessoa_id", $idDecryp);
                        } else {
                            $dadosLimpos['co']['pessoa_id'] = $idDecryp;
                            DbModel::insert('pessoa_conjuges', $dadosLimpos['co']);
                        }
                    }
                }
            }

            if (isset($dadosLimpos['cr'])) {
                if (isset($dadosLimpos['cr'])) {
                    if (count($dadosLimpos['cr']) > 0) {
                        $curso_existe = DbModel::consultaSimples("SELECT * FROM pessoa_cursos WHERE pessoa_id = '$idDecryp'");
                        if ($curso_existe->rowCount() > 0) {
                            DbModel::updateEspecial('pessoa_cursos', $dadosLimpos['cr'], "pessoa_id", $idDecryp);
                        } else {
                            $dadosLimpos['cr']['pessoa_id'] = $idDecryp;
                            DbModel::insert('pessoa_cursos', $dadosLimpos['co']);
                        }
                    }
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM pessoa_enderecos WHERE pessoa_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pessoa_enderecos', $dadosLimpos['en'], "pessoa_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['pessoa_id'] = $idDecryp;
                        DbModel::insert('pessoa_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (isset($dadosLimpos['ma'])) {
                if (count($dadosLimpos['ma']) > 0) {
                    $mae_existe = DbModel::consultaSimples("SELECT * FROM pessoa_maes WHERE pessoa_id = '$idDecryp'");
                    if ($mae_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pessoa_maes', $dadosLimpos['ma'], "pessoa_id", $idDecryp);
                    } else {
                        $dadosLimpos['ma']['pessoa_id'] = $idDecryp;
                        DbModel::insert('pessoa_maes', $dadosLimpos['ma']);
                    }
                }
            }

            if (isset($dadosLimpos['pa'])) {
                if (count($dadosLimpos['pa']) > 0) {
                    $pai_existe = DbModel::consultaSimples("SELECT * FROM pessoa_pais WHERE pessoa_id = '$idDecryp'");
                    if ($pai_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pessoa_pais', $dadosLimpos['pa'], "pessoa_id", $idDecryp);
                    } else {
                        $dadosLimpos['pa']['pessoa_id'] = $idDecryp;
                        DbModel::insert('pessoa_pais', $dadosLimpos['pa']);
                    }
                }
            }

            if (isset($dadosLimpos['telefones'])){
                if (count($dadosLimpos['telefones'])>0){
                    $telefone_existe = DbModel::consultaSimples("SELECT * FROM pessoa_telefones WHERE pessoa_id = '$idDecryp'");

                    if ($telefone_existe->rowCount()>0){
                        DbModel::deleteEspecial('pessoa_telefones', "pessoa_id",$idDecryp);
                    }
                    foreach ($dadosLimpos['telefones'] as $telefone){
                        $telefone['pessoa_id'] = $idDecryp;
                        DbModel::insert('pessoa_telefones', $telefone);
                    }
                }
            }

            if (isset($dadosLimpos['ti'])) {
                if (count($dadosLimpos['ti']) > 0) {
                    $titulo_eleitor_existe = DbModel::consultaSimples("SELECT * FROM pessoa_titulo_eleitores WHERE pessoa_id = '$idDecryp'");
                    if ($titulo_eleitor_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pessoa_titulo_eleitores', $dadosLimpos['ti'], "pessoa_id", $idDecryp);
                    } else {
                        $dadosLimpos['ti']['pessoa_id'] = $idDecryp;
                        DbModel::insert('pessoa_titulo_eleitores', $dadosLimpos['ti']);
                    }
                }
            }

            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'pessoa/funcionario_cadastro&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'pessoa/funcionario_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Recupera os dados do funcionário</p>
     * @param $id
     * @return object
     */
    public function recuperar($id): object
    {
        $id = $this->decryption($id);
        $pessoal = parent::getPessoa($id);
        $banco = parent::getBancoPessoa($id);
        $cnh = parent::getCnhPessoa($id);
        $endereco = parent::getEnderecoPessoa($id);
        $telefones = parent::getTelefonePessoa($id);
        $titulo = parent::getTituloPessoa($id);

        $pessoa = array_merge((array)$pessoal, (array)$banco, (array)$cnh, (array)$endereco, (array)$telefones, (array)$titulo);

        return (object)$pessoa;
    }

    /**
     * <p>Lista para os funcionários</p>
     * @param int $status_id <p>1-ativo | 2-inativo | 3-cedido</p>
     * @return array|false
     */
    public function listar(int $status_id)
    {
        return parent::consultaSimples("
            SELECT p.id, p.nome_completo, concat(p.rf, v.rf_digito, v.rf_vinculo) as rf, d.departamento, s.supervisao
            FROM pessoas p 
            INNER JOIN vinculos v on p.id = v.pessoa_id AND v.atual = 1
            LEFT JOIN departamentos d on v.departamento_id = d.id
            LEFT JOIN supervisoes s on v.supervisao_id = s.id
            WHERE status_id = '$status_id'")->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * <p>Cria uma lista personalizada com os aniversariantes</p>
     * @param bool $now <p>True para exibir os aniversariantes do dia</p>
     * @return array|false
     */
    public function listarAniversariantes(bool $now = false)
    {
        if ($now){
            $hoje = date('m/d');
            $where = "AND DATE_FORMAT(data_nascimento, '%m/%d') = '$hoje'";
        } else{
            $where = "";
        }
        return $this->consultaSimples("
            SELECT p.id, p.nome_completo, p.email, data_nascimento, d.departamento, s.supervisao 
            FROM pessoas p 
            INNER JOIN vinculos v on p.id = v.pessoa_id AND v.atual = 1
            LEFT JOIN departamentos d on v.departamento_id = d.id
            LEFT JOIN supervisoes s on v.supervisao_id = s.id
            WHERE data_nascimento != '' AND status_id = 1 $where
            ORDER BY DATE_FORMAT(data_nascimento, '%m/%d')
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * <p>Busca RF</p>
     * @param $rf
     * @return false|mixed|object
     */
    public function getRf($rf)
    {
        return $this->consultaSimples("SELECT id FROM pessoas WHERE rf = '$rf'")->fetchObject();
    }

}