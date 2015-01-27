<?php

namespace Anax\DI;

/**
 * Extended factory for Anax documentation.
 *
 */
class CDIFactoryTest extends CDIFactoryDefault
{
   /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->theme->setBaseTitle(" - Anax test case");
        //$this->url->setStaticBaseUrl($this->request->getBaseUrl() . "/..");

        $this->setShared('db', function() {
            $db = new \Mos\Database\CDatabaseBasic();
            $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
            $db->connect();
            return $db;
        });
    }
}
