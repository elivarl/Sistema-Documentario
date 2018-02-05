<?php 
require('fpdf/fpdf.php');
class PlantillaExpedientePdf extends FPDF
{
	function encabezadoExpediente()
    {
        $this->SetFont('Arial','B',15);
        $this->SetXY(60, 10);
        $this->Cell(60,10,  utf8_decode('CARGO DEL EXPEDIENTE - INSTITUCIÓN'));
        //linea
        $this->Line( 10,  20,  195,  20);

        //DATOS 
        $this->SetFont('Arial','B',10);
        $this->SetXY(10, 18);
        $this->Cell(40,10,  utf8_decode('DATOS EXPEDIENTE'));
        $this->Ln();
    }
    function cuerpoExpediente($expediente, $tramite,$solicitante,$area,$cargo,$usuario)
    {
        //informaciòn expoediente
        $this->SetFont('Arial','B',10);
        $this->SetXY(10, 25);
        $this->Cell(40,10,  utf8_decode('Número: '.$expediente->getNumero()));
        $this->SetXY(120, 25);
        $this->Cell(40,10,  utf8_decode('Fecha Registro: '.$expediente->getFecha_registro()));        
        $this->Ln();
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Trámite: ".$tramite->getNombre()));
        $this->Ln(); 
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Área Registro: ".$area->getNombre()));
        $this->Ln(); 
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Usuario: ".$usuario->getNombres().' '.$usuario->getApellidos()));
        $this->Ln(); 
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Cargo: ".$cargo->getNombre()));
        $this->Ln();         
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Nombres Solicitante: '.$solicitante->getNombres().' '.$solicitante->getApellidos()));
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Precio: '.$tramite->getCosto()));

        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Estado del expediente: '.$expediente->getEstado()));
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Fecha atención del expediente: '.$expediente->getFecha_atendido()));

         $this->Ln();
         $this->Ln();
         $this->Ln();
         $this->Ln();
        $this->SetFont('Arial','B',15);
        $this->SetXY(60, 120);
        $this->Cell(60,10,  utf8_decode('CARGO DEL EXPEDIENTE - USUARIO'));
        //linea
        $this->Line( 10,  130,  195,  130);

        //DATOS 
        $this->SetFont('Arial','B',10);
         $this->SetXY(10, 128);
        $this->Cell(40,10,  utf8_decode('DATOS EXPEDIENTE'));
        $this->Ln();

         $this->SetFont('Arial','B',10);
        $this->SetXY(10, 135);
        $this->Cell(40,10,  utf8_decode('Número: '.$expediente->getNumero()));
        $this->SetXY(120, 135);
        $this->Cell(40,10,  utf8_decode('Fecha Registro: '.$expediente->getFecha_registro()));        
        $this->Ln();
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Trámite: ".$tramite->getNombre()));
        $this->Ln(); 
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Área Registro: ".$area->getNombre()));
        $this->Ln(); 
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Usuario: ".$usuario->getNombres().' '.$usuario->getApellidos()));
        $this->Ln(); 
        $this->SetFont('Arial','',10);     
        $this->MultiCell(150,5,  utf8_decode("Cargo: ".$cargo->getNombre()));
        $this->Ln();         
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Nombres Solicitante: '.$solicitante->getNombres().' '.$solicitante->getApellidos()));
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Precio: '.$tramite->getCosto()));
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Estado del expediente: '.$expediente->getEstado()));
        $this->Ln();
        $this->SetFont('Arial','',10);
        $this->Cell(40,10,  utf8_decode('Fecha atención del expediente: '.$expediente->getFecha_atendido()));        
       
    }


}