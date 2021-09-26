<?php

class Migration_Products extends CI_Migration {

	// table name
	private $table = 'products';

	public function up() {
		$fields = array(
			'id'                => array(
				'type'           => 'INT',
				'constraint'     => 11,
				'auto_increment' => true,
			),
			'name'              => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'category_id'       => array(
				'type'       => 'INT',
				'constraint' => 11,
			),
			'brand_id'          => array(
				'type'       => 'INT',
				'constraint' => 11,
			),
			'model'             => array(
				'type'       => 'VARCHAR',
				'constraint' => 150,
			),
			'tag_line'          => array(
				'type'       => 'VARCHAR',
				'constraint' => 250,
				'null' => TRUE,
			),
			'features'          => array(
				'type'       => 'VARCHAR',
				'constraint' => 350,
			),
			'price'             => array(
				'type'       => 'INT',
				'constraint' => 11,
			),
			'qty_at_hand'       => array(
				'type'       => 'INT',
				'constraint' => 11,
			),
			'editorial_reviews' => array(
				'type'       => 'VARCHAR',
				'constraint' => 750,
			),
			'activated' => array(
				'type'       => 'BOOLEAN',
				'default'	 => TRUE
			),
			'created_from_ip'   => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'updated_from_ip'   => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'created_at datetime default current_timestamp',
    		'updated_at datetime default current_timestamp on update current_timestamp',
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (category_id) REFERENCES categories(id)');
		$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (brand_id) REFERENCES brands(id)');
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table);
	}

	public function down() {
		$this->dbforge->drop_table($this->table);
	}
}
