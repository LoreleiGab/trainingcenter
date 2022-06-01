<?php
namespace TrainingCenter\Models;

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