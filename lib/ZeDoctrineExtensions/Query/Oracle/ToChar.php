<?php
/**
 * ZeDoctrineExtensions Oracle Function Pack
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

namespace ZeDoctrineExtensions\Query\Oracle;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * ToChar(value, fmt, nlsparam)
 *
 * TO_CHAR converts a number or date to a string
 * More info:
 * http://docs.oracle.com/database/121/SQLRF/functions217.htm#SQLRF06130
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions\Query\Oracle
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class ToChar extends FunctionNode
{
    private $value;
    private $fmt = null;
    private $nlsparam = null;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        $sql = 'TO_CHAR(' . $this->value->dispatch($sqlWalker);
        // use second format parameter if parsed
        if (null !== $this->fmt) {
            $sql .= ',' . $this->fmt->dispatch($sqlWalker);
            
            // use third nlsparam parameter if parsed
            if (null !== $this->nlsparam) {
                $sql .= ',' . $this->nlsparam->dispatch($sqlWalker);
            }
        }
        $sql .= ')';
        
        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->value = $parser->ArithmeticExpression();
        
        // parse second format parameter if available
        if (Lexer::T_COMMA === $lexer->lookahead['type']) {
            $parser->match(Lexer::T_COMMA);
            $this->fmt = $parser->ArithmeticPrimary();
            
            // parse third nlsparam parameter if available
            if (Lexer::T_COMMA === $lexer->lookahead['type']) {
                $parser->match(Lexer::T_COMMA);
                $this->nlsparam = $parser->ArithmeticPrimary();
            }
        }
        
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
