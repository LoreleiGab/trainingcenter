<?php
namespace TrainingCenter\Models;

class ViewsModel
{
    protected function verificaModulo ($mod) {
        $modulos = [
            "inicio",
            "administrativo",
            "atleta",
            "preparador"
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
            'cadastro',
            'edita',
            'inicio',
            'login',
            'logout',
            'atleta_cadastro',
            'atleta_lista',
            'equipe_cadastro',
            'equipe_lista',
            'esforco_cadastro',
            'esforco_lista',
            'grupo_cadastro',
            'grupo_lista',
            'grupo_tipo_cadastro',
            'grupo_tipo_lista',
            'horas_dormidas_cadastro',
            'horas_dormidas_lista',
            'local_dor_cadastro',
            'local_dor_lista',
            'membro_cadastro',
            'membro_lista',
            'modalidade_cadastro',
            'modalidade_lista',
            'perfil_cadastro',
            'perfil_lista',
            'posicao_cadastro',
            'posicao_lista',
            'recupera_senha',
            'usuario_cadastro',
            'usuario_ativo_lista',
            'usuario_inativo_lista',
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