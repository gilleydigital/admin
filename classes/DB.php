<?php defined('SYSPATH') or die('No direct script access.');

class DB extends Kohana_DB {
	//Check if tables exist
	public static function check_for_tables ($tables)
	{
		if ( ! is_array($tables))
		{
			$tables = array($tables);
		}
		
		foreach($tables AS $table)
		{
			$result = DB::query(Database::SELECT, 'SHOW TABLES LIKE \''.$table.'\'')->execute();
			if($result->count() === 0)
			{
				return false;
			}
		}
		
		return true;
	}
}
