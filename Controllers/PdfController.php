<?php
namespace TrainingCenter\Controllers;
require_once "../views/plugins/fpdf/fpdf.php";

use FPDF;
use TrainingCenter\Controllers\Pessoa\FeriasController;

class PdfController extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('../views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png', 20, 10);
        // Arial bold 15
        $this->SetFont('Arial','B',18);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(40,15,utf8_decode("Aviso de Férias"),0,0,'C');
        // Line break
        $this->Ln(20);
    }

    /**
     * @param $id
     * @param bool $returnNome
     * @param string $destino
     * <p><b>I</b>: Envia o arquivo para ser visualizado no browser</p>
     * <p><b>D</b>: Envia o arquivo ao browser e força o download</p>
     * <p><b>F</b>: Salva o arquivo. O caminho pode ser especificado no nome do arquivo</p>
     * <p><b>S</b>: return the document as a string.</p>
     */
    public function gerarAvisoFerias($id, bool $returnNome, string $destino = "I")
    {
        $pdf = new $this;
        $feriasObj = new FeriasController();
        $ferias = $feriasObj->recuperar($id);
        
        $pdf->AliasNbPages();
        $pdf->AddPage();


        $x = 20;
        $l = 7; //DEFINE A ALTURA DA LINHA
        $f = 10; //TAMANHO DA FONTE

        $pdf->SetXY($x, 35);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

        $pdf->SetTitle(utf8_decode("Aviso de Férias"));

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(180, $l, utf8_decode("1. IDENTIFICAÇÃO DO(A) SERVIDOR(A)"), 1, 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(140, $l, utf8_decode("NOME: " . $ferias->nome_completo), 'L', 0, 'L');
        $pdf->Cell(40, $l, utf8_decode("REGISTRO: ". $ferias->rf.$ferias->rf_digito), 'R', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(140, $l, utf8_decode("CARGO/FUNÇÃO: " . $ferias->cargo), 'L', 0, 'L');
        $pdf->Cell(40, $l, utf8_decode("PADRÃO: " . $ferias->padrao), 'R', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(100, $l, utf8_decode("VÍNCULO: " . $ferias->relacao), 'LB', 0, 'L');
        $pdf->Cell(80, $l, utf8_decode("REGIME ESPECIAL:"), 'RB', 1, 'L');

        $pdf->Ln(5);

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(160, $l, utf8_decode("2. IDENTIFICAÇÃO DA UNIDADE:"), 'TLB', 0, 'L');
        $pdf->Cell(20, $l, utf8_decode("PREFIXO:"), 'TRB', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(160, $l, utf8_decode("SECRETARIA MUNICIPAL DE CULTURA"), 'L', 0, 'L');
        $pdf->Cell(20, $l, utf8_decode("SMC"), 'R', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(160, $l, utf8_decode("DEPARTAMENTO: " . $ferias->departamento), 'L', 0, 'L');
        $pdf->Cell(20, $l, utf8_decode($ferias->depto_sigla), 'R', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(180, $l, utf8_decode("SEÇÃO: " . $ferias->supervisao), 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(180, $l, utf8_decode("SETOR: " . $ferias->sup_sigla), 'LRB', 1, 'L');

        $pdf->Ln(5);

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(180, $l, utf8_decode("3. COMUNICAÇÃO DE INÍCIO DE FÉRIAS:"), 1, 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->MultiCell(180, $l, utf8_decode("Cientifico Vossa Senhoria que a partir de ".date('d/m/Y', strtotime($ferias->data_inicio)).", terá início o gozo de ".$ferias->quatidade_dias." dias de férias referentes ao exercício de ".$ferias->exercicio." conforme previsto na respectiva escala."), 'LR');

        $pdf->SetX($x);
        $pdf->Cell(180, 15, "", 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(90, 10, utf8_decode("São Paulo, ".date('d/m/Y'.".")), 'LB', 0, 'L');
        $pdf->Cell(90, 10, utf8_decode("Carimbo e Assinatura da Chefia Imediata"), 'TRB', 1, 'C');

        $pdf->Ln(5);

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(180, $l, utf8_decode("4. CIÊNCIA:"), 1, 1, 'L');

        $pdf->SetX($x);
        $pdf->Cell(180, 20, "", 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(90, $l, utf8_decode("São Paulo, _____/_____/________"), 'L', 0, 'L');
        $pdf->Cell(90, $l, utf8_decode("Assinatura do servidor"), 'TR', 1, 'C');

        $pdf->SetX($x);
        $pdf->Cell(180, 20, "", 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(180, $l, utf8_decode("Testemunhas"), 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->Cell(180, 5, "", 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(180, 10, utf8_decode("1) ______________________________"), 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(180, 10, utf8_decode("2) ______________________________"), 'LR', 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(180, $l, utf8_decode(""), 'LRB', 1, 'L');

        $pdf->Ln(5);

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(180, 5, utf8_decode("- ANEXAR NO PRONTUÁRIO DO SERVIDOR."), 0, 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(180, 5, utf8_decode("- O FORMULÁRIO NÃO DEVE CONTER RASURAS."), 0, 1, 'L');

        $pdf->SetX($x);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(180, 5, utf8_decode("- DEVE SER DEVIDAMENTE PREENCHIDO, ASSINADO E DATADO."), 0, 1, 'L');

        if ($returnNome) {
            $dataAtual = date("dmYHis");
            $nomeArquivo = "$ferias->nome_completo"."_$dataAtual.pdf";
            $pdf->Output("../download/$nomeArquivo", $destino);
            return $nomeArquivo;
        } else {
            $pdf->Output("../download/$ferias->nome_completo.pdf", $destino);
        }
    }

    public function gerarMultiplosAvisosFerias($ids)
    {
        $pdfsGerados = [];
        foreach ($ids as $id) {
            $pdfsGerados[] = $this->gerarAvisoFerias($id, true, "F");
        }

        return $pdfsGerados;
    }
}