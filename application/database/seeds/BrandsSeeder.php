<?php

class BrandsSeeder extends Seeder {
	
	// table name
	private $table = 'brands';

	public function run() {
		$this->db->query("SET foreign_key_checks = 0");
		$this->db->truncate($this->table);

		//seed many records using faker
		$limit = 10;
		echo "seeding $this->table ";

		for ($i = 0; $i < $limit; $i++) {
			echo ".";

			$data = array(
				'description'     => $this->faker->unique()->word,
				'created_from_ip' => $this->faker->ipv4,
				'updated_from_ip' => $this->faker->ipv4,
				'created_at'    => $this->faker->date($format = 'Y-m-d H:i:s'),
				'updated_at'    => $this->faker->date($format = 'Y-m-d H:i:s'),
			);

			$this->db->insert($this->table, $data);
		}
		
		echo " $limit data.";

		echo PHP_EOL;
		
		$this->db->query("SET foreign_key_checks = 1");
	}
}
