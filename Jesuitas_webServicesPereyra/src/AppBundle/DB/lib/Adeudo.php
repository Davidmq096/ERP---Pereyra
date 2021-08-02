<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Class InteresDocumento
 *
 * Agrega la posibilidad de utilizar la funcion calculaAdeudo 
 *
 * Modo de uso calculaAdeudo(alumnoid): decimal
 */
class Adeudo extends FunctionNode
{

    /** @var Node*/
    protected $alumnoid;

    public function parse( Parser $parser )
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );
        $this->alumnoid = $parser->StringPrimary();
        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }

    public function getSql( SqlWalker $sqlWalker )
    {
        return "calculaAdeudo(".$this->alumnoid->dispatch($sqlWalker).")";
    }


}