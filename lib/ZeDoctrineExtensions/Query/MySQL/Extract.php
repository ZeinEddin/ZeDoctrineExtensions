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
 * EXTRACT(unit FROM date)
 *
 * The EXTRACT() function uses the same kinds of unit specifiers as DATE_ADD() or 
 * DATE_SUB(), but extracts parts from the date rather than performing date arithmetic.
 * More info:
 * http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_extract
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions\Query\MySQL
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class Extract extends FunctionNode
{
    public $unit;
    public $date;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'EXTRACT(%s from %s)',
            $this->unit,
            $this->date->dispatch($sqlWalker)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $parser->match(TokenType::T_IDENTIFIER);
        $this->unit = $parser->getLexer()->token->value;
        $parser->match(TokenType::T_IDENTIFIER);
        $this->date = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
