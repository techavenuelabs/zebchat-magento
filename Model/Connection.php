<?php
/**
 * Stored ZebChat connection.
 *
 * @package   ZebChat
 * @copyright (C) 2026 Tech Avenue Labs
 * @license   GNU General Public License version 2 or later; see https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace Zebchat\Widget\Model;

use Magento\Framework\App\ResourceConnection;

/**
 * One JSON bag in zebchat_state. The site key is public; the tokens are not.
 */
class Connection
{
    public function __construct(private readonly ResourceConnection $resource)
    {
    }

    public function app(): \ZebChatApp
    {
        require_once dirname(__DIR__) . '/lib/ZebChatApp.php';
        return new \ZebChatApp(
            function () {
                $connection = $this->resource->getConnection();
                $table = $this->resource->getTableName('zebchat_state');
                $raw = $connection->fetchOne($connection->select()->from($table, ['state'])->where('id = ?', 1));
                $decoded = is_string($raw) ? json_decode($raw, true) : [];
                return is_array($decoded) ? $decoded : [];
            },
            function (array $bag) {
                $connection = $this->resource->getConnection();
                $table = $this->resource->getTableName('zebchat_state');
                $json = json_encode($bag);
                if (!is_string($json)) {
                    return;
                }
                $connection->insertOnDuplicate($table, ['id' => 1, 'state' => $json], ['state']);
            },
            'ZebChat-Magento/' . \ZebChatApp::VERSION
        );
    }
}
