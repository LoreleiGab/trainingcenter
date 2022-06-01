<?php
namespace TrainingCenter\Models\Pessoa;

use TrainingCenter\Models\MainModel;
use PDO;

class PessoaModel extends MainModel
{
    /**
     * <p>Faz limpeza de código malicioso ao cadastrar pessoa</p>
     * @param $dados
     * @return array
     */
    protected function limparStringPF($dados):array
    {
        unset($dados['_method']);
        unset($dados['pagina']);

        foreach ($dados as $campo => $post) {
            $dig = explode("_", $campo)[0];
            if (!empty($dados[$campo]) || ($dig == "pf")) {
                switch ($dig) {
                    case "pf":
                        $campo = substr($campo, 3);
                        $dadosLimpos['pf'][$campo] = MainModel::limparString($post);
                        break;
                    case "bc":
                        $campo = substr($campo, 3);
                        $dadosLimpos['bc'][$campo] = MainModel::limparString($post);
                        break;
                    case "cn":
                        $campo = substr($campo, 3);
                        $dadosLimpos['cn'][$campo] = MainModel::limparString($post);
                        break;
                    case "co":
                        $campo = substr($campo, 3);
                        $dadosLimpos['co'][$campo] = MainModel::limparString($post);
                        break;
                    case "cr":
                        $campo = substr($campo, 3);
                        $dadosLimpos['cr'][$campo] = MainModel::limparString($post);
                        break;
                    case "en":
                        $campo = substr($campo, 3);
                        $dadosLimpos['en'][$campo] = MainModel::limparString($post);
                        break;
                    case "ma":
                        $campo = substr($campo, 3);
                        $dadosLimpos['ma'][$campo] = MainModel::limparString($post);
                        break;
                    case "pa":
                        $campo = substr($campo, 3);
                        $dadosLimpos['pa'][$campo] = MainModel::limparString($post);
                        break;
                    case "te":
                        if ($dados[$campo] != '') {
                            $dadosLimpos['telefones'][$campo]['telefones'] = MainModel::limparString($post);
                        }
                        break;
                    case "ti":
                        $campo = substr($campo, 3);
                        $dadosLimpos['ti'][$campo] = MainModel::limparString($post);
                        break;
                }
            }
        }
        return $dadosLimpos;
    }

    /**
     * <p>Recupera os dados de uma pessoa na tabela pessoas</p>
     * @param $id
     * @return mixed
     */
    protected function getPessoa($id)
    {
        $id = parent::decryption($id);
        return parent::consultaSimples("
            SELECT p.*, g.genero, n.nacionalidade, ec.estado_civil, gi.grau_instrucao, c.conjuge_nome, pc2.curso_id, cr.curso, pm.nome_mae, pp.nome_pai, s.status
            FROM pessoas p
            LEFT JOIN generos g on p.genero_id = g.id
            LEFT JOIN nacionalidades n on p.nacionalidade_id = n.id
            LEFT JOIN estado_civis ec on p.estado_civil_id = ec.id
            LEFT JOIN grau_instrucoes gi on p.grau_instrucao_id = gi.id
            LEFT JOIN pessoa_conjuges c on p.id = c.pessoa_id
            LEFT JOIN pessoa_cursos pc2 on p.id = pc2.pessoa_id
            INNER JOIN cursos cr on pc2.curso_id = cr.id AND cr.publicado = 1
            LEFT JOIN pessoa_maes pm on p.id = pm.pessoa_id
            LEFT JOIN pessoa_pais pp on p.id = pp.pessoa_id
            LEFT JOIN status s on p.status_id = s.id
            WHERE p.id = '$id'
        ")->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * <p>Recupera telefones da pessoa</p>
     * @param int $pessoa_id
     * @return array
     */
    protected function getTelefonePessoa(int $pessoa_id)
    {
        $telefones = $this->consultaSimples("SELECT telefones FROM pessoa_telefones WHERE pessoa_id = '$pessoa_id'")->fetchAll(PDO::FETCH_ASSOC);

        $pessoa=[];
        foreach ($telefones as $key => $telefone) {
            $pessoa['telefones']['tel_' . $key] = $telefone['telefones'];
        }
        return $pessoa;
    }

    protected function getEnderecoPessoa(int $pessoa_id)
    {
        return $this->consultaSimples("SELECT logradouro, numero, complemento, bairro, cidade, uf, cep FROM pessoa_enderecos pe WHERE pessoa_id = '$pessoa_id'")->fetchObject();
    }

    protected function getBancoPessoa(int $pessoa_id)
    {
        return $this->consultaSimples("
            SELECT pb.banco_codigo, b.banco, pb.agencia, pb.conta 
            FROM pessoa_bancos pb
            INNER JOIN bancos b on pb.banco_codigo = b.codigo
            WHERE pessoa_id = '$pessoa_id'
        ")->fetchObject();
    }

    protected function getCnhPessoa(int $pessoa_id)
    {
        return $this->consultaSimples("SELECT numero as cnh_numero, categoria, validade FROM pessoa_cnhs WHERE pessoa_id = '$pessoa_id'")->fetchObject();
    }

    protected function getTituloPessoa(int $pessoa_id)
    {
        return $this->consultaSimples("SELECT numero as titulo_numero, secao, zona FROM pessoa_titulo_eleitores WHERE pessoa_id = '$pessoa_id'")->fetchObject();
    }
}