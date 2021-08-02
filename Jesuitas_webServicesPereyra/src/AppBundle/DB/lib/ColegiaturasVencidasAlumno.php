<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Class ColegiaturasVencidasAlumno
 *
 * 
 *
 * Modo de uso ColegiaturasVencidasAlumno(alumnoid,numerocolegiaturas)
 */
class ColegiaturasVencidasAlumno extends FunctionNode
{

    /** @var Node*/
    protected $alumnoid;
    protected $numerocolegiaturas;

    public function parse( Parser $parser )
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );
        $this->alumnoid = $parser->ArithmeticPrimary(); // (4)
        $parser->match(Lexer::T_COMMA); // (5)
        $this->numerocolegiaturas = $parser->ArithmeticPrimary(); // (6)
        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }

    public function getSql( SqlWalker $sqlWalker )
    {
        return "colegiaturasvencidasalumno(".$this->alumnoid->dispatch($sqlWalker) .",".$this->numerocolegiaturas->dispatch($sqlWalker) . ")";
    }


}