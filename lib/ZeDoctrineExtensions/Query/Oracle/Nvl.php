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

use Doctrine\ORM\Query\TokenType;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * Nvl(expr1, expr2)
 *
 * NVL lets you replace null (returned as a blank) with a string in the results 
 * of a query. If expr1 is null, then NVL returns expr2. If expr1 is not null, 
 * then NVL returns expr1.
 * More info:
 * http://docs.oracle.com/database/121/SQLRF/functions130.htm#SQLRF00684
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions\Query\Oracle
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class Nvl extends FunctionNode
{
    private $expr1;
    private $expr2;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'NVL(%s, %s)',
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
