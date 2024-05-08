<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\AboutUs;
use App\Models\Module;
use App\Models\BedFloor;
use App\Models\BedGroup;
use App\Models\BedList;
use App\Models\BedType;
use App\Models\DoctorOrder;
use App\Models\DohInfoClassification;
use App\Models\HospitalCharge;
use App\Models\HospitalChargeCategory;
use App\Models\HospitalPhysicianCharge;
use App\Models\InventoryIssue;
use App\Models\InventoryItemStockList;
use App\Models\Pathology;
use App\Models\Patient;
use App\Models\PatientApproval;
use App\Models\PatientOPD;
use App\Models\Radiology;
use App\Models\PatientImgResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GenericResourceCollection extends JsonResource
{
    protected $hiddenFields = [];
    protected $alwaysVisibleFields = [];
    protected $use24HourFormat = false;

    public function setHiddenFields(array $fields)
    {
        $this->hiddenFields = $fields;
    }

    public function setAlwaysVisibleFields(array $fields)
    {
        $this->alwaysVisibleFields = $fields;
    }

    public function set24HourFormat($value)
    {
        $this->use24HourFormat = $value;
    }

    public function toArray(Request $request): array
    {
        // Start with an empty response
        if(!$this->resource) {
            return [];
        }

        $response = [];

        foreach ($this->alwaysVisibleFields as $field) {
            $response[$field] = $this->resource->{$field} ?? null;
        }

        // Retrieve all attributes and filter out hidden ones for this model
        foreach ($this->resource->getAttributes() as $attribute => $value) {
            if (!in_array($attribute, $this->hiddenFields) && !array_key_exists($attribute, $response)) {
                $response[$attribute] = $value;
            }
        }

        // Format the date
        if (isset($this->resource->created_at)) {
            // $response['created_at'] = $this->resource->created_at->format('d M Y h:i A');
            $response['created_at'] = $this->use24HourFormat
                ? $this->resource->created_at->format('H:i')
                : $this->resource->created_at->format('d M Y h:i A');
        }

        return $response;
    }
}
