<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Parser;

/**
 * Class DiaEspanolFunction
 *
 * Adds the hability to use the MySQL DiaEspanol function inside Doctrine
 *
 */
class DiaEspanolFunction extends FunctionNode
{

    /**
     * Holds the timestamp of the FechaEspanol DQL statement
     * @var $dateExpression
     */
    protected $dateExpression;

    public function getSql( SqlWalker $sqlWalker )
    {
        return 'diaespanol (' . $sqlWalker->walkArithmeticExpression( $this->dateExpression ) .')';
    }

    public function parse( Parser $parser )
    {
        $parser->Match( Lexer::T_IDENTIFIER );
        $parser->Match( Lexer::T_OPEN_PARENTHESIS );
        $this->dateExpression = $parser->ArithmeticExpression();
        $parser->Match( Lexer::T_CLOSE_PARENTHESIS );
    }
}