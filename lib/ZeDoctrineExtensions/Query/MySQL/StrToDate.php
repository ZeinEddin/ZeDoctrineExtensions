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
 * StrToDate(str, format)
 *
 * This is the inverse of the DATE_FORMAT() function. It takes a string str and a format 
 * string format. STR_TO_DATE() returns a DATETIME value if the format string contains 
 * both date and time parts, or a DATE or TIME value if the string contains only date or 
 * time parts. If the date, time, or datetime value extracted from str is illegal, 
 * STR_TO_DATE() returns NULL and produces a warning.
 * More info:
 * http://dev.mysql.com/doc/refman/5.5/en/date-and-time-functions.html#function_str-to-date
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions\Query\MySQL
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class StrToDate extends FunctionNode
{
    public $str = null;
    public $format = null;

    /**
     * {@inheritDoc}
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'STR_TO_DATE(%s, %s)',
            $this->str->dispatch($sqlWalker),
            $this->format->dispatch($sqlWalker)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);
        $this->str = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_COMMA);
        $this->format = $parser->ArithmeticPrimary();
        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }
}
