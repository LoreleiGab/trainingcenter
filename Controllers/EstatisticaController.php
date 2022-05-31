<?php

namespace Gesp\Controllers;

use Gesp\Controllers\Pessoa\PessoaController;

class EstatisticaController extends Pessoa\PessoaController
{
    /**
     * <p>Retorna a quantidade de funcionários de cada status</p>
     * @param int $status_id
     * @return mixed
     */
    public function qtdeFuncionarioStatus(int $status_id)
    {
        return $this->consultaSimples("
            SELECT COUNT(p.id)
            FROM pessoas p
            WHERE status_id = '$status_id'
        ")->fetchColumn();
    }

    /**
     * <p>Retorna a quantidade de funcionários ativos por departamento</p>
     * @return array|null
     */
    public function qtdeFuncionarioDepartamento(): ?array
    {
        return parent::consultaSimples("
            SELECT d.id, count(d.id) as quantidade, d.departamento
            FROM pessoas p 
            INNER JOIN vinculos v on p.id = v.pessoa_id AND v.atual = 1
            LEFT JOIN departamentos d on v.departamento_id = d.id
            WHERE status_id = 1
            GROUP BY departamento
        ")->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * <p>Retorna a quantidade de funcionários ativos por supervisao</p>
     * @return array|null
     */
    public function qtdeFuncionarioSupervisao($departamento_id = false): ?array
    {
        if ($departamento_id){
            $where = "AND s.departamento_id = '$departamento_id'";
        } else{
            $where = "";
        }
        return parent::consultaSimples("
            SELECT count(s.id) as quantidade, s.supervisao
            FROM pessoas p 
            INNER JOIN vinculos v on p.id = v.pessoa_id AND v.atual = 1
            LEFT JOIN supervisoes s on v.supervisao_id = s.id
            WHERE status_id = 1 $where
            GROUP BY supervisao
        ")->fetchAll(\PDO::FETCH_OBJ);
    }
}