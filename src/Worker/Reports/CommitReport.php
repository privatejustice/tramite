<?php

namespace Tramite\Worker\Reports;

/**
 * CommitReport Class
 *
 * @class   CommitReport
 * @package life
 */
class CommitReport
{

    protected $url = false;
    
    public function __construct()
    {
        
    }
    
    public function filters()
    {
        return [
            'by_author' => '',
        ];
    }

    /**
     * O func_params padrão é null. null nao faz nada. É o total, inclui todos os filtros
     * 
     * Cada o func_params seja preenchido, então ele se diferenciará dos outros registros
     */
    public function criarRelatorio()
    {
        Commit::all();

        // @todo Fazer
        $commitsDoDia = [

        ];
    }

    /**
     * Exemplo
     */



     /**
      *  Relatório de Commits por Dia
      *   filliable_type = Commits
      *   periodo = 
      */
}
