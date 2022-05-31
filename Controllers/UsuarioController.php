<?php
namespace Gesp\Controllers;

use Gesp\Models\UsuarioModel;
use Gesp\Models\MainModel;
use Gesp\Models\DbModel;
use PDO;

class UsuarioController extends UsuarioModel
{

    public function iniciaSessao($modulo = false, $edital = null) {
        $email = MainModel::limparString($_POST['usuario']);
        $senha = MainModel::limparString($_POST['senha']);
        $senha = MainModel::encryption($senha);

        $dadosLogin = [
            'usuario' => $email,
            'senha' => $senha
        ];

        $consultaUsuario = UsuarioModel::getUsuario($dadosLogin);

        if ($consultaUsuario->rowCount() == 1) {
            $usuario = $consultaUsuario->fetch(PDO::FETCH_ASSOC);

            $dados['ultimo_acesso'] = date('Y-m-d H:i:s');
            DbModel::updateCondicional("usuarios", $dados,"pessoa_id = '{$usuario['pessoa_id']}'");

            session_start(['name' => 'gesp']);
            $_SESSION['login_g'] = $usuario['usuario'];
            $_SESSION['usuario_id_g'] = $usuario['pessoa_id'];
            $_SESSION['nome_g'] = $usuario['nome_completo'];
            $_SESSION['acesso_g'] = $usuario['nivel_acesso_id'];

            MainModel::gravarLog('Fez Login');

            if (!$modulo) {
                return $urlLocation = "<script> window.location='inicio/inicio' </script>";
            } else {
                if ($modulo == 8) {
                    $_SESSION['edital_s'] = $edital;
                    return $urlLocation = "<script> window.location='fomentos/inicio&modulo=$modulo' </script>";
                }
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Usuário / Senha incorreto',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function forcarFimSessao() {
        session_destroy();
        return header("Location: ".SERVERURL);
    }

    /* cadastra */
    public function cadastrar($dados): string
    {
        unset($dados['_method']);
        $dados = MainModel::limpaPost($dados);

        $insert = DbModel::insert("usuarios", $dados);
        if ($insert->rowCount() >= 1) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário Cadastrado!',
                'texto' => 'Senha inicial Gesp@2022',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuario_ativo_lista'
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

    public function remover($pessoa_id){

        $pessoa_id = $this->decryption($pessoa_id);;
        $apagaUsuario = $this->apagaEspecial('usuarios', 'pessoa_id', $pessoa_id);

        if ($apagaUsuario) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Remover Usuário',
                'texto' => 'Usuário Removido com Sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuario_ativo_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao apagar!',
                'tipo' => 'error',
            ];
        }
        return $this->sweetAlert($alerta);
    }

    /* edita */
    public function editar($dados, $pessoa_id){

        unset($dados['_method']);
        unset($dados['pessoa_id']);
        $pessoa_id = MainModel::decryption($pessoa_id);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::updateEspecial('usuarios', $dados, "pessoa_id", $pessoa_id);

        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => 'Informações alteradas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuario_ativo_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'inicio/edita'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Função para trocar a senha do usuário para Gesp@2022</p>
     * @param int|string $pessoa_id
     * @return string
     */
    public function trocarSenha($pessoa_id): string
    {
        $pessoa_id = MainModel::decryption($pessoa_id);
        $dados['senha'] = MainModel::encryption('Gesp@2022');
        $troca = DbModel::updateEspecial('usuarios', $dados, "pessoa_id", $pessoa_id);
        if ($troca->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => 'Senha alterada para Gesp@2022',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuario_cadastro&id=' . MainModel::decryption($pessoa_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperarUsuario($id) {

        $id = MainModel::decryption($id);
        return $this->consultaSimples("
            SELECT u.pessoa_id, pe.nome_completo, u.usuario, u.nivel_acesso_id, u.senha
            FROM usuarios u 
            INNER JOIN pessoas pe on u.pessoa_id = pe.id
            WHERE u.pessoa_id = '$id'")->fetchObject();
    }

    public function recuperaEmail($email){
        return UsuarioModel::getExisteEmail($email);
    }

    /**
     * <p>Lista os usuários do sistema ativo ou inativo</p>
     * @param int $publicado <p>0-inativo | 1-ativo</p>
     * @return array|false
     */
    public function listaUsuarios(int $publicado)
    {
        return DbModel::consultaSimples("
            SELECT u.pessoa_id, pe.nome_completo, u.usuario, pe.rg, pe.email, pt.telefones 
             FROM pessoas pe
             INNER JOIN usuarios u on u.pessoa_id = pe.id
             LEFT JOIN pessoa_telefones pt on pt.pessoa_id = pe.id
             WHERE u.publicado = '$publicado'
        ")->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * <p>Reativar usuários apagados</p>
     * @param int|string $pessoa_id
     * @return string
     */
    public function reativarUsuario($pessoa_id): string
    {
        $pessoa_id = MainModel::decryption($pessoa_id);
        $dados['publicado'] = 1;
        $reativa = DbModel::updateEspecial('usuarios', $dados, "pessoa_id", $pessoa_id);
        if ($reativa) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => 'Informações alteradas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'administrativo/usuario_ativo_lista'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function geraOpcaoUsuario($selected = "")
    {
        $consulta = DbModel::consultaSimples("
            SELECT p.id, p.nome_completo
            FROM pessoas p
            INNER JOIN vinculos v on p.id = v.pessoa_id
            WHERE v.supervisao_id = 1 AND p.status_id = 1
            GROUP BY p.id, p.nome_completo
            ORDER BY p.nome_completo
        ");
        if ($consulta->rowCount() >= 1) {
            $options = $consulta->fetchAll(PDO::FETCH_NUM);
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
