<?php

namespace Gibdd\Core;

class VeteranMapper
{
    private \stdClass $data;
    private int $veteranId;
    private int $dutyId;
    private int $organisationId;

    public function __construct(\stdClass $data)
    {
        $this->data = $data;
    }

    public function mappedVeteranRow(): array
    {
        $mappedRow = [
            'id' => $this->veteranId ?? null,
            'first_name' => $this->data->firstName ?? null,
            'last_name' => $this->data->lastName ?? null,
            'middle_name' => $this->data->middleName ?? null,
            'birth_date' => $this->data->birthDate ?? null,
            'district' => $this->data->district ?? null,
            'address' => $this->data->address ?? null,
            'mobile_phone' => $this->data->mobilePhone ?? null,
            'reserve_phone' => $this->data->reservePhone ?? null,
            'email' => $this->data->email ?? null,
            'disability' => $this->data->disability ?? null,
            'additionally' => $this->data->additionally ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function addVeteranId(int $id): int
    {
        return $this->veteranId = $id;
    }

    public function mappedPassportRow(): array
    {
        $mappedRow = [
            'id' => $this->data->id ?? null,
            'serial' => $this->data->serial ?? null,
            'number' => $this->data->number ?? null,
            'date_of_issue' => $this->data->dateOfIssue ?? null,
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
            'length_service_traffic_police' => $this->data->lengthServicePolice ?? null,
            'duty_status' => $this->data->dutyStatus ?? null,
            'retirement_year' => $this->data->retirementYear ?? null,
            'awards' => $this->data->awards ?? null,
            'hostilities_participation' => $this->data->hostilitiesParticipation ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

    public function addOrganisationId(int $id): int
    {
        return $this->organisationId = $id;
    }

    public function mappedOrganisationRow(): array
    {
        $mappedRow = [
            'id' => $this->organisationId ?? null,
            'certificate_number' => $this->data->certNumber ?? null,
            'certificate_validity' => $this->data->validity ?? null,
            'role' => $this->data->role ?? null,
            'status' => $this->data->status ?? null,
            'joining_year' => $this->data->joiningYear ?? null,
        ];

        return array_diff($mappedRow, array(null));
    }

}
