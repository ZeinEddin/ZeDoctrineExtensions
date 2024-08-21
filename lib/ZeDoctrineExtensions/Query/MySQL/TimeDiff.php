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
 * TimeDiff(expr1, expr2)
 *
 * returns expr1 - expr2 expressed as a time value. expr1 and expr2 are time 
 * or date-and-time expressions, but both must be of the same type.
 * More info:
 * http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_timediff
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions\Query\MySQL
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class TimeDiff extends FunctionNode
{
    public $firstTimeExpression = null;
    public $secondTimeExpression = null;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'TIMEDIFF(%s, %s)',
            $this->firstTimeExpression->dispatch($sqlWalker),
            $this->secondTimeExpression->dispatch($sqlWalker)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->firstTimeExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->secondTimeExpression = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
