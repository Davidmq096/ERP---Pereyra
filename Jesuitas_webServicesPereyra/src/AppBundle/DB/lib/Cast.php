<?php

namespace AppBundle\DB\lib;

use Doctrine\ORM\Query\AST\Functions\FunctionNode,
Doctrine\ORM\Query\Lexer;

class Cast extends FunctionNode
{
    public $firstDateExpression = null;
    public $unit = null;    

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstDateExpression = $parser->StringPrimary();

        $parser->match(Lexer::T_AS);

        $parser->match(Lexer::T_IDENTIFIER);
        $lexer = $parser->getLexer();
        $this->unit = $lexer->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf('CAST(%s AS %s)',  $this->firstDateExpression->dispatch($sqlWalker), $this->unit);
    }
}