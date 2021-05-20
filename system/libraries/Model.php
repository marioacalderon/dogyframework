<?php 

class Model {

	use session;

	private $host = DB_HOST;
	private $user = DB_USER;
	private $pass = DB_PASS;
	private $name = DB_NAME;

	protected $db;
	protected $query;

	public function __construct()
	{
		// Conexión
		try
		{
			$dns = 'mysql:host='.$this->host.';dbname='.$this->name;
			$this->db = new PDO($dns, $this->user, $this->pass);
		}
		catch (PDOException $e)
		{
			die('No se logró conectar a la base de datos. '.$e->getMessage());
		}
	}

	// Método que ejecutará las consultas a la base de datos
	public function query($query, $options = [])
	{
		if (empty($options))
		{
			$this->query = $this->db->prepare($query);
			return $this->query->execute($options);
		}
		else
		{
			$this->query = $this->db->prepare($query);
			return $this->query->execute($options);
		}
	}

	// Método para contar los registros de la tabla
	public function allCount($table_name)
	{
		$this->query = $this->db->prepare("SELECT * FROM ".$table_name);
		$this->query->execute();
		return $this->query->rowCount();
	}

	// Método para saber si la fila existe
	public function count()
	{
		return $this->query->rowCount();
	}

	// Método para obtener todos los registros de la tabla	
	public function allRecords()
	{
		return $this->query->fetchAll(PDO::FETCH_OBJ);
	}

	// Método para obtener 1 registro
	public function row()
	{
		return $this->query->fetch(PDO::FETCH_OBJ);
	}

	// Método para seleccion por parametro de la tabla
	public function selectByItems($table_name, $options = [])
	{
		if (empty($options))
		{
			$this->query = $this->db->prepare("SELECT * FROM ".$table_name);
			return $this->query->execute();
		}
		else
		{
			$this->query = $this->db->prepare("SELECT ".$options." FROM ".$table_name);
			return $this->query->execute();
		}
	}

	// Método para seleccionar por condicion
	public function select($table_name, $options)
	{
		$where_section;
		$elements;

		foreach($options as $key => $values):
			$where_section .= $key." = ? AND ";
			$elements .= $values.",";
		endforeach;

		// Quitamos el útlimo AND del la sentencia
		$where_section = rtrim($where_section, " AND");

		// Quitamos la úlltima coma
		$elements = rtrim($elements, ",");
		$elements = explode(",", $elements);
		
		$this->query = $this->db->prepare("SELECT * FROM ".$table_name." WHERE ". $where_section);
		return $this->query->execute($elements);
	}

	// Método para eliminar por condicion
	public function delete($table_name, $options)
	{
		$where_section;
		$elements;

		foreach($options as $key => $values):
			$where_section .= $key." = ? AND ";
			$elements .= $values.",";
		endforeach;

		// Quitamos el útlimo AND del la sentencia
		$where_section = rtrim($where_section, " AND");

		// Quitamos la úlltima coma
		$elements = rtrim($elements, ",");
		$elements = explode(",", $elements);
		
		$this->query = $this->db->prepare("DELETE FROM ".$table_name." WHERE ". $where_section);
		return $this->query->execute($elements);
	}

	// Método para actualizar por condicion
	public function update($table_name, $setArray, $options)
	{
		$set_section;
		$set_values;

		foreach ($setArray as $key => $values):
			$set_section .= $key." = ?,";
			$set_values .= $values.",";
		endforeach;

		// Quitamos la última coma
		$set_section = rtrim($set_section, ",");

		$where_section; 
		$elements;

		foreach ($options as $key => $values):
			$where_section .= $key." = ? AND ";
			$elements .= $values.",";
		endforeach;

		// Quitamos el último AND
		$where_section = rtrim($where_section, " AND");

		// Combinamos los valores de la seccion SET con los valores de la seccion WHERE y quitamos la última coma
		$combine = $set_values.$elements;		
		$combine = rtrim($combine, ",");
		$combine = explode(",", $combine);
		
		// Actualizamos la base da datos
		$this->query = $this->db->prepare("UPDATE ".$table_name." SET ".$set_section." WHERE ".$where_section);
		return $this->query->execute($combine);
	}

	// Método para insertar por condicion
	public function insert($table_name, $options = [])
	{
		$elements;
		$placeholder;
		$place_values;

		foreach ($options as $key => $values):
			$elements .= $key.",";
			$placeholder .= str_replace($key, "?,", $key);
			$place_values .= $values.",";
		endforeach;

		$elements = rtrim($elements, ",");
		$placeholder = rtrim($placeholder, ",");
		$place_values = rtrim($place_values, ",");
		$place_values = explode(",", $place_values);

		$this->query = $this->db->prepare("INSERT INTO ".$table_name." (".$elements.") VALUES (".$placeholder.")");
		return $this->query->execute($place_values);
	}

	// Metodo INNER JOIN
	public function join($table_one, $table_two, $condition, $join_name = "")
	{
		if (empty($join_name))
		{
			$this->query = $this->db->prepare("SELECT * FROM ".$table_one." INNER JOIN ".$table_two." ON ".$condition);
			return $this->query->execute();
		}
		else if ($join_name == "LEFT JOIN")
		{
			$this->query = $this->db->prepare("SELECT * FROM ".$table_one." LEFT JOIN ".$table_two." ON ".$condition);
			return $this->query->execute();
		}
		else if ($join_name == "RIGHT JOIN")
		{
			$this->query = $this->db->prepare("SELECT * FROM ".$table_one." RIGHT JOIN ".$table_two." ON ".$condition);
			return $this->query->execute();			
		}
	}
	
	
}