<?php

namespace Tramite\Worker\Reports;


/**
 * Report Class
 *
 * @class   Report
 * @package life
 */
class Report
{

    protected $url = false;
    
    public function __construct()
    {
        
    }

    /**
     * O func_params padrão é null. null nao faz nada. É o total, inclui todos os filtros
     * 
     * Cada o func_params seja preenchido, então ele se diferenciará dos outros registros
     */
    public function colunas()
    {
        return [
            'filliable_id' => '', // Identificador Opcional
            'filliable_type' => '', // RElatorio gerado
            'periodo' => '', // Pode ser por dia, por hora, por minuto, etc... 
            'result' => '', // resultado
            'func' => '',  // Função que é chamada para gerar o relatório
            'func_params' => ''  // Opcional
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
