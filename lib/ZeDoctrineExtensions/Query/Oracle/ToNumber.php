<?php
namespace ZeDoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class ToNumber extends FunctionNode
{
    private $expr1;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'TO_NUMBER(%s)',
            $sqlWalker->walkArithmeticPrimary($this->expr1)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
