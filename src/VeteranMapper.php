<?php

namespace Gibdd\Core;

class VeteranMapper
{
    private \stdClass $data;
    private int $passportId;
    private int $dutyId;
    private int $retirementId;

    public function __construct(\stdClass $data)
    {
        $this->data = $data;
    }

    public function mappedVeteranRow(): array
    {
        $mappedRow = [
            'id' => $this->data->id ?? null,
            'first_name' => $this->data->firstName ?? null,
            'last_name' => $this->data->lastName ?? null,
            'middle_name' => $this->data->middleName ?? null,
            'birth_date' => $this->data->birthDate ?? null,
            'live_address' => $this->data->liveAddress ?? null,
            'mobile_phone' => $this->data->mobilePhone ?? null,
            'reserve_phone' => $this->data->reservePhone ?? null,
            'email' => $this->data->email ?? null,
            'additionally' => $this->data->additionally ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function addPassportId(int $id): int
    {
        return $this->passportId = $id;
    }

    public function mappedPassportRow(): array
    {
        $mappedRow = [
            'id' => $this->passportId ?? null,
            'address' => $this->data->passportAddress ?? null,
            'serial_number' => $this->data->passport ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function addDutyId(int $id): int
    {
        return $this->dutyId = $id;
    }

    public function mappedDutyRow(): array
    {
        $mappedRow = [
            'id' => $this->dutyId ?? null,
            'rank' => $this->data->rank ?? null,
            'length_service' => $this->data->lengthService ?? null,
            'length_service_police' => $this->data->lengthServicePolice ?? null,
            'retirement_status' => $this->data->retirementStatus ?? null,
            'retirement_year' => $this->data->retirementYear ?? null,
            'duty' => $this->data->duty ?? null,
            'awards' => $this->data->awards ?? null,
            'disability' => $this->data->disability ?? null,
            'hostilities_participation' => $this->data->hostilitiesParticipation ?? null,
            'additionally' => $this->data->additionally ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function addRetirementId(int $id): int
    {
        return $this->retirementId = $id;
    }

    public function mappedRetirementRow(): array
    {
        $mappedRow = [
            'id' => $this->retirementId ?? null,
            'certificate_number' => $this->data->certificateNumber ?? null,
            'certificate_validity' => $this->data->certificateValidity ?? null,
            'status' => $this->data->status ?? null,
            'year_entry_to_veteran_org' => $this->data->yearEntryToVeteranOrg ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

}
