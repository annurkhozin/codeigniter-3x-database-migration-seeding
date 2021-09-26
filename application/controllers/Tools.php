<?php

class Tools extends CI_Controller {

	public $seeder;

	public function __construct() {
		parent::__construct();

		$this->load->library('database/seeder');
		$this->seeder =  new Seeder();

		// can only be called from the command line
		if (!$this->input->is_cli_request()) {
			exit('Direct access is not allowed. This is a command line tool, use the terminal');
		}

		$this->load->dbforge();

		// initiate faker
		$this->faker = Faker\Factory::create();
	}

	public function message($to = 'World') {
		echo "Hello {$to}!" . PHP_EOL;
	}

	public function index(){
		$this->help();
	}

	public function help() {
		$result = "\033[33mThe following are the available command line interface commands\n\n";
		$result .= "\033[32mMigration Commands:\n";
		$result .= "\033[34m  $ \033[37mphp cli tools migration \033[33m\"File_Name\"         \033[36mCreate new migration file\n";
		$result .= "\033[34m  $ \033[37mphp cli tools migrate [\033[33m\"Version_Number\"]    \033[36mRun all migrations. The version number is optional.\n";

		$result .= "\n\033[32mSeed Commands:\n";
		$result .= "\033[34m  $ \033[37mphp cli tools seeder \033[33m\"File_Name\"            \033[36mCreates a new seed file.\n";
		$result .= "\033[34m  $ \033[37mphp cli tools seed \033[33m\"File_Name\"              \033[36mRun the specified seed file.\n";
		$result .= "\033[34m  $ \033[37mphp cli tools seeds                         \033[36mRun all seed files.\n";
		$result .= "\033[37m";

		echo $result . PHP_EOL;
	}

	public function migration($name) {
		if(ENVIRONMENT == 'production'){
			echo "\33[31mFailed, app is now in production mode\n\33[37m";
			die;
		}
		$this->make_migration_file($name);
	}

	public function migrate($version = null) {
		if(ENVIRONMENT == 'production'){
			echo "\33[31mFailed, app is now in production mode\n\33[37m";
			die;
		}

		$this->load->library('migration');

		if ($version != null) {
			if ($this->migration->version($version) === false) {
				show_error($this->migration->error_string());
			} else {
				echo "Migrations run successfully" . PHP_EOL;
			}

			return;
		}

		if ($this->migration->latest() === false) {
			show_error($this->migration->error_string());
		} else {
			echo "Migrations run successfully" . PHP_EOL;
		}
	}

	public function seeder($name) {
		if(ENVIRONMENT == 'production'){
			echo "\33[31mFailed, app is now in production mode\n\33[37m";
			die;
		}
		$this->make_seed_file($name);
	}

	public function seed($name = null) {
		if(ENVIRONMENT == 'production'){
			echo "\33[31mFailed, app is now in production mode\n\33[37m";
			die;
		}
		if($name){
			$this->seeder->call($name);
		}else{
			echo 'File_name is required';
		}
	}

	public function seeds() {
		if(ENVIRONMENT == 'production'){
			echo "\33[31mFailed, app is now in production mode\n\33[37m";
			die;
		}
		$this->seeder->call(null);
	}

	protected function make_migration_file($name) {
		$date = new DateTime();
		$timestamp = $date->format('YmdHis');

		$table_name = strtolower($name);

		$path = APPPATH . "database/migrations/$timestamp" . "_" . "$name.php";

		$my_migration = fopen($path, "w") or die("Unable to create migration file!");

		$migration_template = "<?php

class Migration_$name extends CI_Migration {

	// table name
	private \$table = '$table_name';
	
	public function up() {
		\$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			),
			'full_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 50,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'created_at datetime default current_timestamp',
    		'updated_at datetime default current_timestamp on update current_timestamp',
		);

		\$this->dbforge->add_field(\$fields);
		\$this->dbforge->add_key('id', TRUE);
		\$this->dbforge->create_table(\$this->table);
	}

	public function down() {
		\$this->dbforge->drop_table(\$this->table);
	}

}";

		fwrite($my_migration, $migration_template);

		fclose($my_migration);

		echo "$path migration has successfully been created." . PHP_EOL;
	}

	protected function make_seed_file($name) {
		$path = APPPATH . "database/seeds/$name.php";

		$my_seed = fopen($path, "w") or die("Unable to create seed file!");

		$seed_template = "<?php

class $name extends Seeder {
	
	// table name
	private \$table = 'users';

	public function run() {
		\$this->db->query(\"SET foreign_key_checks = 0\");
		\$this->db->truncate(\$this->table);

		//seed records manually
		\$seeds = [];
		
		array_push(\$seeds, [
			'full_name' => 'Admin 1',
			'username' => 'admin1',
			'password' => '1234',
		]);
		array_push(\$seeds, [
			'full_name' => \$this->faker->unique()->name,
			'username' => \$this->faker->unique()->userName,
			'password' => '1234',
		]);
		
		// ============ OR ============
		
		//seed many records using faker
		\$limit = 10;

		for (\$i = 0; \$i < \$limit; \$i++) {
			array_push(\$seeds, [
				'full_name' => \$this->faker->unique()->name,
				'username' => \$this->faker->unique()->userName,
				'password' => '1234',
			]);
		}


		echo \"seeding \$this->table\";
		for (\$i = 0; \$i < count(\$seeds); \$i++) {
			echo \".\";
			
			\$data = \$seeds[\$i];

			\$this->db->insert(\$this->table, \$data);
		}

		echo \" \". \count(\$seeds).\" data.\";

		echo PHP_EOL;
		
		\$this->db->query(\"SET foreign_key_checks = 1\");
	}
}
";

		fwrite($my_seed, $seed_template);

		fclose($my_seed);

		echo "$path seeder has successfully been created." . PHP_EOL;
	}

}
