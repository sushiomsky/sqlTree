<?php

namespace Suchomsky\SqlTree;

/**
 * class: SqlTree
 * purpose: Manages a nested sets tree structure in a SQL DB
 * Focus: Data/tree consistency
 * 
 * @copyright Copyright (C) 2001-2016 Webschreinerei
 * @author Dennis Suchomsky dennis.suchomsky@gmail.com
 * @license GPL
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 0.1
 * @todo
 *
 */
class SqlTree {
	
	/**
	 *
	 * @var Object $pdo PDO database connection object
	 */
	private $pdo = null;
	
	/**
	 *
	 * @var arrray $columns table and column names
	 */
	private $columns = null;

	/**
	 *
	 * @var array $statements pdo prepared statements
	 */
	private $statements = null;

	/**
	 *
	 * @var array $nodePointer stack of node id's last element is the id of the last node inserted
	 */
	private $nodePointer = array(0 => 0);
	
	/**
	 *
	 * @var array QUERYS Sql querys nescessary to manage the tree structure
	 */
	const QUERYS = array (
			'SELECT_WHERE_ID' => 'SELECT :id, :rgt, :lft, :parent, :name FROM :table WHERE :id=:idvalue LIMIT 0,1',
			'SELECT_TOP_RGT' => 'SELECT :rgt FROM :table WHERE 1 ORDER BY :rgt DESC LIMIT 0,1',
			'UPDATE_PARENTS_RGT' => 'UPDATE :table SET :rgt = :rgt +2 WHERE :rgt >= :rgtvalue',
			'UPDATE_PARENTS_LFT' => 'UPDATE :table SET :lft = :lft +2 WHERE :lft >= :lftvalue',
			'INSERT_NODE' => 'INSERT INTO :table (:lft, :rgt, :parent, :name) VALUES(:lftvalue, :rgtvalue, :parentvalue, :namevalue)' 
	);
	
	/**
	 * Connects to the database and checks for valid column names
	 * 
	 * @param array $dbCreds        	
	 * @param array $columns        	
	 */
	function __construct($dbCreds, $columns) {
		try {
			$this->pdo = new PDO ( 'mysql:host=' . $dbCreds ['host'] . ';dbname=' . $dbCreds ['db'], $dbCreds ['user'], $dbCreds ['password'] );
			$this->columns = $columns;
			$this->prepareStatements ();
		} catch ( PDOException $e ) {
			print "Error!: " . $e->getMessage ();
			$this->closeConnection ();
		}
	}
	
	/**
	 * Add a node at current position
	 * @param String $name Nodename
	 */
	public function addNode($name){
		
	}
	
	/**
	 * Add a Subnode at current position
	 * @param String $name Nodename
	 */
	public function addSubNode($name){
	
	}
	
	/**
	 * Add a root node
	 * @param String $name Nodename
	 */
	public function addRootNode($name){
	
	}
	
	/**
	 * prepares pdo statements
	 */
	private function prepareStatements() {
		$keys = array_keys ( QUERYS );
		foreach ( $keys as $key ) {
			$this->statements [strtolower ( $key )] = $this->pdo->prepare ( QUERYS [$key] );
		}
	}
	
	/**
	 * close database connection
	 */
	private function closeConnection() {
		$this->pdo = null;
	}
}

?>