<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\GenericResourceCollection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;

class GenericResource extends ResourceCollection
{
    protected $hiddenFields = [];
    // protected $alwaysVisiblefields = [];
    protected $columns = [];
    protected $tblNames;
    protected $displayFields = [];

    protected $use24HourFormat = true;
    public function setHiddenFields(array $fields)
    {
        $this->hiddenFields = $fields;
    }

    // public function setAlwaysVisibleFields(array $fields)
    // {
    //     $this->alwaysVisiblefields = $fields;
    // }

    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    public function setTableName($tableNames)
    {
        $this->tblNames = $tableNames;
    }

    public function setDisplayFields(array $displayFields)
    {
        $this->displayFields = $displayFields;
    }

    public function set24HourFormat($use24HourFormat)
    {
        $this->use24HourFormat = $use24HourFormat;
    }


    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $columns = $this->tblNames ? array_intersect(Schema::getColumnListing($this->tblNames), $this->displayFields) : [];

        $data = $this->collection->transform(function($item) use($request) {
            if($item) {
                $resource = new GenericResourceCollection($item);
                // $resource->setHiddenFields($this->hiddenFields);
                // $resource->setAlwaysVisibleFields($this->alwaysVisibleFields);
                $resource->set24HourFormat($this->use24HourFormat);
                return $resource->toArray($request);
            }
            return [];
        });

        $response = [
            'columns' => $columns,
            'data' => $data
        ];

        if($this->resource instanceof LengthAwarePaginator) {
            $response['pagination'] = [
                'total' => $this->resource->total(),
                'count' => $this->resource->count(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage(),
            ];
        }

        return $response;
    }
}
