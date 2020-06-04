<?php

namespace Tramite\Identify;

use League\Pipeline\Pipeline;
use League\Pipeline\StageInterface;

class FileType
{
    public static function run($file)
    {

    }
        
    public static function excell($eloquentClasses)
    {
        
        // $collection = (new FastExcel)->configureCsv(';', '#', '\n', 'gbk') //, 'gbk'
        // // $collections = (new FastExcel)
        // ->import(
        //     storage_path('app/'.$file),
        //     function ($line) use ($fileName, $assuntosDaPasta) {

                
        //         $arrayData = [];

        //         // Caso Finances
        //         $modelClass = \Casa\Models\Economic\Gasto::class;
        //         foreach ($line as $name=>$column) {
        //             $name = StringModificator::clean($name);
        //             $column = StringModificator::clean($column);
        //             $indice = 'obs';
        //             // $arrayData[$name] = $column;
        //             if ($name == 'DATA') {
        //                 $indice = 'data';
        //             } else if ($name == 'VALOR') {
        //                 $indice = 'value';
        //                 $column = floatval($column);
        //                 // $indice = 'amount';
        //             } else if ($name == 'TIPO') {
        //                 // $indice = 'type';
        //                 $indice = 'description';
        //             }

        //             $arrayData[$indice] = $column;
        //         }

        //         dd(
        //             $line,
        //             $modelClass.'::create',
        //             $arrayData
        //         );

        //         $this->info('Importing '.$fileName);
        //         return call_user_func(
        //             $modelClass.'::create',
        //             $arrayData
        //         );
        //     }
        // );
    }
}