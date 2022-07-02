@php namespace <?php echo $namespace ?>\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration_create_<?php echo $tableName ?>_table extends Migration
{
<?php if (isset($DBGroup)) : ?>
	protected $DBGroup = '<?php echo $DBGroup ?>';
<?php endif ?>

	public function up()
	{
		$this->forge->addField([
			'id'         => [
				'type'       => 'VARCHAR',
				'constraint' => 128,
				'null'       => false
			],
			'ip_address' => [
				'type'       => 'VARCHAR',
				'constraint' => 45,
				'null'       => false
			],
			'timestamp'  => [
				'type'       => 'INT',
				'constraint' => 10,
				'unsigned'   => true,
				'null'       => false,
				'default'    => 0
			],
			'data'       => [
				'type'       => 'TEXT',
				'null'       => false,
				'default'    => ''
			],
		]);
	<?php if ($matchIP === true) : ?>
	$this->forge->addKey(['id', 'ip_address'], true);
	<?php else: ?>
	$this->forge->addKey('id', true);
	<?php endif ?>
	$this->forge->addKey('timestamp');
		$this->forge->createTable('<?php echo $tableName ?>', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('<?php echo $tableName ?>', true);
	}
}
