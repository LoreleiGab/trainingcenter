<?php
namespace TrainingCenter\Controllers;

use TrainingCenter\Models\UsuarioModel;
use TrainingCenter\Models\MainModel;
use TrainingCenter\Models\DbModel;
use PDO;

class UsuarioController extends UsuarioModel
{

    public function iniciaSessao() {
        $email = MainModel::limparString($_POST['email']);
        $senha = MainModel::limparString($_POST['senha']);
        $senha = MainModel::encryption($senha);

        $dadosLogin = [
            'email' => $email,
            'senha' => $senha
        ];

        $consultaEmail = UsuarioModel::getEmail($dadosLogin);

        if ($consultaEmail->rowCount() == 1){
            $consultaUsuario = UsuarioModel::getUsuario($dadosLogin);

            if ($consultaUsuario->rowCount() == 1) {
                $usuario = $consultaUsuario->fetch();

                session_start(['name' => 'trainingcenter']);
                $_SESSION['usuario_id_tc'] = $usuario['id'];
                $_SESSION['nome_tc'] = $usuario['apelido'];
                $_SESSION['profile_tc'] = $usuario['profile_id'];

                //MainModel::gravarLog('Fez Login');

                return "<script> window.location='inicio/inicio' </script>";
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Usuário / Senha incorreto',
                    'tipo' => 'error'
                ];

                return MainModel::sweetAlert($alerta);
            }
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Usuário não existe',
                'tipo' => 'error'
            ];
            return MainModel::sweetAlert($alerta);
        }
    }

    public function forcarFimSessao() {
        session_destroy();
        return header("Location: ".SERVERURL);
    }

    public function insereUsuario($dados) {
        $erro = false;
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "senha2") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM users WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insere = DbModel::insert('users', $dados);
            if ($insere) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário Cadastrado!',
                    'texto' => 'Usuário cadastrado com Sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaUsuario($dados, $id){
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('users', $dados, $id);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => 'Informações alteradas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'inicio/edita'
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

    public function trocaSenha($dados,$id){
        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }
        else{
            unset($dados['_method']);
            unset($dados['id']);
            unset($dados['senha2']);
            $dados = MainModel::limpaPost($dados);
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $edita = DbModel::update('users', $dados, $id);
            if ($edita) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário',
                    'texto' => 'Senha alterada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.'inicio/edita'
                ];
            }
            else{
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.'inicio/edita'
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaUsuario($id) {
        $usuario = DbModel::getInfo('users',$id);
        return $usuario;
    }

    public function recuperaEmail($email){
        return UsuarioModel::getExisteEmail($email);;
    }
}
