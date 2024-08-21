<?php
/**
 * ZeDoctrineExtensions MySQL Function Pack
 * 
 * PHP version 5
 *
 * LICENSE:
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 */

namespace ZeDoctrineExtensions\Query\MySQL;

use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * NULLIF(expr1, expr2)
 *
 * Returns NULL if expr1 = expr2 is true, otherwise returns expr1. 
 * This is the same as CASE WHEN expr1 = expr2 THEN NULL ELSE expr1 END. 
 * More info:
 * https://dev.mysql.com/doc/refman/5.5/en/control-flow-functions.html#function_nullif
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions\Query\MySQL
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class NullIf extends FunctionNode
{
    private $expr1;
    private $expr2;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'NULLIF(%s, %s)',
            $sqlWalker->walkArithmeticPrimary($this->expr1),
            $sqlWalker->walkArithmeticPrimary($this->expr2)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->expr1 = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->expr2 = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
