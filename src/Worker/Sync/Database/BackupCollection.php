<?php
/**
 * 
 */

namespace Tramite\Worker\Sync\Database;

use SiUtils\Tools\Databases\Mysql\Mysql as MysqlTool;
use Tramite\Models\Digital\Infra\DatabaseCollection;
use Tramite\Contracts\ActionInterface;

class BackupCollection implements ActionInterface
{

    protected $collection = false;

    public function __construct(DatabaseCollection $collection)
    {
        $this->collection = $collection;
    }

    public function execute()
    {
        return (new MysqlTool($this->collection))->export();
    }
}
