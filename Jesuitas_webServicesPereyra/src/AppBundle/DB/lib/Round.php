<?php
namespace AppBundle\DB\lib;
use Doctrine\ORM\Query\Lexer,
    Doctrine\ORM\Query\Parser,
    Doctrine\ORM\Query\SqlWalker,
    Doctrine\ORM\Query\AST\Functions\FunctionNode;
/**
 * @author Emmanuel Martinez Ayala (LugiaDark1)
 */
class Round extends FunctionNode{
    public $ldvalue=null;
    public $ldbase=null;
    public function parse(Parser $parser){
			$parser->match(Lexer::T_IDENTIFIER);
			$parser->match(Lexer::T_OPEN_PARENTHESIS);
			$this->ldvalue=$parser->ArithmeticPrimary();
			$parser->match(Lexer::T_COMMA);
			$this->ldbase=$parser->ArithmeticPrimary();
			$parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
    public function getSql(SqlWalker $sqlWalker){
			$data=sprintf("ROUND(%s,%s)",
					$this->ldvalue->dispatch($sqlWalker),
					$this->ldbase->dispatch($sqlWalker)
				);
			return $data;
    }
}