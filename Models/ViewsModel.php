<?php
namespace Gesp\Models;

class ViewsModel
{
    protected function verificaModulo ($mod) {
        $modulos = [
            "inicio",
            "administrativo",
            "pessoa"
        ];

        if (in_array($mod, $modulos)) {
            if (is_dir("./views/modulos/" . $mod)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function exibirViewModel($view, $modulo = "") {
        $whitelist = [
            'area_impressao',
            'cadastro',
            'edita',
            'inicio',
            'login',
            'logout',
            'aniversariante_lista',
            'cargo_cadastro',
            'cargo_lista',
            'curso_cadastro',
            'curso_lista',
            'departamento_cadastro',
            'departamento_lista',
            'estado_civil_cadastro',
            'estado_civil_lista',
            'ferias_lista',
            'ferias_cadastro',
            'funcionario_cadastro',
            'funcionario_ativo_lista',
            'funcionario_cedido_lista',
            'funcionario_inativo_lista',
            'genero_cadastro',
            'genero_lista',
            'grau_instrucao_cadastro',
            'grau_instrucao_lista',
            'padrao_cadastro',
            'padrao_lista',
            'recupera_senha',
            'relacao_juridico_cadastro',
            'relacao_juridico_lista',
            'script_importacao_parte1',
            'script_importacao_parte2',
            'script_importacao_parte3',
            'supervisao_cadastro',
            'supervisao_lista',
            'vacancia_cadastro',
            'vacancia_lista',
            'vinculo_cadastro',
            'vinculo_lista',
            'usuario_cadastro',
            'usuario_ativo_lista',
            'usuario_inativo_lista',
            'orgao_lista',
            'orgao_cadastro'
        ];
        if (self::verificaModulo($modulo)) {
            if (in_array($view, $whitelist)) {
                if (is_file("./views/modulos/$modulo/$view.php")) {
                    $conteudo = "./views/modulos/$modulo/$view.php";
                } else {
                    $conteudo = "./views/modulos/$modulo/inicio.php";
                }
            } else {
                $conteudo = "./views/modulos/$modulo/inicio.php";
            }
        } elseif ($modulo == "login") {
            $conteudo = "login";
        } elseif ($modulo == "cadastro") {
            $conteudo = "cadastro";
        } elseif ($modulo == "index") {
            $conteudo = "login";
        } elseif ($modulo == "script_importacao_parte1") {
            $conteudo = "script_importacao_parte1";
        } elseif ($modulo == "script_importacao_parte2") {
            $conteudo = "script_importacao_parte2";
        } elseif ($modulo == "script_importacao_parte3") {
            $conteudo = "script_importacao_parte3";
        }elseif ($modulo == "aniversariante_lista") {
            $conteudo = "aniversariante_lista";
        } elseif ($modulo == "recupera_senha") {
            $conteudo = "recupera_senha";
        } elseif ($modulo == "resete_senha") {
            $conteudo = "resete_senha";
        } else {
            $conteudo = "login";
        }

        return $conteudo;
    }

    protected function exibirMenuModel ($modulo) {
        if (self::verificaModulo($modulo)) {
            if (is_file("./views/modulos/$modulo/include/menu.php")) {
                $menu = "./views/modulos/$modulo/include/menu.php";
            } else {
                $menu = "./views/template/menuExemplo.php";
            }
        } else {
            $menu = "./views/template/menuExemplo.php";
        }

        return $menu;
    }
}