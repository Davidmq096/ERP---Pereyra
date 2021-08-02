<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Class MesEspanolFunction
 *
 * Adds the hability to use the MySQL MesEspanol function inside Doctrine
 *
 */
class MesEspanolFunction extends FunctionNode
{

    /**
     * Holds the timestamp of the FechaEspanol DQL statement
     * @var $dateExpression
     */
    protected $dateExpression;

    public function getSql( SqlWalker $sqlWalker )
    {
        return 'mesespanol (' . $sqlWalker->walkArithmeticExpression( $this->dateExpression ) .')';
    }

    public function parse( Parser $parser )
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );
        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }
}