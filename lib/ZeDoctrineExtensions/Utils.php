<?php
/**
 * ZeDoctrineExtensions Function Pack Map Utility
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

namespace ZeDoctrineExtensions;

/**
 * Get the Database custome DQL functions
 *
 * Get the name=>class of the custome DQL functions.
 *
 * @category    ZeDoctrineExtensions
 * @package     ZeDoctrineExtensions
 * @license     http://www.opensource.org/licenses/mit-license.html  MIT License
 * @author      Mohammad ZeinEddin <mohammad@zeineddin.name>
 */

class Utils
{
    public static function getOracleDQLFunctions()
    {
        return array(
            'datetime_functions' => array(
                'Nvl' => 'ZeDoctrineExtensions\Query\Oracle\Nvl',
                'Translate' => 'ZeDoctrineExtensions\Query\Oracle\Translate',
                'ToDate' => 'ZeDoctrineExtensions\Query\Oracle\ToDate',
                'TruncDate' => 'ZeDoctrineExtensions\Query\Oracle\TruncDate',
            ),
            'string_functions' => array(),
            'numeric_functions' => array(
                'ToNumber' => 'ZeDoctrineExtensions\Query\Oracle\ToNumber'
            ),
        );
    }
    
    public static function getMySQLDQLFunctions()
    {
        return array(
            'datetime_functions' => array(
                'Date' => 'ZeDoctrineExtensions\Query\MySQL\Date',
                'SecToTime' => 'ZeDoctrineExtensions\Query\MySQL\SecToTime',
                'TimeDiff' => 'ZeDoctrineExtensions\Query\MySQL\TimeDiff',
                'TimeToSec' => 'ZeDoctrineExtensions\Query\MySQL\TimeToSec',
                'StrToDate' => 'ZeDoctrineExtensions\Query\MySQL\StrToDate',
                'Extract' => 'ZeDoctrineExtensions\Query\MySQL\Extract',
            ),
            'string_functions' => array(
                'IfNull' => 'ZeDoctrineExtensions\Query\MySQL\IfNull',
                'NullIf' => 'ZeDoctrineExtensions\Query\MySQL\NullIf',
            ),
            'numeric_functions' => array(),
        );
    }
}
