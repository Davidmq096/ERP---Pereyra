<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
    Doctrine\ORM\Query\Lexer;

/**
 * Full support for:
 *
 * GROUP_CONCAT([DISTINCT] expr [,expr ...]
 *              [ORDER BY {unsigned_integer | col_name | expr}
 *                  [ASC | DESC] [,col_name ...]]
 *              [SEPARATOR str_val])
 *
 */
class StrToDate  extends FunctionNode
{
    public $dateString = null;
    public $dateFormat = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->dateString = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->dateFormat = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'STR_TO_DATE(' .
            $this->dateString->dispatch($sqlWalker) . ', ' .
            $this->dateFormat->dispatch($sqlWalker) .
            ')';
    }
}
