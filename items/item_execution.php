<?php
	
	// Following is the description and instruction for the functions implemented inside this module.
	
	// To search a help for functions , search for _FUNCTIONNAME for example : " _damage_student_attack "
	
	/*
	
	MISC COMMAND :
	
		_fetch_data()
		
			FETCH_DATA :
				
				DESCRIPTION :
				
					A function that takes zero arguments and return a MAP of all data present in Game_Data
				
				USAGE :
				
					$datamap = fetch_data()
					
		_update_data()
		
			UPDATE_DATA :
			
				DESCRIPTION :
				
					A function that takes two arguments :
					
						1 - $dataname :	TYPE : STRING : Indicates the name of data you are changing
						2 - $value	  : TYPE : WHATEVER : Contains the data you are using to replace
						
				USAGE :
				
					update_data("boss_process",fetch_data()["boss_process"]+500);
						
				
	
	
	BOSS RELATED :
	
		_damage_boss_attack_p1()
		
			DAMAGE_BOSS_ATTACK_P1 :
			
				DESCRIPTION:
				
					A function that takes the following arguments :
					
						1 - $t 		TYPE : INT	: indicates time AFTER modifiers
						2 - $h 		TYPE : INT	: indicates boss health ( % boss_dmg / boss_dmg + student_dmg )
						3 - $ex 	TYPE : INT	: indicates extra boss damage
						4 - $attr	TYPE : INT	: indicates attack rate, or damage update rate
						
					And returns the damage dealt in such time period as an integer. Used in phase 1. But can be called in a more simple way.
					
				USAGE :
				
					$damagedealt = damage_boss_attack_p1(gettime(),$health,$extra,$0.1);
					
		_damage_boss_attack_p2()
		
			DAMAGE_BOSS_ATTACK_P2 :
			
				DESCRIPTION:
				
					A function that takes the following arguments :
					
						1 - $t 		TYPE : INT	: indicates time AFTER modifiers
						2 - $h 		TYPE : INT	: indicates boss health ( % boss_dmg / boss_dmg + student_dmg )
						3 - $ex 	TYPE : INT	: indicates extra boss damage
						4 - $attr	TYPE : INT	: indicates attack rate, or damage update rate
						
					And returns the damage dealt in such time period as an integer. Used in phase 2. But can be called in a more simple way.
					
				USAGE :
				
					$damagedealt = damage_boss_attack_p1(gettime(),$health,$extra,$0.1);
					
		_execute_boss_attack()
		
			EXECUTE_BOSS:
			
				DESCRIPTION:
				
					A function that takes the following arguments:
					
						1 - $t 		TYPE : INT	: indicates time AFTER modifiers
						2 - $h 		TYPE : INT	: indicates boss health ( % boss_dmg / boss_dmg + student_dmg )
						3 - $ex 	TYPE : INT	: indicates extra boss damage
						4 - $attr	TYPE : INT	: indicates attack rate, or damage update rate
					
					And executes the boss attack without any return values
					
				USAGE:
					
					if($currenttime - $lastattack > 0.1)
						execute_boss_attack(gettime(),$health,$extra,$currenttime - $lastattack);
					
			
			
			
	
		
	
	*/
	
	
	#define constants related to game here	
	
	$e = M_E;
	
	
	function fetch_data()
	{
		$dt = db_connect();
		$res = $dt->query("SELECT * FROM `Game_Data` WHERE 1;");
		if(!$res)
			return NULL;
		$row = $res->fetch_assoc();
		if($res->fetch_assoc()){
			$dt->close();
			return NULL;
		}
		return $row;
	}
	
	function update_data($dataname,$value)
	{
		$dt = db_connect();
		$dt->query("UPDATE `Game_Data` SET `$dataname` = $value WHERE 1;");
		close_db($dt);
		
	}
	
	#define attacks here
	
	// Boss Attacks
	
	// t indicates time (second) , h indicates boss health % (0-1) , 
	// ex indicates extra damage , a indicates amplifier
	// attr indicates attack rate
	
	function damage_boss_attack_p1($t,$h,$ex,$a,$attr)
	{
		$coeff = 150+$ex;
			
		$dmg = $e + ($x/50.0);
		$dmg = log($dmg);
		$dmg = $dmg*$dmg*0.5;
		$dmg = $dmg*log(200.0/$h);
		$dmg = $dmg+1;
			
		return $coeff*$dmg*$a*$attr;
			
	}
	
	
	
	function damage_boss_attack_p2($t,$h,$ex,$a,$attr)
	{
		$coeff = 275+$ex;
			
		$dmg = $e + ($t/100.0);
		$dmg = log($dmg);
		$dmg = $dmg*$dmg*0.5;
		$dmg = $dmg*log(400.0/$h);
		$dmg = $dmg+1;
			
		return $coeff*$dmg*$a*$attr;
	}
	
	
	//Simply call the function below to execute attack
	
	function execute_boss_attack($phase,$t,$h,$ex,$a,$attr)
	{
		$database = db_connect();
		$data = (($database->query("SELECT * FROM `Game_Data` WHERE 1;"))->fetch_assoc())
		$stunexp = $data['stun_expire'];
		$stunned = $data['boss_stun'];
		if($stunned)
		{
			if(time() >= $stunexp)
				$stunned = 0;
		}
		if(!$stunned)
		{
				if($phase == 1)
					$dd = damage_boss_attack_p1($t,$h,$ex,$a,$attr);
				else
					$dd = damage_boss_attack_p2($t,$h,$ex,$a,$attr);
				
			$cdd = $data['boss_process'];
			$cdd += $dd;
			
			$database->query("UPDATE `Game_Data` SET `boss_process` = $cdd WHERE 1;");	
		}
		close_db($database);
		return NULL;
	}
	
	//Student Attacks
	
	function damage_student_attack($t,$ex,$a,$attr)
	{
		$coeff = 100+$ex;
			
		$dmg = $e + ($x/50.0);
		$dmg = log($dmg);
		$dmg = $dmg*$dmg;
		$dmg = $dmg+1;
			
		return $coeff*$dmg*$a*$attr;
	}
	
	function execute_student_attack($t,$h,$ex,$a,$attr)
	{
		$database = db_connect();
		$data = (($database->query("SELECT * FROM `Game_Data` WHERE 1;"))->fetch_assoc())
	
		if(True) #Ctrl C & Ctrl V is awesome
		{
			$dd = damage_student_attack($t,$h,$ex,$a,$attr);
				
			$cdd = $data['student_process'];
			$cdd += $dd;
			
			$database->query("UPDATE `Game_Data` SET `student_process` = $cdd WHERE 1;");	
		}
		close_db($database);
		return NULL;
	}
	
	// Item Usage
	
	//Modify Boss Damage Multiplier
	
	function item_modify_boss_extra($amount)
	{
		$database = db_connect();
		$old = (($database->query("SELECT `extra_boss` FROM `Game_Data` WHERE 1;"))->fetch_assoc())['extra_boss'];
		$old*=$amount;
		$database->query("UPDATE `Game_Data` SET `extra_boss` = $old WHERE 1;");
		close_db($database);
		return NULL;
		
	}
	
	
	
	function item_modify_boss_amp($amount)
	{
		$database = db_conect();
		$old = (($database->query("SELECT `amp_boss` FROM `Game_Data` WHERE 1;"))->fetch_assoc())['extra_boss'];
		$old*=$amount;
		$database->query("UPDATE `Game_Data` SET `amp_boss` = $old WHERE 1;");
		close_db($database);
		return NULL;
	}
	
	//Modify Student Damage Multiplier
	
	function item_modify_student_extra($amount)
	{
		$database = db_conect();
		$old = (($database->query("SELECT `extra_student` FROM `Game_Data` WHERE 1;"))->fetch_assoc())['extra_boss'];
		$old*=$amount;
		$database->query("UPDATE `Game_Data` SET `extra_student` = $old WHERE 1;");
		close_db($database);
		return NULL;
	}
	function item_modify_student_amp($amount)
	{
		$database = db_conect();
		$old = (($database->query("SELECT `amp_student` FROM `Game_Data` WHERE 1;"))->fetch_assoc())['extra_boss'];
		$old*=$amount;
		$database->query("UPDATE `Game_Data` SET `amp_student` = $old WHERE 1;");
		close_db($database);
		return NULL;
	}
	
	//stuns boss for N seconds
	
	function item_effect_boss_stun($duration)
	{
		$database = db_conect();
		$stexp = time()+$duration;
		$database->query("UPDATE `Game_Data` SET `stun_expire` = $stexp WHERE 1;");
		$database->query("UPDATE `Game_Data` SET `boss_stun` = 1 WHERE 1;");
		close_db($database);
		return NULL;
	}
	
	
	
	
	
?>
