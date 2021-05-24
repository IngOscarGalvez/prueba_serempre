<?php

namespace App\Exports;

use App\Scanresult;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ScanresultExport implements FromQuery
{

    use Exportable;
    /**
     * @var int
     */
    private $scan_id;
    /**
     * @var int
     */
    private $tipo_id;
    /**
     * @var string
     */
    private $tipo;

    /**
     * @param int $tipo
     * @param int $scan_id
     * @param int $tipo_id
     */
    public function __construct(int $tipo,int $scan_id,int $tipo_id)
    {
        $this->tipo=$tipo;
        $this->scan_id=$scan_id;
        $this->tipo_id=$tipo_id;
    }

    /**
     * @inheritDoc
     */
    public function query()
    {
        switch ($this->tipo){
            case 1:

                $query=Scanresult::query()->where([['scan_id','=',$this->scan_id],['modules_id','=',$this->tipo_id]])->select('source','data','risk');
                return $query;
                break;

            case 2:
                return Scanresult::query()->where([['scan_id','=',$this->scan_id],['eventtypes_id','=',$this->tipo_id]])->select('source','data','risk');
                break;
        }
    }
}
