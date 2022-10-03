<?php
namespace App\Common;

class Environment
{
    /**
     * Insere variáveis de ambiente
     * @param string $dir
     * @return bool
     */

    public static function load(string $dir): bool
    {
        if(!file_exists($dir))
        {
            return false;
        }

        $lines = file($dir); // lendo linhas do arquivo com as variáveis de ambiente
        foreach($lines as $line)
        {
            putenv(trim($line));          
        }
        
        return true;
    }
}