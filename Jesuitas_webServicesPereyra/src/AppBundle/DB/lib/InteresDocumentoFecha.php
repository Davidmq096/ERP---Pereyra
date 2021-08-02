<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Class InteresDocumentoFecha
 *
 * Agrega la posibilidad de utilizar la funcion calculaInteresfecha 
 *
 * Modo de uso calculaInteresfecha(documentoporpagarid,fecha): decimal
 */
class InteresDocumentoFecha extends FunctionNode
{

    /** @var Node*/
    protected $documentoporpagarid;
    protected $fecha;

    public function parse( Parser $parser )
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );
        $this->documentoporpagarid = $parser->ArithmeticPrimary(); // (4)
        $parser->match(Lexer::T_COMMA); // (5)
        $this->fecha = $parser->ArithmeticPrimary(); // (6)
        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }

    public function getSql( SqlWalker $sqlWalker )
    {
        return "calculaInteresfecha(".$this->documentoporpagarid->dispatch($sqlWalker) .",".$this->fecha->dispatch($sqlWalker) . ")";
    }


}