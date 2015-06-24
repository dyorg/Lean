<?php
namespace Lean\Utils;

class Hash
{
	const NUMERIC = '0123456789';
	
	const ALPHA = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';
	
	const ALPHA_ONLY_UPPER = 'ABCDEFGHIJKLMNOPQRSTUWXYZ';
	
	const ALPHA_ONLY_LOWER = 'abcdefghijklmnopqrstuwxyz';
	
	const SYMBOLS = '!@#$%&*-+?:|';
	
	const ALL = '99';
	
	/**
	 * Cria um hash
	 * 
	 * <code>
	 * Hash::generate(8, Hash::ALPHA);
	 * Hash::generate(5, Hash::ALPHA_ONLY_UPPER);
	 * Hash::generate(8, Hash::ALPHA_ONLY_LOWER . Hash::NUMERIC);
	 * Hash::generate(10, Hash::SYMBOLS);
	 * Hash::generate(10, Hash::ALL);
	 * </code>
	 * 
	 * @param integer $sizeof Tamanho do hash a ser criado
	 * @param string $caracters
	 * @return hash
	 */
	static public function generate($sizeof = 8, $caracters = self::NUMERIC)
	{
		$hash = NULL;
		
    	for ($i = 0; $i < $sizeof; $i++) {
        	$hash .= substr($caracters, rand(0, strlen($caracters)-1), 1);
    	}
    		
    	return $hash;
	}
}