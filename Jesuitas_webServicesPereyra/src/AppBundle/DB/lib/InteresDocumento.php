<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Class InteresDocumento
 *
 * Agrega la posibilidad de utilizar la funcion calculaInteres 
 *
 * Modo de uso calculaInteres(documentoporpagarid): decimal
 */
class InteresDocumento extends FunctionNode
{

    /** @var Node*/
    protected $documentoporpagarid;

    public function parse( Parser $parser )
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );
        $this->documentoporpagarid = $parser->StringPrimary();
        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }

    public function getSql( SqlWalker $sqlWalker )
    {
        return "calculaInteres(".$this->documentoporpagarid->dispatch($sqlWalker).")";
    }


}