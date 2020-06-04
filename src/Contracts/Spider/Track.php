<?php
namespace Tramite\Contracts\Spider;

use Tramite\Logic\Output\AbstractOutput;
use Tramite\Logic\Output\Filter\OutputFilterInterface;
use Tramite\Logic\Output\TriggerableInterface;

use Symfony\Component\Tramite\Finder;

use Tramite\Spider\File;
use Tramite\Spider\Directory;
use Tramite\Spider\Registrator\FileRegistrator;
use Tramite\Spider\Metrics\FileMetric;

use Support\Helps\DebugHelper;

/**
 * Run all script analysers and outputs their result.
 */
abstract class Track
{
    protected $model = false;
    protected $parent = false;

    protected $subTracks = [];
    protected $informate = [];

    public function __construct($model, $parentTrack = false)
    {
        $this->setModel($model);
        $this->setParent($parentTrack);
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getModel()
    {
        return $this->model;
    }

    protected function setModel($model)
    {
        $this->model = $model;
    }


    /**
     * 
     */
    public function addSubTrack(Track $track)
    {
        $this->subTracks[] = $track;
    }
    public function getSubTrack()
    {
        return $this->subTracks;
    }


    /**
     * 
     */
    public function addInformateArray($array)
    {
        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $indice => $valor) {
            $this->addInformate($indice, $valor);
        }
        return true;
    }
    public function addInformate($name, $valor)
    {
        $this->informate[$name] = $valor;
    }
    public function getInformate($name)
    {
        if (!isset($this->informate[$name]) || empty($this->informate[$name])) {
            return false;
        }

        return $this->informate[$name];
    }

    /**
     *  Passa informacao pro pai
     */
    public function saveInformate($array)
    {
        foreach ($array as $informate) {
            if ($informateInfo = $this->getInformate($informate[0])) {
                $informate[1]($informateInfo);
            }
        }
    }



    /**
     * 
     */
    public function exec()
    {
        // Carrega oq Precisa
        $this->loadSubTracks();

        // Roda
        $this->run();

        // ROdando os FIlhos
        if (is_array($trackingsChields = $this->getSubTrack())) {
            foreach ($trackingsChields as $trackingsChield) {
                $trackingsChield->exec()->saveInformate(
                    $this->collectInformateFromSubTracks()
                );
            }
        }

        return $this;
    }



    /**
     * 
     */
    public function loadSubTracks()
    {
        foreach ($this->subTracks() as $relation => $classTrack) {
            $results = $this->model->$relation()->get();
            foreach ($results as $result) {
                $this->addSubTrack(new $classTrack($result));
            }
        }
    }



    /**
     * Reescrever
     */


    public function subTracks()
    {
        return [
            
        ];
    }

    public function run()
    {
        return true;
    }
}