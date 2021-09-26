<?php

class Migration_Categories extends CI_Migration {

	// table name
	private $table = 'categories';

	public function up() {
		$fields = array(
			'id'              => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'auto_increment' => true,
			),
			'description'     => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'activated' => array(
				'type'       => 'BOOLEAN',
				'default'	 => TRUE
			),
			'created_from_ip' => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'updated_from_ip' => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'created_at datetime default current_timestamp',
    		'updated_at datetime default current_timestamp on update current_timestamp',
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table);
	}

	public function down() {
		$this->dbforge->drop_table($this->table);
	}
}
